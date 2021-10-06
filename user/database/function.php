<?php

ob_start();
session_start();

include "connection.php"; 

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
  header("Location: ../register.php?dur=weak");
} else {
  $password = md5($_POST["parola"]);
  $email = $_POST['eposta'];

  $queryCheck = "SELECT * FROM customers WHERE customer_email = '$email'";
  $resultCheck = mysqli_query($link, $queryCheck);

  if (mysqli_num_rows($resultCheck) > 0) {
    header("Location: ../register.php?dur=already");
  } else if ($_POST['customerName'] == ""){
    header("Location: ../register.php?dur=noname");
  } else if ($_POST['customerSurName'] == ""){
    header("Location: ../register.php?dur=nosurname");
  } else if ($_POST['eposta'] == ""){
    header("Location: ../register.php?dur=nomail");
  } else if ($_POST['parola'] == ""){
    header("Location: ../register.php?dur=nopass");
  } else if ($_POST["parola"] != $_POST["reparola"]) {
    header("Location: ../register.php?dur=no");
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
      header("Location: ../login.php?dur=yes");
    } else {
      header("Location: ../register.php?dur=nokayit");
    }
  }
}
}

// KULLANICI GİRİŞİ
if (array_key_exists('customerLogin', $_POST)) {
  $email = $_POST["customerEmail"];
  $password = md5($_POST["password"]);
  
  if ($email == ""){header("Location: ../login.php?dur=noname");} else {
    if ($password == ""){header("Location: ../login.php?dur=nopass");} else {
      $rawQuery = "SELECT * FROM users WHERE `email` = '%s' AND password = '%s'" ;
      $query = sprintf($rawQuery, mysqli_real_escape_string($link, $email), mysqli_real_escape_string($link, $password)); 
      $result = mysqli_query($link, $query);

      if (mysqli_num_rows($result) > 0) {
        $_SESSION['email'] = $email;

        header("Location: ../index.php"); 
      } else {
       header("Location: ../login.php?dur=no");
     }
   }
 }
}

//PAKET ALMA
if (isset($_POST['buyPackage'])) {

    if (isset($_SESSION['customer_email'])) {
      
    
  
  $packageId = $_POST['packageId'];
  $packageName = $_POST['packageName'];
  $packageTime = $_POST['packageTime'];
  $packageDate = date("Y-m-d H:i:s");

  $email = $_SESSION['customer_email'];

        $queryCustomer = "SELECT * FROM customers WHERE customer_email = '$email'";
        $resultCustomer = mysqli_query($link, $queryCustomer);
        $rowCustomer = mysqli_fetch_array($resultCustomer);
        $customerId = $rowCustomer['customer_id'];
        $packageCheck = $rowCustomer['package'];
        if ($packageCheck == 1) {
          header("Location: ../index.php?durum=already");
        } else {
  

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
      header("Location: ../profile.php?durum=bought");
  } else {
      header("Location: ../pricing.php?durum=notbought");
  }
} //packagecheck

} else { 
  header("Location: ../login.php?dur=logincheck");
}
}


  

  

?>