<?php 

include "navbar.php"; 
include "sidebar.php"; 

$userId=$_GET['user_id'];


$query = "SELECT * FROM users WHERE user_id = $userId";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_array($result);

// Profile Image
$file = $row['photo_1'];
if (!file_exists($file))
$file = '../assets/img/defaultcustomer.png';


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
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Kullanıcı Bilgilerini Düzenle</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Anasayfa</a></li>
              <li class="breadcrumb-item active">Kullanıcı Düzenle</li>
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
      <?php } elseif ($_GET['durum'] == 'no') { ?>
          <h1 style="color: red;" class="page-subhead-line">Kullanıcı düzenlenemedi!</h1>
      <?php }  } ?>

    <!-- Profile Image -->
    <div class="card card-primary card-outline">
      <div class="card-body box-profile">
        <div class="text-center">
          <img class="profile-user-img img-fluid img-circle"
                src="<?php echo $file; ?>"
                alt="User profile picture">
        </div>
      </div>
    </div>

      <div class="container">
        <div class="row">
            <div class="col-md-12">
              <a href="userpage.php?user_id=<?php echo $row['user_id']; ?>" class="btn btn-sm btn-primary">
              <i class="fas fa-user"></i> Profili Görüntüle
              </a>
                <?php 
                if(isset($_GET['dur'])) {
                      

                    if ($_GET['dur'] == 'nokayit') { ?>
                    <h5 class='alert alert-danger' role='alert'><p>Düzenleme yapılamadı! Lütfen tekrar deneyiniz.</p></h5>
                    <?php }  

                    if ($_GET['dur'] == 'yes') { ?>
                    <h5 class='alert alert-success' role='alert'><p>Düzenleme başarıyla yapıldı.</p></h5>

                    <?php } } ?>

            </div>
        </div>     <!-- /. ROW  -->

        <div class="row">      
          <div class="col-md-6">
              <div class="panel-body">
                <form  action="../netting/function.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                
                <div class="form-group">
                    <h2><?php echo $row['user_name']; echo " "; echo $row['user_surname'];?></h2>
                    <p class="help-block"></p>
                </div>
                   
                <div class="form-group">
                    <label>E-posta</label>
                    <p class="help-block"><?php echo $row['email'];?></p>
                </div>
                
              </div>
            </div>     
          <div class="col-md-6">
            <div class="panel-body">

              <div class="form-group">
                  <label>Not</label>
                  <input class="form-control" type="text" name="note" value="<?php echo $row['note'];?>">
                  <p class="help-block"></p>
              </div>

              <div class="form-group text-center" style="position: relative;" >
                <span class="img-div">
                  <div class="text-center img-placeholder"  onClick="triggerClick()">
                    <h4>Görseli Güncelle</h4>
                  </div>
                  <img src="<?php echo $file; ?>" onClick="triggerClick()" id="profileDisplay" style="height: 150px;">
                </span>
                <input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage" class="form-control" style="display: none;">
                <label>Profil Fotoğrafı</label>
              </div>
              
            </div>
          </div>
          
          <button type="submit" class="btn btn-success btn-lg btn-block" name="userSet">Kaydet </button>
                </form>
        </div>
      </div> <!--END OF CONTAINER-->              
</div> <!--END OF CONTENT-WRAPPER-->


<script>

function setSubDate() {
  var minToDate = document.getElementById("startDate").value;
  //var newEndDateMin  = minToDate.setMonth(minToDate.getMonth()+6);
  document.getElementById("endDate").setAttribute("min", minToDate);
}
</script>

<?php include "footer.php"; ?>   
