<?php 

include "navbar.php"; 
include "sidebar.php";

$name = $_SESSION['admin_name'];
/*
$queryUser = "SELECT * FROM `users` WHERE user_name = $name";
$resultUser = mysqli_query($link, $queryUser);
$userId = 0;
if ($resultUser) {
$rowUser = mysqli_fetch_array($resultUser);
$userId = $rowUser['user_id'];
}*/

//Kullanıcılar
$query = "SELECT * FROM `customers` ";
$result = mysqli_query($link, $query);
$total = 0;
if ($result) {
  $row = mysqli_fetch_array($result);
  $total = mysqli_num_rows($result);
} else {
  $total == 0;
}


?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Anasayfa</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          
         

        
                  
          
  
     
        </div>
      </section>  
  </div>
  <!-- /.content-wrapper -->
  <?php include "footer.php"; ?>
</body>
</html>
