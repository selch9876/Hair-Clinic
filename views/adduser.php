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
            <h1 class="m-0">Kullanıcı Ekle</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Anasayfa</a></li>
              <li class="breadcrumb-item active">Kulanıcı Ekle</li>
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
                    <h5 class='alert alert-danger' role='alert'><p>Bu e-posta adresi zaten kayıtlı!</p></h5>
                    <?php }

                    if ($_GET['dur'] == 'weak') { ?>
                    <h5 class='alert alert-danger' role='alert'><p>Parola en az 8 karakter uzunluğunda olmalı, en az bir büyük harf, bir rakam ve bir özel karakter içermelidir.</p></h5>
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

        <div class="col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading">KAYIT FORMU</div>  
                    <div class="panel-body">
                        <form  action="../netting/function.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Kullanıcı adını giriniz</label>
                                <input class="form-control" type="text" name="userName">
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label>Kullanıcı soyadını giriniz</label>
                                <input class="form-control" type="text" name="userSurName">
                                <p class="help-block"></p>
                            </div> 
                            <div class="form-group">
                                <label>E-posta adresini girin</label>
                                <input class="form-control" type="email" name="eposta">
                                <p class="help-block">Lütfen geçerli bir e-posta adresi giriniz</p>
                            </div>
                            <div class="form-group">
                                <label>Not girin</label>
                                <textarea name="note" id="" cols="45" rows="2"></textarea>
                                <p class="help-block"></p>
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
                            <h3>Üç Adet Fotoğraf</h3>
                            <div class="row">  <!--image row--> 
                              <div class="col-md-4">  
                                <div class="form-group text-center" >
                                  <span class="img-div">
                                    <div class="text-center img-placeholder"  onClick="triggerClick()">
                                      <h5>Görseli Güncelle</h5>
                                    </div>
                                    <img src="../assets/img/plus.png" onClick="triggerClick()" id="profileDisplay" style="max-width: 100%;">
                                  </span>
                                  <input type="file" name="firstImage" onChange="displayImage(this)" id="profileImage" class="form-control" style="display: none;">
                                  <label>1. Foto</label>
                                </div>
                              </div>

                              <div class="col-md-4">  
                                <div class="form-group text-center" >
                                  <span class="img-div">
                                    <div class="text-center img-placeholder"  onClick="triggerClick2()">
                                      <h5>Görseli Güncelle</h5>
                                    </div>
                                    <img src="../assets/img/plus.png" onClick="triggerClick2()" id="profileDisplay2" style="max-width: 100%;">
                                  </span>
                                  <input type="file" name="secondImage" onChange="displayImage2(this)" id="profileImage2" class="form-control" style="display: none;">
                                  <label>2. Foto</label>
                                </div>
                              </div>

                              <div class="col-md-4">  
                                <div class="form-group text-center" >
                                  <span class="img-div">
                                    <div class="text-center img-placeholder"  onClick="triggerClick3()">
                                      <h5>Görseli Güncelle</h5>
                                    </div>
                                    <img src="../assets/img/plus.png" onClick="triggerClick3()" id="profileDisplay3" style="max-width: 100%;">
                                  </span>
                                  <input type="file" name="thirdImage" onChange="displayImage3(this)" id="profileImage3" class="form-control" style="display: none;">
                                  <label>3. Foto</label>
                                </div>
                              </div>

                            </div><!--end of image row-->

                                <button type="submit" class="btn btn-success" name="register">Kaydet </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      
 <?php include "footer.php"; ?>   
