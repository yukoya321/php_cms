<?php

namespace App\Db;
use App\Db\DbManager as DbManager;

class Category extends DbManager{
  protected $tableName = "categories";
  protected $arrowedValues = [
    "title"
  ];
}

