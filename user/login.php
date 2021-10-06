
<?php include "database/connection.php";
include "header.php";?>

	<div class="container">
        <div class="row ">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                <div class="panel-body">
                <?php 
                if(isset($_GET['dur'])) {
                if ($_GET['dur'] == 'noname') { ?>
                    <h5 class='alert alert-danger' role='alert'><p>Lütfen e-posta adresinizi giriniz.</p></h5>
                    <?php }  
                    if ($_GET['dur'] == 'nopass') { ?>
                    <h5 class='alert alert-danger' role='alert'><p>Lütfen parola giriniz.</p></h5>
					<?php }
					if ($_GET['dur'] == 'logincheck') { ?>
                    <h5 class='alert alert-danger' role='alert'><p>Lütfen önce giriş yapınız.</p></h5>
                    <?php }
                    if ($_GET['dur'] == 'yes') { ?>
                    <h5 class='alert alert-success' role='alert'><p>Kayıt başarıyla yapıldı.</p></h5>

                    <?php } 
                    if ($_GET['dur'] == 'no') { ?>
                    <h5 class='alert alert-danger' role='alert'><p>Kullanıcı adı ya da parola hatalı!</p></h5>
                    <?php } } ?>

            <p class="login-box-msg">Giriş yapmak için bilgilerinizi girin</p>
              <form action="database/function.php" method="post">            
                
			  <?php include('messages.php'); ?>
            
              <div class="input-group mb-12" >
                <input type="text" class="form-control" name="customerEmail" placeholder="E-Posta Adresiniz">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" placeholder="Parola">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>

			  <div class="input-group mb-3">                            
				<span class="pull-right">
					<a href="code.php">Şifremi unuttum ? </a>
				</span>
			  </div>
            
                      
              <div class="row">
                <div class="col-8">
                  <div class="icheck-primary">
                    <input type="checkbox" id="remember">
                    <label for="remember">
                      Beni Hatırla
                    </label>
                  </div>
                </div> <!-- /.col -->
               
                <div class="col-4">
                  <button type="submit" class="btn btn-primary" name="customerLogin">Giriş Yap</button>
                </div><!-- /.col -->
                
              </div><!-- /.row -->
            </form>
            <a href="register.php" class="text-center">Kayıt Ol</a>
          </div>
		</div>
	</div>
</div>

    </body>
</html>
<?php include "footer.php"; ?>