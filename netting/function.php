<?php

ob_start();
session_start();

include "connection.php"; 

//ADMIN EKLEME
if (isset($_POST['kayit'])) {

  // Given password
$password = $_POST["parola"];

// Validate password strength
$uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number    = preg_match('@[0-9]@', $password);
$specialChars = preg_match('@[^\w]@', $password);

if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
  header("Location: ../views/addadmin.php?dur=weak");
} else {

  $password = md5($_POST["parola"]);
  $name = mysqli_real_escape_string($link, $_POST['adminName']);
  $email = mysqli_real_escape_string($link, $_POST['eposta']);

  $queryCheck = "SELECT * FROM admin_users WHERE admin_email = '$email'";
  $resultCheck = mysqli_query($link, $queryCheck);
  

  if (mysqli_num_rows($resultCheck) > 0) {
    header("Location: ../views/addadmin.php?dur=already");
  } else if ($_POST['adminName'] == ""){
    header("Location: ../views/addadmin.php?dur=noname");
  } else if ($_POST['eposta'] == ""){
    header("Location: ../views/addadmin.php?dur=nomail");
  } else if ($_POST['parola'] == ""){
    header("Location: ../views/addadmin.php?dur=nopass");
  } else if ($_POST["parola"] != $_POST["reparola"]) {
    header("Location: ../views/addadmin.php?dur=no");
  } else {


  $query = "INSERT INTO `admin_users` (
    `admin_name`, 
    `admin_password`, 
    `admin_email`) 
    VALUES (
      '".$name."', 
      '".$password."', 
      '".$email."')";

  $result = mysqli_query($link, $query);
  if (mysqli_affected_rows($link) > 0) {
    header("Location: ../views/addadmin.php?dur=yes");
  } else {
    header("Location: ../views/addadmin.php?dur=nokayit");
  }
}
}
}

// ADMİN PANELİNE GİRİŞ
if (array_key_exists('girisYap', $_POST)) {
  $name = mysqli_real_escape_string($link, $_POST['adminName']);
  $password = md5($_POST["password"]);
  
  if ($name == ""){header("Location: ../login.php?dur=noname");} else {
    if ($password == ""){header("Location: ../login.php?dur=nopass");} else {
      $rawQuery = "SELECT * FROM admin_users WHERE `admin_name` = '%s' AND admin_password = '%s'" ;
      $query = sprintf($rawQuery, mysqli_real_escape_string($link, $name), mysqli_real_escape_string($link, $password)); 
      $result = mysqli_query($link, $query);

      if (mysqli_num_rows($result) > 0) {
        $_SESSION['admin_name'] = $name;
        header("Location: ../views/index.php"); 
      } else {
       header("Location: ../views/login.php?dur=no");
     }
   }
 }
}

//ADDUSER - KULLANICI EKLEME
if (isset($_POST['register'])) {

  // Given password
$password = $_POST["parola"];

$name = mysqli_real_escape_string($link, $_POST['userName']);
$surName = mysqli_real_escape_string($link, $_POST['userSurName']);
$email = mysqli_real_escape_string($link, $_POST['eposta']);
$note = mysqli_real_escape_string($link, $_POST['note']);

// Validate password strength
$uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number    = preg_match('@[0-9]@', $password);
$specialChars = preg_match('@[^\w]@', $password);

if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
  header("Location: ../views/adduser.php?dur=weak");
} else {
  $password = md5($_POST["parola"]);
  $email = $_POST['eposta'];

  $queryCheck = "SELECT * FROM users WHERE email = '$email'";
  $resultCheck = mysqli_query($link, $queryCheck);

  if (mysqli_num_rows($resultCheck) > 0) {
    header("Location: ../views/adduser.php?dur=already");
  } else if ($_POST['userName'] == ""){
    header("Location: ../views/adduser.php?dur=noname");
  } else if ($_POST['userSurName'] == ""){
    header("Location: ../views/adduser.php?dur=nosurname");
  } else if ($_POST['eposta'] == ""){
    header("Location: ../views/adduser.php?dur=nomail");
  } else if ($_POST['parola'] == ""){
    header("Location: ../views/adduser.php?dur=nopass");
  } else if ($_POST["parola"] != $_POST["reparola"]) {
    header("Location: ../views/adduser.php?dur=no");
  } else {
    
    //Image Upload First
   $uploads_dir = '../assets/img/uploads';
   @$tmp_name = $_FILES['firstImage']['tmp_name'];
   @$nameFirst = $_FILES['firstImage']['name'];
   $benzersizsayi1a = rand(20000, 32000);
   $benzersizsayi2a = rand(20000, 32000);
   $benzersizsayi3a = rand(20000, 32000);
   $benzersizsayi4a = rand(20000, 32000);
   $benzersiada = $benzersizsayi1a.$benzersizsayi2a.$benzersizsayi3a.$benzersizsayi4a;
   $refimgyolFirst = substr($uploads_dir, 3)."/".$benzersiada.$nameFirst;

   @move_uploaded_file($tmp_name, "$uploads_dir/$benzersiada$nameFirst");

   //Image Upload Second
   $uploads_dir = '../assets/img/uploads';
   @$tmp_name = $_FILES['secondImage']['tmp_name'];
   @$nameSecond = $_FILES['secondImage']['name'];
   $benzersizsayi1b = rand(20000, 32000);
   $benzersizsayi2b = rand(20000, 32000);
   $benzersizsayi3b = rand(20000, 32000);
   $benzersizsayi4b = rand(20000, 32000);
   $benzersiadb = $benzersizsayi1b.$benzersizsayi2b.$benzersizsayi3b.$benzersizsayi4b;
   $refimgyolSecond = substr($uploads_dir, 3)."/".$benzersiadb.$nameSecond;

   @move_uploaded_file($tmp_name, "$uploads_dir/$benzersiadb$nameSecond");

   //Image Upload Third
   $uploads_dir = '../assets/img/uploads';
   @$tmp_name = $_FILES['thirdImage']['tmp_name'];
   @$nameThird = $_FILES['thirdImage']['name'];
   $benzersizsayi1c = rand(20000, 32000);
   $benzersizsayi2c = rand(20000, 32000);
   $benzersizsayi3c = rand(20000, 32000);
   $benzersizsayi4c = rand(20000, 32000);
   $benzersiadc = $benzersizsayi1c.$benzersizsayi2c.$benzersizsayi3c.$benzersizsayi4c;
   $refimgyolThird = substr($uploads_dir, 3)."/".$benzersiadc.$nameThird;

   @move_uploaded_file($tmp_name, "$uploads_dir/$benzersiadc$nameThird");


    $query = "INSERT INTO `users` (
      `user_name`, 
      `user_surname`, 
      `password`,
      `note`,
      `photo_1`,
      `photo_2`,
      `photo_3`,
      `email`) 
      VALUES (
        '".$name."',
        '".$surName."', 
        '".$password."', 
        '".$note."',
        '../".$refimgyolFirst."',
        '../".$refimgyolSecond."',
        '../".$refimgyolThird."',
        '".$email."'
        )";
    $result = mysqli_query($link, $query);
    if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/adduser.php?dur=yes");
    } else {
      header("Location: ../views/adduser.php?dur=nokayit");
    }
  }
}
}

//USER DÜZENLEME - ADMİN TARAFINDA
if (isset($_POST['userSet'])) {
  $userId = $_POST['userId'];
  
  //$insertStartdate = date('Y-m-d', strtotime($_POST['dateStart']));
  //$insertEnddate = date('Y-m-d', strtotime($_POST['dateEnd']));
  if(!empty($_FILES['profileImage']['tmp_name'])){ //new image uploaded
    
  //Image Upload
   $uploads_dir = '../assets/img/uploads';
   @$tmp_name = $_FILES['profileImage']['tmp_name'];
   @$name = $_FILES['profileImage']['name'];
   $benzersizsayi1 = rand(20000, 32000);
   $benzersizsayi2 = rand(20000, 32000);
   $benzersizsayi3 = rand(20000, 32000);
   $benzersizsayi4 = rand(20000, 32000);
   $benzersiad = $benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
   $refimgyol = substr($uploads_dir, 3)."/".$benzersiad.$name;

   @move_uploaded_file($tmp_name, "$uploads_dir/$benzersiad$name");


    $query = "UPDATE `users` SET 
    
    `note` = '".$_POST['note']."',
    `photo_1` = '../".$refimgyol."'
    WHERE `users`.`user_id` = '$userId'";
    
    $result = mysqli_query($link, $query);
  } else {
    $query = "UPDATE `users` SET 
    
    `note` = '".$_POST['note']."'
    WHERE `users`.`user_id` = '$userId'";
    
    $result = mysqli_query($link, $query);
  }
    if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/userset.php?durum=yes&user_id=$userId");
    } else {
      header("Location: ../views/userset.php?durum=no&user_id=$userId");
    }
  }


// TASK AÇMA
if (isset($_POST['taskButton'])) {
  $userId = $_POST['userId'];

  

  $query = "UPDATE `users` SET 
    
  `photo_start` = '".$_POST['photoTask']."',
  `wash_start` = '".$_POST['washTask']."'
  WHERE `users`.`user_id` = '$userId'";
  
  $result = mysqli_query($link, $query); 
}
  if (mysqli_affected_rows($link) > 0) {
    header("Location: ../views/users.php");
  } else {
    header("Location: ../views/users.php");
  }




// KULLANICI GİRİŞİ
if (array_key_exists('customerLogin', $_POST)) {
  $email = $_POST["customerEmail"];
  $password = md5($_POST["password"]);
  
  if ($email == ""){header("Location: ../customer/customerlogin.php?dur=noname");} else {
    if ($password == ""){header("Location: ../customer/customerlogin.php?dur=nopass");} else {
      $rawQuery = "SELECT * FROM customers WHERE `customer_email` = '%s' AND customer_password = '%s'" ;
      $query = sprintf($rawQuery, mysqli_real_escape_string($link, $email), mysqli_real_escape_string($link, $password)); 
      $result = mysqli_query($link, $query);

      if (mysqli_num_rows($result) > 0) {
        $_SESSION['customer_email'] = $email;
        header("Location: ../customer/index.php"); 
      } else {
       header("Location: ../customer/customerlogin.php?dur=no");
     }
   }
 }
}

//BEŞ FOTO EKLEME
if (isset($_POST['addPhotos'])) {

  $userId = $_POST['userId'];

    //Image Upload Front
   $uploads_dir = '../assets/img/uploads';
   @$tmp_name = $_FILES['frontImage']['tmp_name'];
   @$nameFront = $_FILES['frontImage']['name'];
   $benzersizsayi1a = rand(20000, 32000);
   $benzersizsayi2a = rand(20000, 32000);
   $benzersizsayi3a = rand(20000, 32000);
   $benzersizsayi4a = rand(20000, 32000);
   $benzersiada = $benzersizsayi1a.$benzersizsayi2a.$benzersizsayi3a.$benzersizsayi4a;
   $refimgyolFront = substr($uploads_dir, 3)."/".$benzersiada.$nameFront;

   @move_uploaded_file($tmp_name, "$uploads_dir/$benzersiada$nameFront");

   //Image Upload Back
   $uploads_dir = '../assets/img/uploads';
   @$tmp_name = $_FILES['backImage']['tmp_name'];
   @$nameBack = $_FILES['backImage']['name'];
   $benzersizsayi1b = rand(20000, 32000);
   $benzersizsayi2b = rand(20000, 32000);
   $benzersizsayi3b = rand(20000, 32000);
   $benzersizsayi4b = rand(20000, 32000);
   $benzersiadb = $benzersizsayi1b.$benzersizsayi2b.$benzersizsayi3b.$benzersizsayi4b;
   $refimgyolBack = substr($uploads_dir, 3)."/".$benzersiadb.$nameBack;

   @move_uploaded_file($tmp_name, "$uploads_dir/$benzersiadb$nameBack");

   //Image Upload Top
   $uploads_dir = '../assets/img/uploads';
   @$tmp_name = $_FILES['topImage']['tmp_name'];
   @$nameTop = $_FILES['topImage']['name'];
   $benzersizsayi1c = rand(20000, 32000);
   $benzersizsayi2c = rand(20000, 32000);
   $benzersizsayi3c = rand(20000, 32000);
   $benzersizsayi4c = rand(20000, 32000);
   $benzersiadc = $benzersizsayi1c.$benzersizsayi2c.$benzersizsayi3c.$benzersizsayi4c;
   $refimgyolTop = substr($uploads_dir, 3)."/".$benzersiadc.$nameTop;

   @move_uploaded_file($tmp_name, "$uploads_dir/$benzersiadc$nameTop");

   //Image Upload Right
   $uploads_dir = '../assets/img/uploads';
   @$tmp_name = $_FILES['rightImage']['tmp_name'];
   @$nameRight = $_FILES['rightImage']['name'];
   $benzersizsayi1d = rand(20000, 32000);
   $benzersizsayi2d = rand(20000, 32000);
   $benzersizsayi3d = rand(20000, 32000);
   $benzersizsayi4d = rand(20000, 32000);
   $benzersiadd = $benzersizsayi1d.$benzersizsayi2d.$benzersizsayi3d.$benzersizsayi4d;
   $refimgyolRight = substr($uploads_dir, 3)."/".$benzersiadd.$nameRight;

   @move_uploaded_file($tmp_name, "$uploads_dir/$benzersiadd$nameRight");

   //Image Upload Left
   $uploads_dir = '../assets/img/uploads';
   @$tmp_name = $_FILES['leftImage']['tmp_name'];
   @$nameLeft = $_FILES['leftImage']['name'];
   $benzersizsayi1e = rand(20000, 32000);
   $benzersizsayi2e = rand(20000, 32000);
   $benzersizsayi3e = rand(20000, 32000);
   $benzersizsayi4e = rand(20000, 32000);
   $benzersiade = $benzersizsayi1e.$benzersizsayi2e.$benzersizsayi3e.$benzersizsayi4e;
   $refimgyolLeft = substr($uploads_dir, 3)."/".$benzersiade.$nameLeft;

   @move_uploaded_file($tmp_name, "$uploads_dir/$benzersiade$nameLeft");


    $query = "INSERT INTO `hair_photos` (
      `user_id`, 
      `front_photo`, 
      `back_photo`,
      `top_photo`,
      `right_photo`,
      `left_photo`) 
      VALUES (
        '".$userId."',
        '../".$refimgyolFront."',
        '../".$refimgyolBack."',
        '../".$refimgyolTop."',
        '../".$refimgyolRight."',
        '../".$refimgyolLeft."'
        )";
    $result = mysqli_query($link, $query);
    if (mysqli_affected_rows($link) > 0) {
      header("Location: ../user/index.php?dur=yes");
    } else {
      header("Location: ../user/index.php?dur=nokayit");
    }
  }

  //YIKAMA EKLEME
  if (isset($_POST['addWash'])) {
  
    $userId = $_POST['userId'];

    $query = "INSERT INTO `hair_wash` (`user_id`) VALUES ('".$userId."')";
    $result = mysqli_query($link, $query);
    if (mysqli_affected_rows($link) > 0) {
      header("Location: ../user/index.php?dur=yes");
    } else {
      header("Location: ../user/index.php?dur=nokayit");
    }
  }

?>