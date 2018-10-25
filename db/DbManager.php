<?php

namespace App\Db;
use PDO as PDO;
use Exception as Exception;

class DbManager{
  private $dsn = 'pgsql:dbname=cms_udemy;host=localhost;port=5432';
  private $user = 'postgres';
  private $password = 'postgres';
  private $updateData = [];
  private $updateCondition = [];
  private $preparedQeury;
  
  public $dbh;
  function __construct(){
    $this->connect();
  }
  
  private function connect(){
    try{
      $this->dbh = new PDO($this->dsn, $this->user, $this->password);
      $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      var_dump( $e->getMessage() );
      exit;
    }
  }
  
  public function new(){
    var_dump($this->arrowedValues);
    // extract($this->arrowedValues, EXTR_SKIP);
  }
  
  public function get(){
    $query = implode(" ", $this->preparedQuery);
    $result = $this->result($query);
    return $result;
  }
  
  public function find($id){
    $query = $this->selectAll($this->tableName);
    $query .= " where id=";
    $query .= $id;
    $result = $this->result($query);
    return $result;
  }
  
  public function save($data){
    $this->insert($this->tableName, $data);
  }
  
  public function delete($column, $condition){
    $query = "delete from " . $this->tableName . " where " . $column . " = ?;";
    try{
        $stmt = $this->dbh->prepare($query);
        $stmt->execute(array($condition));
      } catch (PDOException $e) {
        var_dump( $e->getMessage() );
      }
  }
  
  public function update(){
    $query = "update ". $this->tableName ." set ";
    foreach ($this->updateData as $key => $value){
      $query .= str_replace(":", "", $key) . "=" . $key . " ";
    }
    $query .= "where ";
    foreach ($this->updateCondition as $key => $value){
      $query .= str_replace(":", "", $key) . "=" . $key . "_cond ";
      $this->updateCondition[$key."_cond"] = $value;
      unset($this->updateCondition[$key]);
    }
    $this->updateFromAssociativeArray($query);
  }
  
  public function setUpdateData($data){
    $this->updateData = $data;
  }
  
  public function setUpdateCondition($data){
    $this->updateCondition = $data;
  }
  
  private function insert($tableName, $data){
    $query = "insert into ". $this->tableName;
    if (array_values($data) === $data) {
      echo '$arrは配列';
    } else {
      $query .= $this->setStatementBeforeInsert($data);
      $this->insertFromAssociativeArray($query, $data);
    }
  }
  
  private function insertFromAssociativeArray($query, $data){
    try{
        $stmt = $this->dbh->prepare($query);
        $stmt->execute($data);
      } catch (PDOException $e) {
        var_dump( $e->getMessage() );
      }
  }
  private function updateFromAssociativeArray($query){
    try{
        $stmt = $this->dbh->prepare($query);
        $data = array_merge($this->updateData, $this->updateCondition);
        var_dump($query);
        $stmt->execute($data);
      } catch (PDOException $e) {
        var_dump( $e->getMessage() );
      }
  }
  
  private function setStatementBeforeInsert($data){
    $columns = [];
    $insertedDataKeys = array_keys($data);
    foreach ($insertedDataKeys as $key){
      $key = str_replace(":", "", $key);
      $columns[]= $key;
    }
    $columns = "(". implode(",", $columns) .")";
    $insertedDataKeys = "(". implode(",", $insertedDataKeys) .");";
    $placehoder = $columns . " VALUES ". $insertedDataKeys;
    return $placehoder;
  }
  
  public function select($selectData){
    $this->preparedQuery[] = "select";
    $this->preparedQuery[] = !is_array($selectData) ? $selectData : implode(",", $selectData);
    array_push($this->preparedQuery, "from", $this->tableName);
    return $this;
  }
  
  public function order($orderString){
    $orderString = !is_array($orderString) ?  $orderString : implode(",", $orderString);
    $this->preparedQuery[] = "order by ". $orderString;
    return $this;
  }
  
  private function result($query){
    $stmt = $this->dbh->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  
}
