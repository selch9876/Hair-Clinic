<?php include "header.php"; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Selch Login</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
    <div class="container">       
        <div class="row ">             
            <div class="col-md-6">                 
                <div class="panel-body">
                    <form action="netting/function.php" method="post"><hr/>               
                        <?php 
                        if(isset($_GET['dur'])) {
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
                            <h5 class='alert alert-danger' role='alert'><p>Lütfen e-posta adresinizi giriniz.</p></h5>
                            <?php }  

                            if ($_GET['dur'] == 'nokayit') { ?>
                            <h5 class='alert alert-danger' role='alert'><p>Kayıt yapılamadı! Lütfen tekrar deneyiniz.</p></h5>
                            <?php } } ?>

                        <h5>Kayıt olmak için bilgilerinizi girin.</h5><br/>
                        <div class="panel panel-danger">
                            <div class="panel-heading">KAYIT FORMU</div> 
                            <div class="panel-body">
                                <form  action="netting/function.php" method="POST">
                                    <div class="form-group">
                                        <label>Kullanıcı adınızı giriniz</label>
                                        <input class="form-control" type="text" name="userName">
                                        <p class="help-block"></p>
                                    </div>    
                                    <div class="form-group">
                                        <label>E-posta adresinizi girin</label>
                                        <input class="form-control" type="email" name="eposta">
                                        <p class="help-block">Lütfen geçerli bir e-posta adresi giriniz</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Parola Girin</label>
                                        <input class="form-control" type="password" name="parola">
                                        <p class="help-block"></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Parolanızı tekrar girin </label>
                                        <input class="form-control" type="password" name="reparola">
                                        <p class="help-block"></p>
                                    </div>
                                        <button type="submit" class="btn btn-danger" name="kayit">Kayıt Ol </button>
                                </form>
                            </div>
                        </div>     
                            Zaten kayıtlı mısın?  <a href="login.php" >Buraya tıkla </a>  
                    </form>
                </div>             
            </div>     
        </div>
    </div>
<?php include "footer.php"; ?>
</body>
</html>
