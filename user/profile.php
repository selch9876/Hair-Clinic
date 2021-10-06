<?php 


include "header.php";
if (!isset($_SESSION['customer_email'])) {
    header("Location: login.php");
}

//$customerId=$_GET['customer_id'];

$email = $_SESSION['customer_email'];

$query = "SELECT * FROM customers WHERE customer_email = '$email'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_array($result);
$customerId=$row['customer_id'];

$queryShift = "SELECT * FROM detailed_shift WHERE customer_id = '$customerId'";
$resultShift = mysqli_query($link, $queryShift);
$rowShift = mysqli_fetch_array($resultShift);
if ($rowShift) {
  $shiftBody = $rowShift['detailed_shift_body'];
} else {
  $shiftBody = ' ';
}

$queryHealth = "SELECT * FROM health WHERE customer_id = '$customerId'";
$resultHealth = mysqli_query($link, $queryHealth);
$rowHealth = mysqli_fetch_array($resultHealth);
if ($rowHealth) {
  $healthBody = $rowHealth['health_body'];
} else {
  $healthBody = ' ';
}

$queryAllergy = "SELECT * FROM allergy WHERE customer_id = '$customerId'";
$resultAllergy = mysqli_query($link, $queryAllergy);
$rowAllergy = mysqli_fetch_array($resultAllergy);
if ($rowAllergy) {
  $allergyBody = $rowAllergy['allergy_body'];
} else {
  $allergyBody = ' ';
}

//Üyelik Tipi
if ($row['subscription_type']=="Student") {
  $subscriptionType ="Öğrenci";
} else {
  $subscriptionType ="Tam";
}

//Cinsiyet
if ($row['gender']=="M") {
  $gender ="Erkek";
} else if ($row['gender']=="F") {
  $gender ="Kadın";
} else {
  $gender = "Seçilmedi";
}

//Üyelik Paketi
if ($row['package']=="6 Months") {
  $package ="6 Aylık Paket";
} else {
  $package ="12 Aylık Paket";
}


function set_and_enum_values( &$conn, $table , $field )
{
    $query = "SHOW COLUMNS FROM `$table` LIKE '$field'";
    $result = mysqli_query( $conn, $query ) or die( 'Error getting Enum/Set field ' . mysqli_error() );
    $row = mysqli_fetch_row($result);

    if(stripos($row[1], 'enum') !== false || stripos($row[1], 'set') !== false)
    {
        $values = str_ireplace(array('enum(', 'set('), '', trim($row[1], ')'));
        $values = explode(',', $values);
        $values = array_map(function($str) { return trim($str, '\'"'); }, $values);
    }
    return $values;
  }



?>

<!-- Content Wrapper. Contains page content -->
<div class="wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Kullanıcı Bilgilerini Düzenle</h1>
          </div><!-- /.col -->
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <?php 
    if(isset($_GET['durum'])) {
      if ($_GET['durum'] == 'yes') { ?>
          <h1 style="color: green;" class="page-subhead-line">Kullanıcı başarıyla düzenlendi.</h1>
      <?php } elseif ($_GET['durum'] == 'no') { ?>
          <h1 style="color: red;" class="page-subhead-line">Kullanıcı düzenlenemedi!</h1>
      <?php } elseif ($_GET['durum'] == 'bought') { ?>
          <h1 style="color: red;" class="page-subhead-line">Paket Alındı!</h1>
      <?php }  } ?>

    <!-- Profile Image 
    <div class="card card-primary card-outline">
      <div class="card-body box-profile">
        <div class="text-center">
          <img class="profile-user-img img-fluid img-circle"
                src="<?php //echo $file; ?>"
                alt="User profile picture">
        </div>
      </div>
    </div>-->

      <div class="container">
        <div class="row">
        <p class="help-block"><span class="font-weight-bold">Başlangıç Tarihi:</span> <?php echo $row['starting_date'];?></p>
        </div>
        <div class="row">
        <p class="help-block"><span class="font-weight-bold">Bitiş Tarihi:</span> <?php echo $row['ending_date']; ?></p>
        </div>
        <div class="row">
          <?php  $date_expire = $row['ending_date']; 
                  $date = new DateTime($date_expire);
                  $now = new DateTime();
                  $track = $date->diff($now)->format("%m ay %d gün"); 
                  ?>

            <p class="help-block"><span class="font-weight-bold">Kalan Süre:</span> <?php echo $track; ?> </p>
            </div>
            <div class="row">
            <p class="help-block"><span class="font-weight-bold" style="color: red;">* Kaydınızın tamamlanabilmesi ve 
            programınızın atanabilmesi için aşağıdaki bilgileri doldurmanız gerekmektedir.</span></p>
        
            <div class="col-md-12">
              <!--<a href="customerpage.php?customer_id=<?php echo $row['customer_id']; ?>" class="btn btn-sm btn-primary">
              <i class="fas fa-user"></i> Profili Görüntüle
              </a>-->
                <?php 
                if(isset($_GET['dur'])) {
                    if ($_GET['dur'] == 'noname') { ?>
                    <h5 class='alert alert-danger' role='alert'><p>Lütfen kullanıcı adı giriniz.</p></h5>
                    <?php }
                    
                    if ($_GET['dur'] == 'nosurname') { ?>
                    <h5 class='alert alert-danger' role='alert'><p>Lütfen kullanıcı soyadı giriniz.</p></h5>
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

                    if ($_GET['dur'] == 'yes') { ?>
                    <h5 class='alert alert-success' role='alert'><p>Kayıt başarıyla yapıldı.</p></h5>

                    <?php } } ?>

            </div>
        </div>     <!-- /. ROW  -->

        <div class="row">      
          <div class="col-md-4">
              <div class="panel-body">
                <form  action="database/function.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="customerId" value="<?php echo $customerId; ?>">
                

                <div class="form-group">
                    <label>İsim *</label>
                    <input class="form-control" type="text" name="customerName" value="<?php echo $row['customer_name'];?>">
                    <p class="help-block"></p>
                </div>
                <div class="form-group">
                    <label>Soyisim *</label>
                    <input class="form-control" type="text" name="customerSurName" value="<?php echo $row['customer_surname'];?>">
                    <p class="help-block"></p>
                </div>   
                <div class="form-group">
                    <label>E-posta *</label>
                    <input class="form-control" type="email" name="customerEmail" value="<?php echo $row['customer_email'];?>">
                    <p class="help-block"></p>
                </div>
                <div class="form-group">
                    <label>Telefon *</label>
                    <input class="form-control" type="tel" name="customerPhone" value="<?php echo $row['customer_phone'];?>">
                    <p class="help-block"></p>
                </div>
                <div class="form-group">
                    <label>Mesleğiniz</label>
                    <input class="form-control" type="text" name="customerJob" value="<?php echo $row['customer_job'];?>">
                    <p class="help-block"></p>
                </div>
                
                
              </div>
            </div> 
          <div class="col-md-4">
            <div class="panel-body">
              <div class="form-group">
                  <label>Yaş</label>
                  <input class="form-control" type="text" name="customerAge" value="<?php echo $row['age'];?>">
                  <p class="help-block"></p>
              </div>
              <div class="form-group">
                  <label>Kilo</label>
                  <input class="form-control" type="text" name="customerWeight" value="<?php echo $row['weight'];?>">
                  <p class="help-block"></p>
              </div>
              <div class="form-group">
                  <label>Boy</label>
                  <input class="form-control" type="text" name="customerHeight" value="<?php echo $row['height'];?>">
                  <p class="help-block"></p>
              </div>
              <div class="form-group">
                    <label>Yağ Oranı</label>
                    <input class="form-control" placeholder="%" type="text" name="bodyFat" value="<?php echo $row['body_fat'];?>">
                    <p class="help-block"></p>
                </div>

              <div class="form-group">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="inputGroupSelect01">Üyelik Tipi </label>
                </div>
                <select class="custom-select" name="subscriptionType" id="inputGroupSelect01">
                <?php $options = set_and_enum_values($link, 'customers', 'subscription_type');
                      foreach($options as $option):
                        $selected = (isset($row['subscription_type']) && $row['subscription_type'] == $option) ? ' selected="selected"' : '';
                    ?>
                  <option <?php echo $selected; ?>><?php echo $option ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="inputGroupSelect01">Cinsiyet</label>
                </div>
                <select class="custom-select" name="customerGender" id="inputGroupSelect01">
                <?php $options = set_and_enum_values($link, 'customers', 'gender');
                      foreach($options as $option):
                        $selected = (isset($row['gender']) && $row['gender'] == $option) ? ' selected="selected"' : '';
                    ?>
                  <option <?php echo $selected; ?> value="<?php echo $option ?>"><?php echo $option ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
                        <!--Patek Seçme
              <div class="form-group">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="inputGroupSelect01">Paket </label>
                </div>
                <select class="custom-select" name="customerPackage" id="inputGroupSelect01">
                <option >Yok</option>
                <?php $options = set_and_enum_values($link, 'customers', 'package');
                      foreach($options as $option):
                        $selected = (isset($row['package']) && $row['package'] == $option) ? ' selected="selected"' : '';
                    ?>
                  <option <?php echo $selected; ?>><?php echo $option ?></option>
                  <?php endforeach; ?>
                  
                </select>
              </div>-->

            </div>
          </div>
          <div class="col-md-4">

            <div class="form-group">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="inputGroupSelect01">Beslenme Bütçesi</label>
                </div>
                <select class="custom-select" name="nutritionBudget" id="inputGroupSelect01">
                <?php $options = set_and_enum_values($link, 'customers', 'nutrition_budget');
                      foreach($options as $option):
                        $selected = (isset($row['nutrition_budget']) && $row['nutrition_budget'] == $option) ? ' selected="selected"' : '';
                    ?>
                  <option <?php echo $selected; ?> value="<?php echo $option ?>"><?php echo $option ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                  <label>Uyandığınız Saat</label>
                  <input class="form-control" type="time" name="wakeUpTime" value="<?php echo $row['wake_up_time'];?>">
                  <p class="help-block"></p>
              </div>

              <div class="form-group">
                  <label>Uyuduğunuz Saat</label>
                  <input class="form-control" type="time" name="sleepTime" value="<?php echo $row['sleep_time'];?>">
                  <p class="help-block"></p>
              </div>

              <div class="form-group">
                  <label>Kahvaltı Saati</label>
                  <input class="form-control" type="time" name="breakfastTime" value="<?php echo $row['breakfast_time'];?>">
                  <p class="help-block"></p>
              </div>

              <div class="form-group">
                  <label>Antrenman Saati</label>
                  <input class="form-control" type="time" name="trainingTime" value="<?php echo $row['training_time'];?>">
                  <p class="help-block"></p>
              </div>

          </div>
          
        </div><!--end of first row-->

        <div class="row">
            <div class="col">
                <h4>Günlük Rutininiz</h4>
                <p class="help-block">(Nasıl bir işte çalışıyorsunuz? Spor geçmişiniz nedir? Hedefiniz nedir?)</p>
                <textarea name="dailyRoutine" id="" cols="150" rows="10"><?php echo $row['daily_routine'];?></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <p>Detaylı vardiyanız var mı?</p>
                <select name="shiftSelect" id="shift" class="custom-select" onchange = "ShowHideDiv('shift', 'shiftText')">
                    <option value="">Seçiniz</option>
                    <option value="yes" onselect="changeDisplay();">Var</option>
                    <option value="no">Yok</option>
                </select>
            </div>
        </div>

        <div class="row" id="shiftText" style="display: none;">
            <div class="col">
                <h4>Vardiyanız: </h4>
                <p class="help-block">(Çalışmış olduğunuz vardiya sistemini detaylı olarak açıklayınız.)</p>
                <textarea name="detailedShiftBody" id="" cols="150" rows="10" ><?php echo $shiftBody;?></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <p>Sağlık probleminiz var mı?</p>
                <select name="healthSelect" id="health" class="custom-select" onchange = "ShowHideDiv('health', 'healthText')">
                    <option value="">Seçiniz</option>
                    <option value="yes" onselect="changeDisplay();">Var</option>
                    <option value="no">Yok</option>
                </select>
            </div>
        </div>

        <div class="row" id="healthText" style="display: none;">
            <div class="col">
                <h4>Sağlık probleminiz: </h4>
                <p class="help-block">(Geçirmiş olduğunuz bir alerji var mı? Tekrar eden alerjik bir hastalığınız var mı?)</p>
                <textarea name="healthBody" id="" cols="150" rows="10" ><?php echo $healthBody;?></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <p>Besin alerjiniz var mı?</p>
                <select name="alergySelect" id="alergy" class="custom-select" onchange = "ShowHideDiv('alergy', 'alergyText')">
                    <option value="">Seçiniz</option>
                    <option value="yes" onselect="changeDisplay();">Var</option>
                    <option value="no">Yok</option>
                </select>
            </div>
        </div>

        <div class="row" id="alergyText" style="display: none;">
            <div class="col">
                <h4>Besin alerjiniz: </h4>
                <p class="help-block">(Hangi besinlere alerjiniz var?)</p>
                <textarea name="allergyBody" id="" cols="150" rows="10" ><?php echo $allergyBody;?></textarea>
            </div>
        </div>

            <div class="row">
              <div class="col">
                <p>Sporu nerede yapacaksınız?</p>
                <select class="custom-select" name="trainingPlace" id="inputGroupSelect01">
                <option value="">Seçiniz</option>
                <?php $options = set_and_enum_values($link, 'customers', 'training_place');
                      foreach($options as $option):
                        $selected = (isset($row['training_place']) && $row['training_place'] == $option) ? ' selected="selected"' : '';
                    ?>
                  <option <?php echo $selected; ?>><?php echo $option ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
                        
                <div class="btn">
                    <button type="submit" class="btn btn-block " name="profileSet" style="background-color:#5A1BB4">Kaydet </button>
                </div>
          </form>
        </div>
        
   

    </div> <!--END OF CONTAINER-->              
</div> <!--END OF CONTENT-WRAPPER-->




<?php include "footer.php"; ?>

<script>
function ShowHideDiv(id, idDiv) {
        var element = document.getElementById(id);
        var elementDiv = document.getElementById(idDiv);
        elementDiv.style.display = element.value == "yes" ? "block" : "none";
        }
</script>