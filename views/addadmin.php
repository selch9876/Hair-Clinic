<?php

 include "navbar.php"; 
 include "sidebar.php"; 
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Admin Ekle</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Anasayfa</a></li>
              <li class="breadcrumb-item active">Admin Ekle</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

        <div class="row">
            <div class="col-md-12">
                
                <?php 
                if(isset($_GET['dur'])) {
                  if ($_GET['dur'] == 'already') { ?>
                    <h5 class='alert alert-danger' role='alert'><p>Bu kullanıcı zaten kayıtlı!</p></h5>
                    <?php }

                    if ($_GET['dur'] == 'noname') { ?>
                    <h5 class='alert alert-danger' role='alert'><p>Lütfen kullanıcı adı giriniz.</p></h5>
                    <?php }  

                    if ($_GET['dur'] == 'nopass') { ?>
                    <h5 class='alert alert-danger' role='alert'><p>Lütfen parola giriniz.</p></h5>
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

                    if ($_GET['dur'] == 'weak') { ?>
                    <h5 class='alert alert-danger' role='alert'><p>Parola en az 8 karakter uzunluğunda olmalı ve en az bir büyük harf, bir rakam ve bir özel karakter içermelidir.</p></h5>
                    <?php }

                    if ($_GET['dur'] == 'yes') { ?>
                    <h5 class='alert alert-success' role='alert'><p>Kayıt başarıyla yapıldı.</p></h5>

                    <?php } } ?>

            </div>
        </div>     <!-- /. ROW  -->

        <div class="col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading">KAYIT FORMU</div>  
                    <div class="panel-body">
                        <form  action="../netting/function.php" method="POST">
                            <div class="form-group">
                                <label>Admin adını giriniz</label>
                                <input class="form-control" type="text" name="adminName">
                                <p class="help-block"></p>
                            </div>   
                            <div class="form-group">
                                <label>E-posta adresini girin</label>
                                <input class="form-control" type="email" name="eposta">
                                <p class="help-block">Lütfen geçerli bir e-posta adresi giriniz</p>
                            </div>
                            <div class="form-group">
                                <label>Parola Girin</label>
                                <p class="text-muted">Parola en az 8 karakter uzunluğunda olmalı ve en az bir büyük harf, bir rakam ve bir özel karakter içermelidir.</p>
                                <input class="form-control" type="password" name="parola">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label>Parolanızı tekrar girin </label>
                                <input class="form-control" type="password" name="reparola">
                                <p class="help-block"></p>
                            </div>
                                <button type="submit" class="btn btn-success" name="kayit">Kaydet </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      
 <?php include "footer.php"; ?>   
