<?php 

    include "navbar.php"; 
    include "sidebar.php"; 

    $name = $_SESSION['admin_name'];
    
    $userId = $_GET['user_id'];

    $query = "SELECT * FROM `users` WHERE user_id = $userId";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_array($result);

    $userName = $row['user_name'];

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

            <h3 class="profile-username text-center"><?php echo $row['user_name']; echo " "; echo $row['user_surname']; ?></h3>

            <p class="text-muted text-center"><?php echo $row['email']; ?></p>

            

            <ul class="list-group list-group-unbordered mb-3">
              
              <a class="btn btn-sm bg-teal" href="userset.php?user_id=<?php echo $row['user_id']; ?>" >
                  <i class="fas fa-edit"></i>Düzenle
                </a>
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






      <div class="col-md-9">
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="photo-tab" data-toggle="pill" href="#photo" role="tab" aria-controls="photo" aria-selected="true">Fotoğraflı Geri Bildirim</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="wash-tab" data-toggle="pill" href="#wash" role="tab" aria-controls="wash" aria-selected="false">Yıkama Görevi</a>
                  </li>
                  
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">

                  <div class="tab-pane fade show active" id="photo" role="tabpanel" aria-labelledby="photo-tab">
                                        <?php  

                        $query = "SELECT * FROM `hair_photos`  WHERE user_id = '$userId'";
                        $result = mysqli_query($link, $query);
                        while($row = mysqli_fetch_array($result)){

                        $file1 = $row['front_photo'];
                        $file2 = $row['back_photo'];
                        $file3 = $row['top_photo'];
                        $file4 = $row['right_photo'];
                        $file5 = $row['left_photo'];
                        $date = date('Y-m-d' ,strtotime($row['date']));
                        
                        $hairPhotoId = $row['hair_photo_id'];
                        ?>
                        <div class="card-body">
                            <div class="row">

                              <div class="col-sm-4">
                                <div class="position-relative" style="max-height: 150px;">
                                    <img src="<?php echo $file1; ?>" alt="Photo 1" class="img-fluid">
                                    <div class="ribbon-wrapper">
                                      <div class="ribbon bg-primary">
                                        Ön
                                      </div>
                                    </div>
                                </div>
                              </div>

                              <div class="col-sm-4">
                                <div class="position-relative" style="min-height: 180px;">
                                  <img src="<?php echo $file2; ?>" alt="Photo 2" class="img-fluid">
                                  <div class="ribbon-wrapper">
                                    <div class="ribbon bg-primary">
                                      Arka
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="col-sm-4">
                                <div class="position-relative" style="min-height: 180px;">
                                  <img src="<?php echo $file3; ?>" alt="Photo 3" class="img-fluid">
                                  <div class="ribbon-wrapper">
                                    <div class="ribbon bg-primary">
                                      Tepe
                                    </div>
                                  </div>
                                </div>
                              </div>

                            </div>
                            <div class="row">

                              <div class="col-sm-4">
                                  <div class="position-relative" style="min-height: 180px;">
                                    <img src="<?php echo $file4; ?>" alt="Photo 4" class="img-fluid">
                                    <div class="ribbon-wrapper">
                                      <div class="ribbon bg-primary">
                                        Sağ
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="position-relative" style="min-height: 180px;">
                                    <img src="<?php echo $file5; ?>" alt="Photo 5" class="img-fluid">
                                    <div class="ribbon-wrapper">
                                      <div class="ribbon bg-primary">
                                        Sol
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="position-relative" style="min-height: 180px;">
                                    <h3><?php echo $date; ?></h3>
                                  </div>
                                </div>
                            </div><!-- /.row -->
                        </div><!-- /.card-body -->
                      <?php  } ?>
                  </div><!-- end tab pane-->

                  <div class="tab-pane fade" id="wash" role="tabpanel" aria-labelledby="wash-tab">
                                <?php
                                    $x = 1;
                                    $querywash = "SELECT * FROM `hair_wash`  WHERE user_id = '$userId'";
                                    $resultwash = mysqli_query($link, $querywash);
                                    while($rowwash = mysqli_fetch_array($resultwash)){

                                   
                                        echo $x;
                                        echo '- ';
                                        echo date('Y-m-d' ,strtotime($rowwash['wash_time']));
                                        echo '<br>';
                                        $x++;
                                        
                                      }
                                ?>
                                 
                  </div><!-- end tab pane-->


                  
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>


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