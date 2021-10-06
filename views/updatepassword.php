<?php 

include "netting/connection.php"; 


$customerId=$_GET['customer_id'];


$query = "SELECT * FROM customers WHERE customer_id = $customerId";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OKTOPOWER | KAYIT</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <b>OKTOPOWER</b>
    <p>PAROLA YENİLEME</p>
  </div>

  <div class="row">
            <div class="col-md-12">  
                <?php 
                if(isset($_GET['dur'])) {

                    if ($_GET['dur'] == 'already') { ?>
                    <h5 class='alert alert-danger' role='alert'><p>Bu e-posta adresi zaten kayıtlı!</p></h5>
                    <?php }

                    if ($_GET['dur'] == 'noname') { ?>
                    <h5 class='alert alert-danger' role='alert'><p>Lütfen adınızı giriniz.</p></h5>
                    <?php }
                    
                    if ($_GET['dur'] == 'nosurname') { ?>
                    <h5 class='alert alert-danger' role='alert'><p>Lütfen soyadınızı giriniz.</p></h5>
                    <?php }

                    if ($_GET['dur'] == 'nopass') { ?>
                    <h5 class='alert alert-danger' role='alert'><p>Lütfen parolanızı giriniz.</p></h5>
                    <?php } 

                    if ($_GET['dur'] == 'no') { ?>
                    <h5 class='alert alert-danger' role='alert'><p>Girdiğiniz parolalar eşleşmiyor!</p></h5>
                    <?php }  

                    if ($_GET['dur'] == 'nomail') { ?>
                    <h5 class='alert alert-danger' role='alert'><p>Lütfen e-posta adresini giriniz.</p></h5>
                    <?php }  

                    if ($_GET['dur'] == 'nokayit') { ?>
                    <h5 class='alert alert-danger' role='alert'><p>Kayıt yapılamadı! Lütfen tekrar deneyiniz.</p></h5>
                    <?php }  

                    if ($_GET['dur'] == 'yes') { ?>
                    <h5 class='alert alert-success' role='alert'><p>Kayıt başarıyla yapıldı.</p></h5>

                    <?php } } ?>

            </div>
        </div>     <!-- /. ROW  -->

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Yeni Parola</p>

      <form  action="netting/function.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="customerId" value="<?php echo $customerId; ?>">
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Parola" name="parola">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Parola Tekrar" name="reparola">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="updatePassword">Güncelle</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

     

      
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
