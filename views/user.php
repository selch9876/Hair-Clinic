<?php 

    include "navbar.php"; 
    include "sidebar.php";
    
    $name = $_SESSION['admin_name'];

    $queryUser = "SELECT * FROM `users` WHERE user_name = $name";
    $resultUser = mysqli_query($link, $queryUser);
    $userId = 0;
    if ($resultUser) {
    $rowUser = mysqli_fetch_array($resultUser);
    $userId = $rowUser['user_id'];
    }

   
  // Profile Image
    $file = $row['customer_image'];
    if (!file_exists($file))
    $file = 'assets/img/defaultcustomer.png';

  //Yağ oranı
    if ($height != 0 || $weight != 0) {
      $yagOrani = $height/$weight*10;
    } else {
      $yagOrani = 0;
    }

    $yagOrani = round($yagOrani);

    //Cinsiyet 
    if ($gender == 'Erkek') {
      $gender = "Erkek";
    } else if ($gender == 'Kadın') {
      $gender = "Kadın";
    } else {
      $gender = "Belirtilmemiş";
    } 
    
    

 ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Kullanıcı Bilgileri </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Anasayfa</a></li>
              <li class="breadcrumb-item active">Kullanıcıları Bilgileri</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <?php 

    if(isset($_GET['durum'])) {

      
    if ($_GET['durum'] == 'yes') { ?>
        <h1 style="color: green;" class="page-subhead-line">Kullanıcı başarıyla düzenlendi.</h1>

    <?php } else if ($_GET['durum'] == 'no') { ?>
        <h1 style="color: red;" class="page-subhead-line">Kullanıcı düzenlenemedi!</h1>
    <?php } else if ($_GET['durum'] == 'silindi') { 
        // This is in the PHP file and sends a Javascript alert to the client
        $message = "Antrenman Silindi!";
        echo "<script type='text/javascript'>alert('$message');</script>"; ?>

    <?php } else if ($_GET['durum'] == 'nutritionsilindi') { 
            // This is in the PHP file and sends a Javascript alert to the client
            $message = "Beslenme Programı Silindi!";
            echo "<script type='text/javascript'>alert('$message');</script>"; ?>

    <?php }  } ?>
        
    

<!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?php echo $file; ?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $row['customer_name']; echo " "; echo $row['customer_surname']; ?></h3>

                <p class="text-muted text-center"><?php echo $row['customer_email']; ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Yaş</b> <a class="float-right"><?php echo $row['age']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Boy</b> <a class="float-right"><?php echo $height; ?> cm</a>
                  </li>
                  <li class="list-group-item">
                    <b>Kilo</b> <a class="float-right"><?php echo $weight; ?> kg</a>
                  </li>
                  <li class="list-group-item">
                    <b>Cinsiyet</b> <a class="float-right"><?php echo $gender; ?> </a>
                  </li>
                  <li class="list-group-item">
                    <b>Yağ Oranı</b> <a class="float-right">% <?php echo $yagOrani; ?></a>
                  </li>
                </ul>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary" style="display: none;">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Antrenman Programı</a></li>
                  <li class="nav-item"><a class="nav-link" href="#nutrition" data-toggle="tab">Haftalık Beslenme</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Kişiselleştirilmiş Antrenman</a></li>
                </ul>
                <nav class="mt-4">
                      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item ">
                          <a href="#" class="nav-link active btn btn-success"> 
                            <p>
                              Yeni Ekle
                              <i class="right fas fa-angle-left"></i>
                            </p> 
                          </a>
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="addtraining.php?customer_id=<?php echo $row['customer_id'];?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Antrenman Programı Ekle</p>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="addnutrition.php?customer_id=<?php echo $row['customer_id'];?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Beslenme Programı Ekle</p>
                              </a>
                            </li>
                          </ul>
                        </li>
                      </ul>
                    </nav>
            
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">  
                  <?php 
                            $query = "SELECT * FROM `training`  WHERE customer_id = $customerId ORDER BY train_day";
                            $result = mysqli_query($link, $query);
                            while ($row = mysqli_fetch_array($result)) { 
                              //Antrenman Günleri
                              if ($row['train_day']=="Day 1") {
                                $day ="1. Gün";
                              } else if ($row['train_day']=="Day 2") {
                                $day ="2. Gün";
                              } else if ($row['train_day']=="Day 3") {
                                $day ="3. Gün";
                              } else if ($row['train_day']=="Day 4") {
                                $day ="4. Gün";
                              } else if ($row['train_day']=="Day 5") {
                                $day ="5. Gün";
                              } else if ($row['train_day']=="Day 6") {
                                $day ="6. Gün";
                              } else if ($row['train_day']=="Day 7") {
                                $day ="7. Gün";
                              } else if ($row['train_day']=="") {
                                $day = "";
                              } ?>
                               
                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                      <img class="img-circle img-bordered-sm" src="assets/img/Exclamation.png" alt="user image">
                      
                        <span class="username">
                          <a href="#"><?php echo $day; echo " "; echo $row['train_header']; ?></a>
                        </span>
                        <span class="description"><?php echo $row['train_note']; ?></span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                      <?php echo $row['train_body'];?>
                      </p>
                      <td><a href="trainingset.php?customer_id=<?php echo $row['customer_id']; ?>&train_id=<?php echo $row['train_id']; ?>&trainDay=<?php echo $row['train_day']; ?>&trainHeader=<?php echo $row['train_header']; ?>"><button class="btn btn-primary">Düzenle</button></a></td>
                      <td><a href="netting/function.php?train_id=<?php echo $row['train_id'];?>&customer_id=<?php echo $row['customer_id']; ?>&trainsil=ok"><button class="btn btn-danger" name="sil" onclick="return confirm('Antrenman silinecek, emin misiniz?')">Sil</button></a></td>
                    </div>
                    <!-- Modal -->
             
                    <?php } ?>
                    <!-- Button trigger modal -->
              

              
                      
                    <!-- /.post -->

                    
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="nutrition">
                  <?php 
                            $query = "SELECT * FROM `nutrition` WHERE customer_id = $customerId ORDER BY meal";
                            $result = mysqli_query($link, $query);
                            while ($row = mysqli_fetch_array($result)) { ?>
                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                      <img class="img-circle img-bordered-sm" src="assets/img/Exclamation.png" alt="user image">
                      
                        <span class="username">
                          <a href="#">Öğün <?php echo $row['meal']; echo " "; echo $row['nutrition_header']; ?></a>
                        </span>
                        <span class="description"><?php echo $row['nutrition_note']; ?></span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                      <?php echo $row['nutrition_body'];?>
                      </p>
                      <td><a href="nutritionset.php?customer_id=<?php echo $row['customer_id']; ?>&nutrition_id=<?php echo $row['nutrition_id']; ?>&nutritionMeal=<?php echo $row['meal']; ?>&nutritionHeader=<?php echo $row['nutrition_header']; ?>"><button class="btn btn-primary">Düzenle</button></a></td>
                      <td><a href="netting/function.php?nutrition_id=<?php echo $row['nutrition_id'];?>&customer_id=<?php echo $row['customer_id']; ?>&nutritionsil=ok"><button class="btn btn-danger" name="sil" onclick="return confirm('Beslenme programı silinecek, emin misiniz?')">Sil</button></a></td>
                    </div>
                    <?php } ?>
                      
                    <!-- /.post -->

                    
                  </div>
                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName2" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->    
  <script type="text/javascript">
  
  function showModal(id); {
  var attr = document.getElementById(id).attributes;
  
  if (attr['aria-hidden'].value == "true") {
    document.getElementById(id).setAttribute("aria-hidden", "false");
  } else {
    document.getElementById(id).setAttribute("aria-hidden", "true");
  }

</script>
 <?php include "footer.php"; ?>   
