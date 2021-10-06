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
  header("Location: ../views/adduser.php?dur=weak");
} else {

  $password = md5($_POST["parola"]);
  $email = $_POST['eposta'];
  $privilage = 0;

  $queryCheck = "SELECT * FROM customers WHERE user_email = '$email'";
  $resultCheck = mysqli_query($link, $queryCheck);
  

  if (mysqli_num_rows($resultCheck) > 0) {
    header("Location: ../views/adduser.php?dur=already");
  } else if ($_POST['userName'] == ""){
    header("Location: ../views/adduser.php?dur=noname");
  } else if ($_POST['eposta'] == ""){
    header("Location: ../views/adduser.php?dur=nomail");
  } else if ($_POST['parola'] == ""){
    header("Location: ../views/adduser.php?dur=nopass");
  } else if ($_POST["parola"] != $_POST["reparola"]) {
    header("Location: ../views/adduser.php?dur=no");
  } else {


  $query = "INSERT INTO `users` (
    `user_name`, 
    `user_password`, 
    `user_email`, 
    `user_privilage`) 
    VALUES (
      '".$_POST['userName']."', 
      '".$password."', 
      '".$_POST['eposta']."', 
      '".$privilage."')";

  $result = mysqli_query($link, $query);
  if (mysqli_affected_rows($link) > 0) {
    header("Location: ../views/adduser.php?dur=yes");
  } else {
    header("Location: ../views/adduser.php?dur=nokayit");
  }
}
}
}

// ADMİN PANELİNE GİRİŞ
if (array_key_exists('girisYap', $_POST)) {
  $name = $_POST["userName"];
  $password = md5($_POST["password"]);
  
  if ($name == ""){header("Location: ../login.php?dur=noname");} else {
    if ($password == ""){header("Location: ../login.php?dur=nopass");} else {
      $rawQuery = "SELECT * FROM users WHERE `user_name` = '%s' AND user_password = '%s'" ;
      $query = sprintf($rawQuery, mysqli_real_escape_string($link, $name), mysqli_real_escape_string($link, $password)); 
      $result = mysqli_query($link, $query);

      if (mysqli_num_rows($result) > 0) {
        $_SESSION['user_name'] = $name;
        header("Location: ../views/index.php"); 
      } else {
       header("Location: ../views/login.php?dur=no");
     }
   }
 }
}

//REGISTER - KULLANICI EKLEME
if (isset($_POST['register'])) {

  // Given password
$password = $_POST["parola"];

// Validate password strength
$uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number    = preg_match('@[0-9]@', $password);
$specialChars = preg_match('@[^\w]@', $password);

if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
  echo "Lütfen parolanızı yönergelere göre kuvvetli seçiniz!";
} else {
  $password = md5($_POST["parola"]);
  $email = $_POST['eposta'];

  $queryCheck = "SELECT * FROM customers WHERE customer_email = '$email'";
  $resultCheck = mysqli_query($link, $queryCheck);

  if (mysqli_num_rows($resultCheck) > 0) {
    echo "Bu kullanıcı zaten kayıtlı";
  } else if ($_POST['customerName'] == ""){
    echo "Lütfen adınızı giriniz.";
  } else if ($_POST['customerSurName'] == ""){
    echo "Lütfen soyadınızı giriniz.";
  } else if ($_POST['eposta'] == ""){
    echo "Lütfen e-posta giriniz.";
  } else if ($_POST['parola'] == ""){
    echo "Lütfen parolanızı giriniz.";
  } else if ($_POST["parola"] != $_POST["reparola"]) {
    echo "Lütfen parolanızı tekrar giriniz.";
  } else {
    $query = "INSERT INTO `customers` (
      `customer_name`, 
      `customer_surname`, 
      `customer_password`, 
      `customer_email`)
      VALUES (
        '".$_POST['customerName']."',
        '".$_POST['customerSurName']."', 
        '".$password."', 
        '".$_POST['eposta']."' 
        )";
    $result = mysqli_query($link, $query);
    if (mysqli_affected_rows($link) > 0) {
        echo "success";
    } else {
        echo "Kayıt oluşturulurken bir hata oldu!";
    }
  }
}
}

// KULLANICI GİRİŞİ
if (array_key_exists('customerLogin', $_POST)) {
  $email = $_POST["customerEmail"];
  $password = md5($_POST["password"]);
  
  if ($email == ""){echo "Lütfen geçerli bir e-posta giriniz";} else {
    if ($password == ""){echo "Lütfen parolanızı giriniz";} else {
      $rawQuery = "SELECT * FROM customers WHERE `customer_email` = '%s' AND customer_password = '%s'" ;
      $query = sprintf($rawQuery, mysqli_real_escape_string($link, $email), mysqli_real_escape_string($link, $password)); 
      $result = mysqli_query($link, $query);

      if (mysqli_num_rows($result) > 0) {
      echo "success";
    } else {
      echo "Kayıt oluşturulurken bir hata oldu!";
    }
   }
 }
}

//CUSTOMER EKLEME - ADMİN TARAFINDA - GEREKLİ DEĞİL
if (isset($_POST['addcustomer'])) {
    $password = md5($_POST["parola"]);
    $email = $_POST['eposta'];

    $queryCheck = "SELECT * FROM customers WHERE customer_email = '$email'";
    $resultCheck = mysqli_query($link, $queryCheck);

    if (mysqli_num_rows($resultCheck) > 0) {
      header("Location: ../views/addcustomer.php?dur=already");
    } else if ($_POST['customerName'] == ""){
      header("Location: ../views/addcustomer.php?dur=noname");
    } else if ($_POST['customerSurName'] == ""){
      header("Location: ../views/addcustomer.php?dur=nosurname");
    } else if ($_POST['eposta'] == ""){
      header("Location: ../views/addcustomer.php?dur=nomail");
    } else if ($_POST['parola'] == ""){
      header("Location: ../views/addcustomer.php?dur=nopass");
    } else if ($_POST["parola"] != $_POST["reparola"]) {
      header("Location: ../views/addcustomer.php?dur=no");
    } else {

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

    $query = "INSERT INTO `customers` (
      `customer_name`, 
      `customer_surname`, 
      `customer_password`, 
      `customer_email`, 
      `customer_image`,
      `phone`, 
      `height`, 
      `weight`, 
      `age`, 
      `subscription_type`,
      `starting_date`,
      `ending_date`,
      `package`) 
      VALUES (
        '".$_POST['customerName']."',
        '".$_POST['customerSurName']."', 
        '".$password."', 
        '".$_POST['eposta']."', 
        '".$refimgyol."',
        '".$_POST['customerPhone']."', 
        '".$_POST['customerHeight']."', 
        '".$_POST['customerWeight']."', 
        '".$_POST['customerAge']."', 
        '".$_POST['customerType']."',
        '".$_POST['dateStart']."',
        '".$_POST['dateEnd']."', 
        '".$_POST['package']."'
        )";
    $result = mysqli_query($link, $query);
    if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/addcustomer.php?dur=yes");
    } else {
      header("Location: ../views/addcustomer.php?dur=nokayit");
    }
  }
}

//CUSTOMER DÜZENLEME - ADMİN TARAFINDA - PANELE KONULMADI
if (isset($_POST['customerSet'])) {
  $customerId = $_POST['customerId'];
  
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


    $query = "UPDATE `customers` SET 
    
    `age` = '".$_POST['customerAge']."',
    `weight` = '".$_POST['customerWeight']."',
    `subscription_type` = '".$_POST['subscriptionType']."',
    `gender` = '".$_POST['customerGender']."',
    `package` = '".$_POST['customerPackage']."',
    `starting_date` = '".$_POST['dateStart']."',
    `ending_date` = '".$_POST['dateEnd']."',
    `customer_image` = '../".$refimgyol."'
    WHERE `customers`.`customer_id` = '$customerId'";
    
    $result = mysqli_query($link, $query);
  } else {
    $query = "UPDATE `customers` SET 
    
    `age` = '".$_POST['customerAge']."',
    `weight` = '".$_POST['customerWeight']."',
    `subscription_type` = '".$_POST['subscriptionType']."',
    `gender` = '".$_POST['customerGender']."',
    `package` = '".$_POST['customerPackage']."',
    `starting_date` = '".$_POST['dateStart']."',
    `ending_date` = '".$_POST['dateEnd']."'
    WHERE `customers`.`customer_id` = '$customerId'";
    
    $result = mysqli_query($link, $query);
  }
    if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/customerset.php?durum=yes&customer_id=$customerId");
    } else {
      header("Location: ../views/customerset.php?durum=no&customer_id=$customerId");
    }
  }


  //ÜÇ FOTOĞRAFLI GERİ BİLDİRİM EKLEME
  if (isset($_POST['sendfeedback'])) {
      $customerId = $_POST['customerId'];

    if(empty($_FILES['frontImage']['tmp_name'])){
      header("Location: ../customer/sendfeedback.php?durum=nofront&customer_id=$customerId");
    } else if (empty($_FILES['sideImage']['tmp_name'])) {
      header("Location: ../customer/sendfeedback.php?durum=noside&customer_id=$customerId");
    } else if (empty($_FILES['rearImage']['tmp_name'])) {
      header("Location: ../customer/sendfeedback.php?durum=norear&customer_id=$customerId");
    } else {
    
  //Image Upload Front
   $uploads_dir = '../assets/img/uploads';
   @$tmp_name = $_FILES['frontImage']['tmp_name'];
   @$nameF = $_FILES['frontImage']['name'];
   $benzersizsayi1f = rand(20000, 32000);
   $benzersizsayi2f = rand(20000, 32000);
   $benzersizsayi3f = rand(20000, 32000);
   $benzersizsayi4f = rand(20000, 32000);
   $benzersiadf = $benzersizsayi1f.$benzersizsayi2f.$benzersizsayi3f.$benzersizsayi4f;
   $refimgyolFront = substr($uploads_dir, 3)."/".$benzersiadf.$nameF;

   @move_uploaded_file($tmp_name, "$uploads_dir/$benzersiadf$nameF");

   //Image Upload Side
   $uploads_dir = '../assets/img/uploads';
   @$tmp_name = $_FILES['sideImage']['tmp_name'];
   @$nameS = $_FILES['sideImage']['name'];
   $benzersizsayi1s = rand(20000, 32000);
   $benzersizsayi2s = rand(20000, 32000);
   $benzersizsayi3s = rand(20000, 32000);
   $benzersizsayi4s = rand(20000, 32000);
   $benzersiads = $benzersizsayi1s.$benzersizsayi2s.$benzersizsayi3s.$benzersizsayi4s;
   $refimgyolSide = substr($uploads_dir, 3)."/".$benzersiads.$nameS;

   @move_uploaded_file($tmp_name, "$uploads_dir/$benzersiads$nameS");

   //Image Upload Rear
   $uploads_dir = '../assets/img/uploads';
   @$tmp_name = $_FILES['rearImage']['tmp_name'];
   @$nameR = $_FILES['rearImage']['name'];
   $benzersizsayi1r = rand(20000, 32000);
   $benzersizsayi2r = rand(20000, 32000);
   $benzersizsayi3r = rand(20000, 32000);
   $benzersizsayi4r = rand(20000, 32000);
   $benzersiadr = $benzersizsayi1r.$benzersizsayi2r.$benzersizsayi3r.$benzersizsayi4r;
   $refimgyolRear = substr($uploads_dir, 3)."/".$benzersiadr.$nameR;

   @move_uploaded_file($tmp_name, "$uploads_dir/$benzersiadr$nameR");

   $queryBodyImages = "INSERT INTO `body_images` (
    `customer_id`, 
    `front`, 
    `side`, 
    `rear`,
    `comments`) 
    VALUES (
      '".$customerId."',
      '../".$refimgyolFront."', 
      '../".$refimgyolSide."', 
      '../".$refimgyolRear."',
      '".$_POST['editor1']."')"; 

$resultBody = mysqli_query($link, $queryBodyImages);
if (mysqli_affected_rows($link) > 0) {
  header("Location: ../customer/sendfeedback.php?durum=yes&customer_id=$customerId");
} else {
  header("Location: ../customer/sendfeedback.php?durum=no&customer_id=$customerId");
}
}
}

  //KULLANICI SİLME - PANELE KONULMADI - ADMİN TARAFINDA
  if ($_GET['customersil'] == "ok") {  
  $customerId = $_GET['customer_id'];

  $query = "DELETE FROM `customers` WHERE `customer_id` = '".$customerId."' LIMIT 1"; 
  $result = mysqli_query($link, $query);

  $query = "DELETE FROM `training` WHERE `customer_id` = '".$customerId."' "; 
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0 ) {

    $imgDelete = $_GET['customerimgdelete'];
    unlink("$imgDelete");
    header("Location: ../views/customers.php?durum=silindi");
  } else {
    header("Location: ../views/customers.php?durum=silinmedi");
  }
}

  

//ANTRENMAN PROGRAMI EKLEME
if (isset($_POST['addTrain'])) {
  $customerId = $_POST['customerId'];
  if(!empty($_POST['videoId'])) {

  $videoId = implode(",",$_POST['videoId']);


  $query = "INSERT INTO training (customer_id, customer_name, train_header, train_body, train_note, train_day, video_id, train_time) VALUES ('".$customerId."', '".$_POST['customerName']."', '".$_POST['trainHead']."', '".$_POST['editor1']."', '".$_POST['trainNote']."', '".$_POST['trainDay']."', '" . $videoId . "', '".$_POST['trainTime']."')";
  $result = mysqli_query($link, $query);
  
  if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/addtraining.php?durum=yes&customer_id=$customerId");
  } else {
      header("Location: ../views/addtraining.php?durum=no&customer_id=$customerId");
  }
} else {
  $query = "INSERT INTO training (customer_id, train_header, train_body, train_note, train_day, train_time) VALUES ('".$customerId."', '".$_POST['trainHead']."', '".$_POST['editor1']."', '".$_POST['trainNote']."', '".$_POST['trainDay']."', '".$_POST['trainTime']."')";
  $result = mysqli_query($link, $query);
  
  if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/addtraining.php?durum=yes&customer_id=$customerId");
  } else {
      header("Location: ../views/addtraining.php?durum=no&customer_id=$customerId");
  }
}
}

//ANTRENMAN PROGRAMI DÜZENLEME
if (isset($_POST['trainSet'])) {
  $trainId = $_POST['trainId'];
  $customerId = $_POST['customerId'];
  if(!empty($_POST['videoId'])) {

    $videoId = implode(",",$_POST['videoId']);

    $query = "UPDATE `training` SET 
    `train_header` = '".$_POST['trainHeader']."', 
    `train_time` = '".$_POST['trainTime']."', 
    `train_body` = '".$_POST['editor1']."', 
    `train_day` = '".$_POST['trainDay']."',
    `train_note` = '".$_POST['trainNote']."', 
    `video_id` = '".$videoId."' 
    WHERE `train_id` = '$trainId'";
    $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0) {
    header("Location: ../views/trainingset.php?durum=yes&train_id=$trainId&customer_id=$customerId");
  } else {
    header("Location: ../views/trainingset.php?durum=no&train_id=$trainId&customer_id=$customerId");
  }
} else {
  $query = "UPDATE `training` SET 
  `train_header` = '".$_POST['trainHeader']."', 
  `train_time` = '".$_POST['trainTime']."', 
  `train_body` = '".$_POST['editor1']."', 
  `train_day` = '".$_POST['trainDay']."',
  `train_note` = '".$_POST['trainNote']."' 
  WHERE `train_id` = '$trainId'";
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0) {
    header("Location: ../views/trainingset.php?durum=yes&train_id=$trainId&customer_id=$customerId");
  } else {
    header("Location: ../views/trainingset.php?durum=no&train_id=$trainId&customer_id=$customerId");
  }
}
}

//ANTRENMAN PROGRAMI SİLME
if ($_GET['trainsil'] == "ok") {  
  $customerId = $_GET['customer_id'];

  $query = "DELETE FROM `training` WHERE `train_id` = '".$_GET['train_id']."' LIMIT 1"; 
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0 ) {
    header("Location: ../views/customerpage.php?durum=silindi&customer_id=$customerId");
  } else {
    header("Location: ../views/customerpage.php?durum=silinmedi&customer_id=$customerId");
  }
}

//BESLENME PROGRAMI EKLEME
if (isset($_POST['addNutrition'])) {
  $customerId = $_POST['customerId'];

  if ($_POST['nutritionMeal'] == ""){
    header("Location: ../views/addnutrition.php?dur=nomeal&customer_id=$customerId");
  } else {
  
  $query = "INSERT INTO nutrition (customer_id, nutrition_header, nutrition_note, nutrition_body, meal) VALUES ('".$customerId."', '".$_POST['nutritionHead']."', '".$_POST['nutritionNote']."', '".$_POST['editor1']."', '".$_POST['nutritionMeal']."')";
  $result = mysqli_query($link, $query);
  
  if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/addnutrition.php?dur=yes&customer_id=$customerId");
  } else {
      header("Location: ../views/addnutrition.php?dur=no&customer_id=$customerId");
  }
}
}

//BESLENME PROGRAMI DÜZENLEME
if (isset($_POST['nutritionSet'])) {
  $nutritionId = $_POST['nutritionId'];
  $customerId = $_POST['customerId'];

  $query = "UPDATE `nutrition` SET `nutrition_header` = '".$_POST['nutritionHeader']."', `nutrition_body` = '".$_POST['editor1']."', `meal` = '".$_POST['nutritionMeal']."',`nutrition_note` = '".$_POST['nutritionNote']."' WHERE `nutrition_id` = '$nutritionId'";
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0) {
    header("Location: ../views/nutritionset.php?durum=yes&nutrition_id=$nutritionId&customer_id=$customerId");
  } else {
    header("Location: ../views/nutritionset.php?durum=no&nutrition_id=$nutritionId&customer_id=$customerId");
  }
}

//BESLENME PROGRAMI SİLME
if ($_GET['nutritionsil'] == "ok") {  
  $customerId = $_GET['customer_id'];

  $query = "DELETE FROM `nutrition` WHERE `nutrition_id` = '".$_GET['nutrition_id']."' LIMIT 1"; 
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0 ) {
    header("Location: ../views/customerpage.php?durum=nutritionsilindi&customer_id=$customerId");
  } else {
    header("Location: ../views/customerpage.php?durum=silinmedi&customer_id=$customerId");
  }
}

//ANTRENMAN NOTLARI VE KARDİYO PROGRAMI EKLEME
if (isset($_POST['addTrainNote'])) {
  $customerId = $_POST['customerId'];

  if ($_POST['trainNoteHead'] == ""){
    header("Location: ../views/addtrainnote.php?dur=nohead");
  } else if ($_POST['editor1'] == ""){
    header("Location: ../views/addtrainnote.php?dur=nobody");
  } else {
  
  $query = "INSERT INTO training_notes (customer_id, train_note_header, train_note_body) VALUES ('".$customerId."', '".$_POST['trainNoteHead']."', '".$_POST['editor1']."')";
  $result = mysqli_query($link, $query);
  
  if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/addtrainnote.php?dur=yes&customer_id=$customerId");
  } else {
      header("Location: ../views/addtrainnote.php?dur=no&customer_id=$customerId");
  }
}
}

//ANTRENMAN NOTLARI VE KARDİYO PROGRAMI DÜZENLEME
if (isset($_POST['trainNoteSet'])) {
  $trainNoteId = $_POST['trainNoteId'];
  $customerId = $_POST['customerId'];

  $query = "UPDATE `training_notes` SET `train_note_header` = '".$_POST['trainNoteHeader']."', `train_note_body` = '".$_POST['editor1']."' WHERE `train_note_id` = '$trainNoteId'";
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0) {
    header("Location: ../views/trainnoteset.php?durum=yes&train_note_id=$trainNoteId&customer_id=$customerId");
  } else {
    header("Location: ../views/trainnoteset.php?durum=no&train_note_id=$trainNoteId&customer_id=$customerId");
  }
}

//ANTRENMAN NOTLARI VE KARDİYO PROGRAMI SİLME
if ($_GET['trainnotesil'] == "ok") {  
  $customerId = $_GET['customer_id'];

  $query = "DELETE FROM `training_notes` WHERE `train_note_id` = '".$_GET['train_note_id']."' LIMIT 1"; 
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0 ) {
    header("Location: ../views/customerpage.php?durum=trainnotesilindi&customer_id=$customerId");
  } else {
    header("Location: ../views/customerpage.php?durum=trainnotesilinmedi&customer_id=$customerId");
  }
}

//BESLENME ALTERNATİFİ VE NOTLARI EKLEME
if (isset($_POST['addNutritionNote'])) {
  $customerId = $_POST['customerId'];

  if ($_POST['nutritionNoteHead'] == ""){
    header("Location: ../views/addnutritionnote.php?dur=nohead");
  } else if ($_POST['editor1'] == ""){
    header("Location: ../views/addnutritionnote.php?dur=nobody");
  } else {
  
  $query = "INSERT INTO nutrition_notes (
    customer_id, 
    nutrition_note_header, 
    nutrition_note_body,
    nutrition_note_donts
    ) VALUES (
      '".$customerId."', 
      '".$_POST['nutritionNoteHead']."', 
      '".$_POST['editor1']."',
      '".$_POST['nutritionNoteDonts']."'
      )";
  $result = mysqli_query($link, $query);
  
  if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/addnutritionnote.php?dur=yes&customer_id=$customerId");
  } else {
      header("Location: ../views/addnutritionnote.php?dur=no&customer_id=$customerId");
  }
}
}

//BESLENME ALTERNATİFİ VE NOTLARI DÜZENLEME
if (isset($_POST['nutritionNoteSet'])) {
  $nutritionNoteId = $_POST['nutritionNoteId'];
  $customerId = $_POST['customerId'];

  $query = "UPDATE `nutrition_notes` SET 
  `nutrition_note_header` = '".$_POST['nutritionNoteHeader']."', 
  `nutrition_note_body` = '".$_POST['editor1']."',
  `nutrition_note_donts` = '".$_POST['nutritionNoteDonts']."'
  WHERE `nutrition_note_id` = '$nutritionNoteId'";
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0) {
    header("Location: ../views/nutritionnoteset.php?durum=yes&nutrition_note_id=$nutritionNoteId&customer_id=$customerId");
  } else {
    header("Location: ../views/nutritionnoteset.php?durum=no&nutrition_note_id=$nutritionNoteId&customer_id=$customerId");
  }
}

//BESLENME ALTERNATİFİ VE NOTLARI SİLME
if ($_GET['nutritionnotesil'] == "ok") {  
  $customerId = $_GET['customer_id'];

  $query = "DELETE FROM `nutrition_notes` WHERE `nutrition_note_id` = '".$_GET['nutrition_note_id']."' LIMIT 1"; 
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0 ) {
    header("Location: ../views/customerpage.php?durum=nutritionnotesilindi&customer_id=$customerId");
  } else {
    header("Location: ../views/customerpage.php?durum=nutritionnotesilinmedi&customer_id=$customerId");
  }
}

//SİSTEM NOTLARI EKLEME
if (isset($_POST['addSystemNote'])) {
  $customerId = $_POST['customerId'];

  if ($_POST['systemNoteHead'] == ""){
    header("Location: ../views/addsystemnote.php?dur=nohead");
  } else if ($_POST['editor1'] == ""){
    header("Location: ../views/addsystemnote.php?dur=nobody");
  } else {
  
  $query = "INSERT INTO system_notes (customer_id, system_note_header, system_note_body) VALUES ('".$customerId."', '".$_POST['systemNoteHead']."', '".$_POST['editor1']."')";
  $result = mysqli_query($link, $query);
  
  if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/addsystemnote.php?dur=yes&customer_id=$customerId");
  } else {
      header("Location: ../views/addsystemnote.php?dur=no&customer_id=$customerId");
  }
}
}

//SİSTEM NOTLARI DÜZENLEME
if (isset($_POST['systemNoteSet'])) {
  $systemNoteId = $_POST['systemNoteId'];
  $customerId = $_POST['customerId'];

  $query = "UPDATE `system_notes` SET `system_note_header` = '".$_POST['systemNoteHeader']."', `system_note_body` = '".$_POST['editor1']."' WHERE `system_note_id` = '$systemNoteId'";
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0) {
    header("Location: ../views/systemnoteset.php?durum=yes&system_note_id=$systemNoteId&customer_id=$customerId");
  } else {
    header("Location: ../views/systemnoteset.php?durum=no&system_note_id=$systemNoteId&customer_id=$customerId");
  }
}

//SİSTEM NOTLARI SİLME
if ($_GET['systemnotesil'] == "ok") {  
  $customerId = $_GET['customer_id'];

  $query = "DELETE FROM `system_notes` WHERE `system_note_id` = '".$_GET['system_note_id']."' LIMIT 1"; 
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0 ) {
    header("Location: ../views/customerpage.php?durum=systemnotesilindi&customer_id=$customerId");
  } else {
    header("Location: ../views/customerpage.php?durum=systemnotesilinmedi&customer_id=$customerId");
  }
}

//SUPPLEMENT PLANI EKLEME
if (isset($_POST['addSupplementPlan'])) {
  $customerId = $_POST['customerId'];

  if ($_POST['supplementPlanHead'] == ""){
    header("Location: ../views/addsupplementplan.php?dur=nohead");
  } else if ($_POST['editor1'] == ""){
    header("Location: ../views/addsupplementplan.php?dur=nobody");
  } else {
  
  $query = "INSERT INTO supplement_plan (customer_id, supplement_plan_header, supplement_plan_body) VALUES ('".$customerId."', '".$_POST['supplementPlanHead']."', '".$_POST['editor1']."')";
  $result = mysqli_query($link, $query);
  
  if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/addsupplementplan.php?dur=yes&customer_id=$customerId");
  } else {
      header("Location: ../views/addsupplementplan.php?dur=no&customer_id=$customerId");
  }
}
}

//SUPPLEMENT PLANI DÜZENLEME
if (isset($_POST['supplementPlanSet'])) {
  $supplementPlanId = $_POST['supplementPlanId'];
  $customerId = $_POST['customerId'];

  $query = "UPDATE `supplement_plan` SET `supplement_plan_header` = '".$_POST['supplementPlanHeader']."', `supplement_plan_body` = '".$_POST['editor1']."' WHERE `supplement_plan_id` = '$supplementPlanId'";
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0) {
    header("Location: ../views/supplementplanset.php?durum=yes&supplement_plan_id=$supplementPlanId&customer_id=$customerId");
  } else {
    header("Location: ../views/supplementplanset.php?durum=no&supplement_plan_id=$supplementPlanId&customer_id=$customerId");
  }
}

//SUPPLEMENT PLANI SİLME
if ($_GET['supplementplansil'] == "ok") {  
  $customerId = $_GET['customer_id'];

  $query = "DELETE FROM `supplement_plan` WHERE `supplement_plan_id` = '".$_GET['supplement_plan_id']."' LIMIT 1"; 
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0 ) {
    header("Location: ../views/customerpage.php?durum=supplementplansilindi&customer_id=$customerId");
  } else {
    header("Location: ../views/customerpage.php?durum=supplementplansilinmedi&customer_id=$customerId");
  }
}

//ORGANİK TAVSİYE EKLEME
if (isset($_POST['addOrganicAdvice'])) {
  $customerId = $_POST['customerId'];

  if ($_POST['organicAdviceHead'] == ""){
    header("Location: ../views/addorganicadvice.php?dur=nohead");
  } else if ($_POST['editor1'] == ""){
    header("Location: ../views/addorganicadvice.php?dur=nobody");
  } else {
  
  $query = "INSERT INTO organic_advices (customer_id, organic_advice_header, organic_advice_body) VALUES ('".$customerId."', '".$_POST['organicAdviceHead']."', '".$_POST['editor1']."')";
  $result = mysqli_query($link, $query);
  
  if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/addorganicadvice.php?dur=yes&customer_id=$customerId");
  } else {
      header("Location: ../views/addorganicadvice.php?dur=no&customer_id=$customerId");
  }
}
}

//ORGANİK TAVSİYE DÜZENLEME
if (isset($_POST['organicAdviceSet'])) {
  $organicAdviceId = $_POST['organicAdviceId'];
  $customerId = $_POST['customerId'];

  $query = "UPDATE `organic_advices` SET `organic_advice_header` = '".$_POST['organicAdviceHeader']."', `organic_advice_body` = '".$_POST['editor1']."' WHERE `organic_advice_id` = '$organicAdviceId'";
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0) {
    header("Location: ../views/organicadviceset.php?durum=yes&organic_advice_id=$organicAdviceId&customer_id=$customerId");
  } else {
    header("Location: ../views/organicadviceset.php?durum=no&organic_advice_id=$organicAdviceId&customer_id=$customerId");
  }
}

//SUPPLEMENT PLANI SİLME
if ($_GET['organicadvicesil'] == "ok") {  
  $customerId = $_GET['customer_id'];

  $query = "DELETE FROM `organic_advices` WHERE `organic_advice_id` = '".$_GET['organic_advice_id']."' LIMIT 1"; 
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0 ) {
    header("Location: ../views/customerpage.php?durum=organicadvicesilindi&customer_id=$customerId");
  } else {
    header("Location: ../views/customerpage.php?durum=organicadvicesilinmedi&customer_id=$customerId");
  }
}



//VIDEO EKLEME
if (isset($_POST['addVideo'])) {
  
  $query = "INSERT INTO youtube_embeds (
    video_name, 
    video_link,
    embed_code,
    category
    ) VALUES (
      '".$_POST['videoHead']."', 
      '".$_POST['videoLink']."',
      '".$_POST['embedCode']."',
      '".$_POST['category']."'
      )";
  $result = mysqli_query($link, $query);
  
  if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/addvideo.php?durum=yes");
  } else {
      header("Location: ../views/addvideo.php?durum=no");
  }
}

//VIDEO DÜZENLEME
if (isset($_POST['videoSet'])) {
  $videoId = $_POST['videoId'];
  
    $query = "UPDATE `youtube_embeds` SET 
    `video_name` = '".$_POST['videoName']."', 
    `video_link` = '".$_POST['videoLink']."',
    `embed_code` = '".$_POST['embedCode']."',
    `category` = '".$_POST['category']."'
    WHERE `youtube_embeds`.`youtube_id` = '$videoId'";
    
    $result = mysqli_query($link, $query);
  
    if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/videoset.php?durum=yes&youtube_id=$videoId");
    } else {
      header("Location: ../views/videoset.php?durum=no&youtube_id=$videoId");
    }
  }



//VIDEO SİLME
if ($_GET['videosil'] == "ok") {  
  $videoId = $_GET['youtube_id'];

  $query = "DELETE FROM `youtube_embeds` WHERE `youtube_id` = '".$videoId."' LIMIT 1"; 
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0 ) {
    header("Location: ../views/videos.php?durum=silindi");
  } else {
    header("Location: ../views/videos.php?durum=silinmedi");
  }
}

//KEŞFET (BEFORE - AFTER) EKLEME
if (isset($_POST['addBeforeAfter'])) {

  if(empty($_FILES['beforeImage']['tmp_name'])){
    header("Location: ../views/addbeforeafter.php?durum=nobefore");
  } else if (empty($_FILES['afterImage']['tmp_name'])) {
    header("Location: ../views/addbeforeafter.php?durum=noafter");
  } else {
    
  //Image Upload Before
   $uploads_dir = '../assets/img/uploads';
   @$tmp_name = $_FILES['beforeImage']['tmp_name'];
   @$nameBefore = $_FILES['beforeImage']['name'];
   $benzersizsayi1b = rand(20000, 32000);
   $benzersizsayi2b = rand(20000, 32000);
   $benzersizsayi3b = rand(20000, 32000);
   $benzersizsayi4b = rand(20000, 32000);
   $benzersiadb = $benzersizsayi1b.$benzersizsayi2b.$benzersizsayi3b.$benzersizsayi4b;
   $refimgyolBefore = substr($uploads_dir, 3)."/".$benzersiadb.$nameBefore;

   @move_uploaded_file($tmp_name, "$uploads_dir/$benzersiadb$nameBefore");

   //Image Upload After
   $uploads_dir = '../assets/img/uploads';
   @$tmp_name = $_FILES['afterImage']['tmp_name'];
   @$nameAfter = $_FILES['afterImage']['name'];
   $benzersizsayi1a = rand(20000, 32000);
   $benzersizsayi2a = rand(20000, 32000);
   $benzersizsayi3a = rand(20000, 32000);
   $benzersizsayi4a = rand(20000, 32000);
   $benzersiada = $benzersizsayi1a.$benzersizsayi2a.$benzersizsayi3a.$benzersizsayi4a;
   $refimgyolAfter = substr($uploads_dir, 3)."/".$benzersiada.$nameAfter;

   @move_uploaded_file($tmp_name, "$uploads_dir/$benzersiada$nameAfter");

  

  $query = "INSERT INTO `before_after` (
    before_after_header,
    before_photo, 
    after_photo,
    before_time,
    after_time,
    before_weight,
    after_weight) VALUES (
      '".$_POST['beforeAfterHead']."',
      '../".$refimgyolBefore."',
      '../".$refimgyolAfter."',
      '".$_POST['beforeTime']."',
      '".$_POST['afterTime']."',
      '".$_POST['beforeWeight']."',
      '".$_POST['afterWeight']."'
      )";
  $result = mysqli_query($link, $query);
  
  if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/addbeforeafter.php?durum=yes");
  } else {
      header("Location: ../views/addbeforeafter.php?durum=no");
  }
}
}

//KEŞFET DÜZENLEME
if (isset($_POST['beforeAfterSet'])) {

  $beforeAfterId = $_POST['beforeAfterId'];

  
     $query = "UPDATE `before_after` SET 
    `before_after_header` = '".$_POST['beforeAfterHeader']."', 
    `before_time` = '".$_POST['beforeAfterTime1']."', 
    `after_time` = '".$_POST['beforeAfterTime2']."',
    `before_weight` = '".$_POST['beforeAfterKilo1']."',
    `after_weight` = '".$_POST['beforeAfterKilo2']."'
    
    
    WHERE `before_after`.`before_after_id` = '$beforeAfterId'";
    
    $result = mysqli_query($link, $query);

    if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/beforeafterset.php?durum=yes&before_after_id=$beforeAfterId");
    } else {
      header("Location: ../views/beforeafterset.php?durum=no&before_after_id=$beforeAfterId");
    }
  }
    
//KEŞFET BEFORE GÖRSEL DÜZENLEME
if (isset($_POST['beforeImageSet'])) {

  $beforeAfterId = $_POST['beforeAfterId'];

  $query = "SELECT * FROM `before_after` WHERE `before_after_id` = '$beforeAfterId'";
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result);

  //Delete Old Image
  unlink($row['before_photo']);

  //Image Upload Before
  $uploads_dir = '../assets/img/uploads';
  @$tmp_name = $_FILES['beforeImage']['tmp_name'];
  @$nameBefore = $_FILES['beforeImage']['name'];
  $benzersizsayi1b = rand(20000, 32000);
  $benzersizsayi2b = rand(20000, 32000);
  $benzersizsayi3b = rand(20000, 32000);
  $benzersizsayi4b = rand(20000, 32000);
  $benzersiadb = $benzersizsayi1b.$benzersizsayi2b.$benzersizsayi3b.$benzersizsayi4b;
  $refimgyolBefore = substr($uploads_dir, 3)."/".$benzersiadb.$nameBefore;

  @move_uploaded_file($tmp_name, "$uploads_dir/$benzersiadb$nameBefore");
  
     $query = "UPDATE `before_after` SET 
    
    `before_photo` = '../".$refimgyolBefore."'
    
    WHERE `before_after`.`before_after_id` = '$beforeAfterId'";
    
    $result = mysqli_query($link, $query);

    if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/beforeafterset.php?durum=yes&before_after_id=$beforeAfterId");
    } else {
      header("Location: ../views/beforeafterset.php?durum=no&before_after_id=$beforeAfterId");
    }
  }

//KEŞFET AFTER GÖRSEL DÜZENLEME
if (isset($_POST['afterImageSet'])) {

  $beforeAfterId = $_POST['beforeAfterId'];

  $query = "SELECT * FROM `before_after` WHERE `before_after_id` = '$beforeAfterId'";
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result);

  //Delete Old Image
  unlink($row['after_photo']);

  //Image Upload After
  $uploads_dir = '../assets/img/uploads';
  @$tmp_name = $_FILES['afterImage']['tmp_name'];
  @$nameAfter = $_FILES['afterImage']['name'];
  $benzersizsayi1a = rand(20000, 32000);
  $benzersizsayi2a = rand(20000, 32000);
  $benzersizsayi3a = rand(20000, 32000);
  $benzersizsayi4a = rand(20000, 32000);
  $benzersiada = $benzersizsayi1a.$benzersizsayi2a.$benzersizsayi3a.$benzersizsayi4a;
  $refimgyolAfter = substr($uploads_dir, 3)."/".$benzersiada.$nameAfter;

  @move_uploaded_file($tmp_name, "$uploads_dir/$benzersiada$nameAfter");
  
     $query = "UPDATE `before_after` SET 
  
    `after_photo` = '../".$refimgyolAfter."'
    
    WHERE `before_after`.`before_after_id` = '$beforeAfterId'";
    
    $result = mysqli_query($link, $query);

    if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/beforeafterset.php?durum=yes&before_after_id=$beforeAfterId");
    } else {
      header("Location: ../views/beforeafterset.php?durum=no&before_after_id=$beforeAfterId");
    }    
  
  } 
    


//YENI PAKET EKLEME
if (isset($_POST['addPackage'])) {

 if ($_POST['packageDuration']=="6 Haftalık") {
  $packageTime = 1.5;
 } else if ($_POST['packageDuration']=="3 Aylık") {
  $packageTime = 3;
 } else if ($_POST['packageDuration']=="6 Aylık") {
  $packageTime = 6;
 } else if ($_POST['packageDuration']=="12 Aylık") {
  $packageTime = 12;
 } 
  

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
  

  $query = "INSERT INTO packages (
    package_name, 
    package_body, 
    package_duration,
    package_time, 
    package_image, 
    package_price ) 
    VALUES (
      '".$_POST['packageHead']."', 
      '".$_POST['editor1']."', 
      '".$_POST['packageDuration']."', 
      '".$packageTime."', 
      '../".$refimgyol."', 
      '".$_POST['packagePrice']."'
      )";
  $result = mysqli_query($link, $query);
  
  if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/addpackage.php?durum=yes");
  } else {
      header("Location: ../views/addpackage.php?durum=no");
  }
}

//PAKET DÜZENLEME
if (isset($_POST['packageSet'])) {
  $packageId = $_POST['packageId'];
  $packageTime = $_POST['packageTime'];

  $query = "SELECT * FROM `packages` WHERE `package_id` = '$packageId'";
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result);

  if ($_POST['packageDuration']=="6 Haftalık") {
    $packageTime = 1.5;
   } else if ($_POST['packageDuration']=="3") {
    $packageTime = 3;
   } else if ($_POST['packageDuration']=="6") {
    $packageTime = 6;
   } else if ($_POST['packageDuration']=="12") {
    $packageTime = 12;
   } 
  
  if(!empty($_FILES['profileImage']['tmp_name'])){ //new image uploaded

  //Delete Old Image
  unlink($row['package_image']);
    
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


    $query = "UPDATE `packages` SET 
    `package_name` = '".$_POST['packageName']."', 
    `package_body` = '".$_POST['editor1']."', 
    `package_duration` = '".$_POST['packageDuration']."',
    `package_time` = '".$packageTime."',
    `package_price` = '".$_POST['packagePrice']."',
    `package_image` = '../".$refimgyol."'
    WHERE `packages`.`package_id` = '$packageId'";
    
    $result = mysqli_query($link, $query);
  } else {
    $query = "UPDATE `packages` SET 
    `package_name` = '".$_POST['packageName']."', 
    `package_body` = '".$_POST['editor1']."', 
    `package_duration` = '".$_POST['packageDuration']."',
    `package_time` = '".$packageTime."',
    `package_price` = '".$_POST['packagePrice']."'
    WHERE `packages`.`package_id` = '$packageId'";
    
    $result = mysqli_query($link, $query);
  }
    if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/packageset.php?durum=yes&package_id=$packageId");
    } else {
      header("Location: ../views/packageset.php?durum=no&package_id=$packageId");
    }
  }

//PAKET SİLME
if ($_GET['packagesil'] == "ok") {  
  $packageId = $_GET['package_id'];

  $query = "DELETE FROM `packages` WHERE `package_id` = '".$packageId."' LIMIT 1"; 
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0 ) {

    $imgDelete = $_GET['imgdelete'];
    unlink("$imgDelete");
    header("Location: ../views/packages.php?durum=silindi");
  } else {
    header("Location: ../views/packages.php?durum=silinmedi");
  }
}

//PAKET ALMA
if (isset($_POST['buyPackage'])) {

  $customerId = $_POST['customerId'];
  $packageId = $_POST['packageId'];
  $packageName = $_POST['packageName'];
  $packageTime = $_POST['packageTime'];
  $packageDate = date("Y-m-d H:i:s");
  

  //End Date Hesaplama
  $queryPackage = "SELECT * FROM packages WHERE package_id = '$packageId'";
  $resultPackage = mysqli_query($link, $queryPackage);
  $rowPackage = mysqli_fetch_array( $resultPackage);
  

  $date_expire = $rowPackage['package_time'];
  if ($date_expire == 1.5) {
    $endDate = date('Y/m/d', strtotime('+6 weeks'));
  } else {
    $endDate = date('Y/m/d', strtotime(+$date_expire.'month'));
  }
  
  


  $query = "UPDATE `customers` SET 
  `package_type_id` = '".$packageId."', 
  `package_name` = '".$packageName."',
  `starting_date` = '".$packageDate."',
  `ending_date` = '".$endDate."', 
  `package` = '1'
  WHERE `customers`.`customer_id` = '$customerId'";
  $result = mysqli_query($link, $query);
  
  if (mysqli_affected_rows($link) > 0) {
      header("Location: ../customer/index.php?durum=yes");
  } else {
      header("Location: ../customer/index.php?durum=no");
  }
}

//PROFİL DÜZENLEME (KULLANICI)
if (isset($_POST['profileSet'])) {
  $customerId = $_POST['customerId'];

    $query = "UPDATE `customers` SET 
    
    `customer_name` = '".$_POST['customerName']."',
    `customer_surname` = '".$_POST['customerSurName']."',
    `customer_email` = '".$_POST['customerEmail']."',
    `customer_phone` = '".$_POST['customerPhone']."',
    `customer_job` = '".$_POST['customerJob']."',
    `body_fat` = '".$_POST['bodyFat']."',
    `age` = '".$_POST['customerAge']."',
    `weight` = '".$_POST['customerWeight']."',
    `height` = '".$_POST['customerHeight']."',
    `subscription_type` = '".$_POST['subscriptionType']."',
    `gender` = '".$_POST['customerGender']."',
    `nutrition_budget` = '".$_POST['nutritionBudget']."',
    `wake_up_time` = '".$_POST['wakeUpTime']."',
    `sleep_time` = '".$_POST['sleepTime']."',
    `breakfast_time` = '".$_POST['breakfastTime']."',
    `training_time` = '".$_POST['trainingTime']."',
    `training_place` = '".$_POST['trainingPlace']."',
    `daily_routine` = '".$_POST['dailyRoutine']."'
    
    
    WHERE `customers`.`customer_id` = '$customerId'";
    $result = mysqli_query($link, $query);
    $change1 = mysqli_affected_rows($link);

    //Vardiya durumu 
    $queryShift = "SELECT * FROM `detailed_shift` WHERE `customer_id` = '$customerId'";
    $resultShift = mysqli_query($link, $queryShift);
    $rowShift = mysqli_fetch_array($resultShift);

    if ($rowShift) {
      $queryUpdateShift= "UPDATE `detailed_shift` SET
      `detailed_shift_name` = '".$_POST['detailedShiftName']."',
      `detailed_shift_body` = '".$_POST['detailedShiftBody']."'

      WHERE `detailed_shift`.`customer_id` = '$customerId'";
      $resultUpdateShift = mysqli_query($link, $queryUpdateShift);
    } else {
      $queryAddShift = "INSERT INTO detailed_shift (customer_id, detailed_shift_name, detailed_shift_body) VALUES ('".$customerId."', '".$_POST['detailedShiftName']."', '".$_POST['detailedShiftBody']."')";
      $resultAddShift = mysqli_query($link, $queryAddShift);
    }
    $change2 = mysqli_affected_rows($link);
    //Sağlık durumu 
    $queryHealth = "SELECT * FROM `health` WHERE `customer_id` = '$customerId'";
    $resultHealth = mysqli_query($link, $queryHealth);
    $rowHealth = mysqli_fetch_array($resultHealth);

    if ($rowHealth) {
      $queryUpdateHealth= "UPDATE `health` SET
      `health_name` = '".$_POST['healthName']."',
      `health_body` = '".$_POST['healthBody']."'

      WHERE `health`.`customer_id` = '$customerId'";
      $resultUpdateHealth = mysqli_query($link, $queryUpdateHealth);
    } else {
      $queryAddHealth = "INSERT INTO health (customer_id, health_name, health_body) VALUES ('".$customerId."', '".$_POST['healthName']."', '".$_POST['healthBody']."')";
      $resultAddHealth = mysqli_query($link, $queryAddHealth);
    }
    $change3 = mysqli_affected_rows($link);
    //Alerji durumu 
    $queryAllergy = "SELECT * FROM `allergy` WHERE `customer_id` = '$customerId'";
    $resultAllergy = mysqli_query($link, $queryAllergy);
    $rowAllergy = mysqli_fetch_array($resultAllergy);

    if ($rowAllergy) {
      $queryUpdateAllergy= "UPDATE `allergy` SET
      `allergy_name` = '".$_POST['allergyName']."',
      `allergy_body` = '".$_POST['allergyBody']."'

      WHERE `allergy`.`customer_id` = '$customerId'";
      $resultUpdateAllergy = mysqli_query($link, $queryUpdateAllergy);
    } else {
      $queryAddAllergy = "INSERT INTO allergy (customer_id, allergy_name, allergy_body) VALUES ('".$customerId."', '".$_POST['allergyName']."', '".$_POST['allergyBody']."')";
      $resultAddAllergy = mysqli_query($link, $queryAddAllergy);
    }
    
    $change4 = mysqli_affected_rows($link);
    $totalChange = $change1 + $change2 + $change3 + $change4;
    if ($totalChange > 0 ) {
      header("Location: ../customer/profileset.php?durum=yes&customer_id=$customerId");
    } else {
      header("Location: ../customer/profileset.php?durum=no&customer_id=$customerId");
    } 
  }

//BLOG EKLEME
if (isset($_POST['addBlog'])) {

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
  

  $query = "INSERT INTO blogs (
    blog_head, 
    blog_body, 
    blog_image 
    ) VALUES (
      '".$_POST['blogHead']."', 
      '".$_POST['editor1']."', 
      '../".$refimgyol."')";

  $result = mysqli_query($link, $query);
  
  if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/addblog.php?durum=yes");
  } else {
      header("Location: ../views/addblog.php?durum=no");
  }
}

//BLOG DÜZENLEME
if (isset($_POST['blogSet'])) {
  $blogId = $_POST['blogId'];

  $query = "SELECT * FROM `blogs` WHERE `blog_id` = '$blogId'";
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result);
  
  if(!empty($_FILES['profileImage']['tmp_name'])){ //new image uploaded

    //Delete Old Image
    unlink($row['blog_image']);
    
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


    $query = "UPDATE `blogs` SET 
    `blog_head` = '".$_POST['blogHead']."', 
    `blog_body` = '".$_POST['editor1']."',
    `blog_image` = '../".$refimgyol."'
    WHERE `blogs`.`blog_id` = '$blogId'";
    
    $result = mysqli_query($link, $query);
  } else {
    $query = "UPDATE `blogs` SET 
    `blog_head` = '".$_POST['blogHead']."', 
    `blog_body` = '".$_POST['editor1']."'
    WHERE `blogs`.`blog_id` = '$blogId'";
    
    $result = mysqli_query($link, $query);
  }
    if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/blogset.php?durum=yes&blog_id=$blogId");
    } else {
      header("Location: ../views/blogset.php?durum=no&blog_id=$blogId");
    }
  }

  //BLOG SİLME
if ($_GET['blogsil'] == "ok") {  
  $blogId = $_GET['blog_id'];

  $query = "DELETE FROM `blogs` WHERE `blog_id` = '".$blogId."' LIMIT 1"; 
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0 ) {
    $imgDelete = $_GET['imgdelete'];

    unlink("$imgDelete");
    header("Location: ../views/blog.php?durum=silindi");
  } else {
    header("Location: ../views/blog.php?durum=silinmedi");
  }
}

//BİYOGRAFİ DÜZENLEME
if (isset($_POST['bioSet'])) {
  $bioId = $_POST['bioId'];

  $query = "SELECT * FROM `bio`";
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result);
  
  if(!empty($_FILES['profileImage']['tmp_name'])){ //new image uploaded

    //Delete Old Image
    unlink($row['bio_image']);
    
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


    $query = "UPDATE `bio` SET 
    `bio_head` = '".$_POST['bioHead']."', 
    `bio_body` = '".$_POST['editor1']."',
    `bio_image` = '../".$refimgyol."'
    WHERE `bio`.`bio_id` = '$bioId'";
    
    $result = mysqli_query($link, $query);
  } else {
    $query = "UPDATE `bio` SET 
    `bio_head` = '".$_POST['bioHead']."', 
    `bio_body` = '".$_POST['editor1']."'
    WHERE `bio`.`bio_id` = '$bioId'";
    
    $result = mysqli_query($link, $query);
  }
    if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/bioset.php?durum=yes&bio_id=$bioId");
    } else {
      header("Location: ../views/bioset.php?durum=no&bio_id=$bioId");
    }
  }

  //MESAJ SİSTEMİ
//User mesaj gönderme

if (isset($_POST['userMessageSent'])) {

  $adminUserId = $_POST['adminUserId'];
  $customerId = $_POST['customerId'];
  $bodyImageId = $_POST['bodyImageId'];
  
  $query = "INSERT INTO conversations (
    admin_user_id,
    customer_id,
    body_image_id,
    ifreadCustomer,
    ifread,
    user_send
    ) VALUES (
      '".$adminUserId."',
      '".$customerId."',
      '".$bodyImageId."',
      '0',
      '1',
      '".$_POST['messageBody']."'
      )";
  $result = mysqli_query($link, $query);
  
  if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/conversation.php?dur=yes&customer_id=$customerId");
  } else {
      header("Location: ../views/conversation.php?dur=no&customer_id=$customerId");
  }
}

//Customer mesaj gönderme

if (isset($_POST['customerMessageSent'])) {

  $adminUserId = $_POST['adminUserId'];
  $customerId = $_POST['customerId'];
  $bodyImageId = $_POST['bodyImageId'];
  
  $query = "INSERT INTO conversations (
    admin_user_id,
    customer_id,
    body_image_id,
    ifread,
    ifreadCustomer,
    customer_send
    ) VALUES (
      '".$adminUserId."',
      '".$customerId."',
      '".$bodyImageId."',
      '0',
      '1',
      '".$_POST['messageBody']."'
      )";
  $result = mysqli_query($link, $query);
  
  if (mysqli_affected_rows($link) > 0) {
      header("Location: ../customer/chat.php?dur=yes&customer_id=$customerId");
  } else {
      header("Location: ../customer/chat.php?dur=no&customer_id=$customerId");
  }
}

//MESAJ OKUNDU User
if (isset($_POST['updateCon'])) {

  $adminUserId = $_POST['adminUserId'];
  $customerId = $_POST['customer_id'];

  $query = "UPDATE `conversations` SET 
    `ifread` = 1
    
    WHERE `conversations`.`customer_id` = '$customerId' && `admin_user_id` = '$adminUserId'";
    
    $result = mysqli_query($link, $query);
    header("Location: ../views/conversation.php?dur=yes&customer_id=$customerId");
}


//MESAJ OKUNDU Customer
if (isset($_POST['updateConCustomer'])) {

  $adminUserId = $_POST['adminUserId'];
  $customerId = $_POST['customer_id'];

  $query = "UPDATE `conversations` SET 
    `ifreadCustomer` = 1
    
    WHERE `conversations`.`customer_id` = '$customerId' && `admin_user_id` = '$adminUserId'";
    
    $result = mysqli_query($link, $query);
    header("Location: ../customer/chat.php?dur=yes&customer_id=$customerId");
}

//ANTRENMAN FOTOĞRAFI VE BİLDİRİM
if (isset($_POST['sendtrainfeedback'])) {
  $customerId = $_POST['customerId'];

if(empty($_FILES['trainImage']['tmp_name'])){
  header("Location: ../customer/sendtrainfeedback.php?durum=noimage&customer_id=$customerId");
} else {
  
//Image Upload
 $uploads_dir = '../assets/img/uploads';
 @$tmp_name = $_FILES['trainImage']['tmp_name'];
 @$name = $_FILES['trainImage']['name'];
 $benzersizsayi1 = rand(20000, 32000);
 $benzersizsayi2 = rand(20000, 32000);
 $benzersizsayi3 = rand(20000, 32000);
 $benzersizsayi4 = rand(20000, 32000);
 $benzersiad = $benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
 $refimgyol = substr($uploads_dir, 3)."/".$benzersiad.$name;

 @move_uploaded_file($tmp_name, "$uploads_dir/$benzersiad$name");

 $queryTrainingImage = "INSERT INTO `training_photos` (
  `customer_id`, 
  `training_photo_image` 
  ) VALUES (
    '".$customerId."',
    '../".$refimgyol."'
    )"; 

$resultTrainingImage = mysqli_query($link, $queryTrainingImage);
if (mysqli_affected_rows($link) > 0) {
header("Location: ../customer/sendtrainfeedback.php?durum=yes&customer_id=$customerId");
} else {
header("Location: ../customer/sendtrainfeedback.php?durum=no&customer_id=$customerId");
}
  }
}

//ANTRENMAN FOTOĞRAFI VE BİLDİRİM ADMİN NOTU
if (isset($_POST['trainingAdminNoteSent'])) {
  $trainingPhotoId = $_POST['trainingPhotoId'];
  $customerId = $_POST['customerId'];

  $query = "SELECT * FROM `training_photos` WHERE `training_photo_id` = '$trainingPhotoId'";
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result);
  
    $query = "UPDATE `training_photos` SET 
    `admin_notes` = '".$_POST['trainingAdminNote']."' 
    WHERE `training_photos`.`training_photo_id` = '$trainingPhotoId'";
    
    $result = mysqli_query($link, $query);

    if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/customerpage.php?durum=trainAdminNoteYes&customer_id=$customerId");
    } else {
      header("Location: ../views/customerpage.php?durum=trainAdminNoteNo&customer_id=$customerId");
    }
  }

  //ANTRENMAN FOTOĞRAFI VE BİLDİRİM ADMİN NOTU (Antrenman Fotoğrafları Sayfasından)
if (isset($_POST['trainingPhotoSet'])) {
  $trainingPhotoId = $_POST['trainingPhotoId'];
  $customerId = $_POST['customerId'];

  $query = "SELECT * FROM `training_photos` WHERE `training_photo_id` = '$trainingPhotoId'";
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result);
  
    $query = "UPDATE `training_photos` SET 
    `admin_notes` = '".$_POST['editor1']."' 
    WHERE `training_photos`.`training_photo_id` = '$trainingPhotoId'";
    
    $result = mysqli_query($link, $query);

    if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/trainingphotoset.php?durum=yes&customer_id=$customerId&training_photo_id=$trainingPhotoId");
    } else {
      header("Location: ../views/trainingphotoset.php?durum=no&customer_id=$customerId&training_photo_id=$trainingPhotoId");
    }
  }

//ANTRENMAN FOTOĞRAFI VE BİLDİRİM ADMİN NOTU GÖRÜLDÜ(Antrenman Fotoğrafları Sayfasından)
if ($_GET['trainingPhotoSeen'] == "ok") {  
  $trainingPhotoId = $_GET['training_photo_id'];
  $customerId = $_GET['customer_id'];

  $query = "UPDATE `training_photos` SET 
    `ifseen` = 1
    WHERE `training_photos`.`training_photo_id` = '$trainingPhotoId'";

      $result = mysqli_query($link, $query);

      if (mysqli_affected_rows($link) > 0) {
        header("Location: ../views/trainingphotoset.php?customer_id=$customerId&training_photo_id=$trainingPhotoId");
      } else {
        header("Location: ../views/trainingphotoset.php?customer_id=$customerId&training_photo_id=$trainingPhotoId");
      }
  }



 //ANTRENMAN FOTOĞRAFI VE BİLDİRİM SİLME (Profil içinden)
 if ($_GET['trainingphotosil'] == "ok") {  
  $trainingPhotoId = $_GET['training_photo_id'];
  $customerId = $_GET['customer_id'];

  $query = "DELETE FROM `training_photos` WHERE `training_photo_id` = '".$trainingPhotoId."' LIMIT 1"; 
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0 ) {
    $imgDelete = $_GET['imgdelete'];

    unlink("$imgDelete");
    header("Location: ../views/customerpage.php?durum=trainphotosilindi&customer_id=$customerId");
  } else {
    header("Location: ../views/customerpage.php?durum=trainphotosilinmedi&customer_id=$customerId");
  }
}

//ANTRENMAN FOTOĞRAFI VE BİLDİRİM SİLME (Antrenmanlar sayfasından)
if ($_GET['trainingphotosil2'] == "ok") {  
  $trainingPhotoId = $_GET['training_photo_id'];
  $customerId = $_GET['customer_id'];

  $query = "DELETE FROM `training_photos` WHERE `training_photo_id` = '".$trainingPhotoId."' LIMIT 1"; 
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0 ) {
    $imgDelete = $_GET['imgdelete'];

    unlink("$imgDelete");
    header("Location: ../views/trainings.php?durum=silindi");
  } else {
    header("Location: ../views/trainings.php?durum=silinmedi");
  }
}


//BESLENME FOTOĞRAFI VE BİLDİRİM
if (isset($_POST['sendnutritionfeedback'])) {
  $customerId = $_POST['customerId'];

if(empty($_FILES['nutritionImage']['tmp_name'])){
  header("Location: ../customer/sendnutritionfeedback.php?durum=noimage&customer_id=$customerId");
} else {
  
//Image Upload
 $uploads_dir = '../assets/img/uploads';
 @$tmp_name = $_FILES['nutritionImage']['tmp_name'];
 @$name = $_FILES['nutritionImage']['name'];
 $benzersizsayi1 = rand(20000, 32000);
 $benzersizsayi2 = rand(20000, 32000);
 $benzersizsayi3 = rand(20000, 32000);
 $benzersizsayi4 = rand(20000, 32000);
 $benzersiad = $benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
 $refimgyol = substr($uploads_dir, 3)."/".$benzersiad.$name;

 @move_uploaded_file($tmp_name, "$uploads_dir/$benzersiad$name");

 $queryNutritionImage = "INSERT INTO `nutrition_photos` (
  `customer_id`, 
  `nutrition_photo_image`,
  `nutrition_photo_meal` 
  ) VALUES (
    '".$customerId."',
    '../".$refimgyol."',
    '".$_POST['nutritionPhotoMeal']."'
    )"; 

$resultNutritionImage = mysqli_query($link, $queryNutritionImage);
if (mysqli_affected_rows($link) > 0) {
header("Location: ../customer/sendnutritionfeedback.php?durum=yes&customer_id=$customerId");
} else {
header("Location: ../customer/sendnutritionfeedback.php?durum=no&customer_id=$customerId");
}
  }
}

//BESLENME FOTOĞRAFI VE BİLDİRİM ADMİN NOTU
if (isset($_POST['nutritionAdminNoteSent'])) {
  $nutritionPhotoId = $_POST['nutritionPhotoId'];
  $customerId = $_POST['customerId'];

  $query = "SELECT * FROM `nutrition_photos` WHERE `nutrition_photo_id` = '$nutritionPhotoId'";
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result);
  
    $query = "UPDATE `nutrition_photos` SET 
    `admin_notes` = '".$_POST['nutritionAdminNote']."',
    `nutrition_check` = '".$_POST['nutritionCheck']."'
    WHERE `nutrition_photos`.`nutrition_photo_id` = '$nutritionPhotoId'";
    
    $result = mysqli_query($link, $query);

    if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/customerpage.php?durum=nutritionAdminNoteYes&customer_id=$customerId");
    } else {
      header("Location: ../views/customerpage.php?durum=nutritionAdminNoteNo&customer_id=$customerId");
    }
  }

 //BESLENME FOTOĞRAFI VE BİLDİRİM SİLME
 if ($_GET['nutritionphotosil'] == "ok") {  
  $nutritionPhotoId = $_GET['nutrition_photo_id'];
  $customerId = $_GET['customer_id'];

  $query = "DELETE FROM `nutrition_photos` WHERE `nutrition_photo_id` = '".$nutritionPhotoId."' LIMIT 1"; 
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0 ) {
    $imgDelete = $_GET['imgdelete'];

    unlink("$imgDelete");
    header("Location: ../views/customerpage.php?durum=nutritionphotosilindi&customer_id=$customerId&customer_id=$customerId");
  } else {
    header("Location: ../views/customerpage.php?durum=nutritionphotosilinmedi&customer_id=$customerId&customer_id=$customerId");
  }
}

//BESLENME FOTOĞRAFI VE BİLDİRİM ADMİN NOTU (Beslenme Fotoğrafları Sayfasından)
if ($_GET['nutritionPhotoSeen'] == "ok") {  
  $nutritionPhotoId = $_GET['nutrition_photo_id'];
  $customerId = $_GET['customer_id'];

  $query = "UPDATE `nutrition_photos` SET 
    `ifseen` = 1
    WHERE `nutrition_photos`.`nutrition_photo_id` = '$nutritionPhotoId'";

      $result = mysqli_query($link, $query);

      if (mysqli_affected_rows($link) > 0) {
        header("Location: ../views/nutritionphotoset.php?customer_id=$customerId&nutrition_photo_id=$nutritionPhotoId");
      } else {
        header("Location: ../views/nutritionphotoset.php?customer_id=$customerId&nutrition_photo_id=$nutritionPhotoId");
      }
  }

  //BESLENME FOTOĞRAFI VE BİLDİRİM ADMİN NOTU (Beslenme Fotoğrafları Sayfasından)
if (isset($_POST['nutritionPhotoSet'])) {
  $nutritionPhotoId = $_POST['nutritionPhotoId'];
  $customerId = $_POST['customerId'];

  $query = "SELECT * FROM `nutrition_photos` WHERE `nutrition_photo_id` = '$nutritionPhotoId'";
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result);
  
    $query = "UPDATE `nutrition_photos` SET 
    `admin_notes` = '".$_POST['editor1']."',
    `nutrition_check` = '".$_POST['nutritionCheck']."' 
    WHERE `nutrition_photos`.`nutrition_photo_id` = '$nutritionPhotoId'";
    
    $result = mysqli_query($link, $query);

    if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/nutritions.php?durum=yes&customer_id=$customerId&nutrition_photo_id=$nutritionPhotoId");
    } else {
      header("Location: ../views/nutritions.php?durum=no&customer_id=$customerId&nutrition_photo_id=$nutritionPhotoId");
    }
  }

  //BESLENME FOTOĞRAFI VE BİLDİRİM SİLME (Beslenme sayfasından)
if ($_GET['nutritionphotosil2'] == "ok") {  
  $nutritionPhotoId = $_GET['nutrition_photo_id'];
  $customerId = $_GET['customer_id'];

  $query = "DELETE FROM `nutrition_photos` WHERE `nutrition_photo_id` = '".$nutritionPhotoId."' LIMIT 1"; 
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0 ) {
    $imgDelete = $_GET['imgdelete'];

    unlink("$imgDelete");
    header("Location: ../views/nutritions.php?durum=silindi");
  } else {
    header("Location: ../views/nutritions.php?durum=silinmedi");
  }
}


//Kupon EKLEME
if (isset($_POST['addCoupon'])) {

  $query = "INSERT INTO coupons (
    coupon_header, 
    code,
    discount,
    expire 
    ) VALUES (
      '".$_POST['couponHead']."', 
      '".$_POST['code']."',
      '".$_POST['discount']."', 
      '".$_POST['expire']."')";

  $result = mysqli_query($link, $query);
  
  if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/addcoupon.php?durum=yes");
  } else {
      header("Location: ../views/addcoupon.php?durum=no");
  }
}

//KUPON DÜZENLEME
if (isset($_POST['couponSet'])) {
  $couponId = $_POST['couponId'];

  $query = "SELECT * FROM `coupons` WHERE `coupon_id` = '$couponId'";
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result);
  

    $query = "UPDATE `coupons` SET 
    `coupon_header` = '".$_POST['couponHead']."', 
    `discount` = '".$_POST['discount']."',
    `code` = '".$_POST['code']."',
    `expire` = '".$_POST['expire']."'
    WHERE `coupons`.`coupon_id` = '$couponId'";
    
    $result = mysqli_query($link, $query);

    if (mysqli_affected_rows($link) > 0) {
      header("Location: ../views/couponset.php?durum=yes&coupon_id=$couponId");
    } else {
      header("Location: ../views/couponset.php?durum=no&coupon_id=$couponId");
    }
  }

  //KUPON SİLME
if ($_GET['couponsil'] == "ok") {  
  $couponId = $_GET['coupon_id'];

  $query = "DELETE FROM `coupons` WHERE `coupon_id` = '".$couponId."' LIMIT 1"; 
  $result = mysqli_query($link, $query);

  if (mysqli_affected_rows($link) > 0 ) {
    
    header("Location: ../views/coupons.php?durum=silindi");
  } else {
    header("Location: ../views/coupons.php?durum=silinmedi");
  }
}

?>