<?php include "../includes/header.php"; ?>
<?php
  ini_set('display_errors', "On");
  $category = new \App\Db\Category();
  $errors = [];
  $edit_id = filter_input(INPUT_GET, "id");
  $post_datas = filter_input_array(INPUT_POST);
  if($edit_id){
    $result = $category->find($edit_id);
    if(empty($result)){
      header("Location: /admin/". array_pop(explode('/',__DIR__)));
    }
  }
  if($post_datas){
    $category->setUpdateData([":title" => $post_datas["title"]]);
    $category->setUpdateCondition([":id" => $edit_id]);
    $category->update();
    header("Location: ./");
  }
?>
    <div id="wrapper">
        <!-- Navigation -->
        <?php include "../includes/navigation.php";?>
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            categories/edit.php
                            <small>Subheading</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                        <div class="col-xs-6">
                          <form action="" method="post">
                            <div class="form-group">
                              <label for="">Edit Category Name</label>
                              <input class="form-control" type="text" name="title" value="<?= $result[0]["title"]?>">
                            </div>
                            <div class="form-group">
                              <input class="btn btn-primary" type="submit" value="Add">
                            </div>
                          </form>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include "../includes/footer.php";?>