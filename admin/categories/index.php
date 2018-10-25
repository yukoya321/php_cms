<?php include "../includes/header.php"; ?>
<?php
  $category = new \App\Db\Category();
  $errors = [];
  $title = filter_input(INPUT_POST, "title");
  $delete_id = filter_input(INPUT_GET, "delete");
  if($title){
    $category->save([":title" => $title]);
  }
  if($delete_id){
    $category->delete("id", $delete_id);
    header("Location: ./");
  }
  $result = $category->select("*")->order("id asc")->get();
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
                            categories.php
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
                              <label for="">Category Name</label>
                              <input class="form-control" type="text" name="title">
                            </div>
                            <div class="form-group">
                              <input class="btn btn-primary" type="submit" value="Add">
                            </div>
                          </form>
                        </div>
                        
                        <div class="col-xs-6">
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>ID</th>
                                <th>Title</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($result as $row):?>
                                <tr>
                                  <td><?= $row["id"]; ?></td>
                                  <td><?= $row["title"]; ?></td>
                                  <td><a href="/admin/categories/?delete=<?= $row["id"]; ?>">Delete</a></td>
                                  <td><a href="/admin/categories/edit.php?id=<?= $row["id"]; ?>">Edit</a></td>
                                </tr>
                              <?php endforeach;?>
                            </tbody>
                          </table>
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