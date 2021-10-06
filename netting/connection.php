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

    

    //Nav Active Page Setter 

    $name = $_SESSION['admin_name'];

    $queryUser = "SELECT * FROM `admin_users` WHERE admin_name = '$name'";
    $resultUser = mysqli_query($link, $queryUser);
    $rowUser = mysqli_fetch_array($resultUser);

     // 0 is lesser 1 is super user
        $pages = array();
    $pages["index.php"] = "Anasayfa";
    $pages["users.php"] = "Kullanıcılar";
    $pages["adduser.php"] = "Kullanıcı Ekle";
    
    //$activePage = explode('/', $_SERVER['REQUEST_URI']) ;

    $linkTitle = $_SERVER['PHP_SELF'];
    $link_array = explode('/',$linkTitle);
    $page = end($link_array);

?>