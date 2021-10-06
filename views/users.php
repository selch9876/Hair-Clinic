<?php 


include "navbar.php"; 
include "sidebar.php";

$name = $_SESSION['admin_name'];

$queryUser = "SELECT * FROM `admin_users` WHERE admin_name = '$name'";
$resultUser = mysqli_query($link, $queryUser);
//$userId = 0;



?>
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Kullanıcılar</h1>   
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
                <h3 class="card-title"></h3>
              

              <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" id="myInput" name="table_search" class="form-control float-right" placeholder="Ara" onkeyup="myFunction()">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table  class="table table-bordered table-hover" id="myTable">
                  <thead>
                  <tr>
                    <th>İsim Soyisim </th>
                    <th>E-Posta</th>
                    <th>Not</th>
                    <th>5 Foto Görevi</th>
                    <th>Yıkama Görevi</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query = "SELECT * FROM users ORDER BY user_name ASC";
                    $result = mysqli_query($link, $query);
                    while($row = mysqli_fetch_array( $result)) { 
                      $userId = $row['user_id'];

                      $checked = '';
                      $checkedWash = '';
                      if($row['photo_start'] == 1)
                      {
                            $checked = 'checked="checked"';
                            $photoValue = 1;
                      } else {
                        $photoValue = 0;
                      }
                      if($row['wash_start'] == 1)
                      {
                            $checkedWash = 'checked="checked"';
                            $washValue = 1;
                      } else {
                        $washValue = 0;
                      }
                  
                ?>
                  <tr>
                    <td><a href="userpage.php?user_id=<?php echo $row['user_id']; ?>" >
                    <?php echo $row['user_name'].' '.$row['user_surname'];?> </a></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['note']; ?></td>
                    <form action="../netting/function.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                    
                    <td><input type="checkbox" name="photoTask" value=1 id="checkbox" <?php echo $checked; ?>></td>
                    
                    <td><input type="checkbox" name="washTask" value="1" id="checkbox" <?php echo $checkedWash; ?>></td>
                    <td><button type="submit" class="btn btn-success " name="taskButton">Gönder </button></td>
                    </form>
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


  function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
  