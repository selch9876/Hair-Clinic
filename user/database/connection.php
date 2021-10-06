<?php  
	//session_start();
    $serv = "127.0.0.1";
    $userName = "root";
    $password = "";
    $dbName = "hair";

    $link = mysqli_connect($serv, $userName, $password, $dbName);

    mysqli_query($link,"SET CHARACTER SET 'utf8'");
	mysqli_query($link,"SET SESSION collation_connection ='utf8_unicode_ci'");

    if (mysqli_connect_error()) {
    die ("Veritabanı bağlantısında hata var");
    }

    $errors = [];

    

?>