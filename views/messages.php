<?php 


include "navbar.php"; 
include "sidebar.php";

$name = $_SESSION['user_name'];

$queryUser = "SELECT * FROM `users` WHERE user_name = '$name'";
$resultUser = mysqli_query($link, $queryUser);
//$userId = 0;
if ($resultUser) {
$rowUser = mysqli_fetch_array($resultUser);
$userId = $rowUser['user_id'];
if ($rowUser['user_privilage']==0) {
  header("Location: ../views/index.php");
}
}

?>
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Mesajlar</h1>   
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Anasayfa</a></li>
              <li class="breadcrumb-item active">Kullanıcılar</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    </section>

    <?php  

        if(isset($_GET['durum'])) {

        if ($_GET['durum'] == 'silindi') { 
            // This is in the PHP file and sends a Javascript alert to the client
            $message = "Kullanıcı Silindi!";
            echo "<script type='text/javascript'>alert('$message');</script>"; ?>

        <?php } else if ($_GET['durum'] == 'silinmedi') { 
                // This is in the PHP file and sends a Javascript alert to the client
                $message = "Kullanıcı Silinemedi!";
                echo "<script type='text/javascript'>alert('$message');</script>"; ?>

        <?php }  } ?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Yeni Mesajlar</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>İsim Soyisim </th>
                    <th>Uyarı</th>
                    
                    
                  </tr>
                  </thead>
                  <tbody>
                  <?php

                    $query = "SELECT * FROM `conversations` 
                    WHERE ifread = '0' 
                    GROUP BY customer_id ";
                     
                    
                    $result = mysqli_query($link, $query);
                    while($row = mysqli_fetch_array( $result)) { 
                    
                      $customerId = $row['customer_id'];

                      if ($row['ifread']==0) {
                        $check = "Yeni Mesaj";
                      } else {
                        $check = "";
                      }
        
                      $queryCustomer = "SELECT * FROM customers WHERE customer_id = $customerId";
                      $resultCustomer = mysqli_query($link, $queryCustomer);
                      $rowCustomer = mysqli_fetch_array( $resultCustomer);
                   
                ?>
                  <tr>
                    <td>
                    <form  action="../netting/function.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="adminUserId" value="<?php echo $userId; ?>">
                    <input type="hidden" name="customer_id" value="<?php echo $customerId; ?>">
                    <button  name="updateCon" type="submit" class="btn btn-primary">
                      <?php echo $rowCustomer['customer_name'].' '.$rowCustomer['customer_surname'];?> </button></form></td>
                    
                    <td><?php echo $check; ?></td>
                    
                  </tr>
                  <?php } ?>
                  
                  
                  </tbody>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>





    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tüm Mesajlar</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>İsim Soyisim </th>
                    <th>Uyarı</th>
                    
                    
                  </tr>
                  </thead>
                  <tbody>
                  <?php

                    $query = $query = "SELECT * FROM `conversations` 
                    WHERE admin_user_id = $userId 
                    GROUP BY customer_id
                    ORDER BY customer_time 
                    ";
                    
                    $result = mysqli_query($link, $query);
                    while($row = mysqli_fetch_array( $result)) { 
                    
                      $customerId = $row['customer_id'];

                      if ($row['ifread']==0) {
                        $check = "Yeni Mesaj";
                      } else {
                        $check = "";
                      }
        
                      $queryCustomer = "SELECT * FROM customers WHERE customer_id = $customerId";
                      $resultCustomer = mysqli_query($link, $queryCustomer);
                      $rowCustomer = mysqli_fetch_array( $resultCustomer);
                   
                ?>
                  <tr>
                    <td>
                    <form  action="../netting/function.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="adminUserId" value="<?php echo $userId; ?>">
                    <input type="hidden" name="customer_id" value="<?php echo $customerId; ?>">
                    <button  name="updateCon" type="submit" class="btn btn-primary">
                      <?php echo $rowCustomer['customer_name'].' '.$rowCustomer['customer_surname'];?> </button></form></td>
                    
                    <td><?php echo $check; ?></td>
                    
                  </tr>
                  <?php } ?>
                  
                  
                  </tbody>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>

    
</div>
<?php include "footer.php"; ?>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
  