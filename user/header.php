<?php include "database/connection.php"; 
session_start();
ob_start();


?>

<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Hair Clinic</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Spor hocanız mobil cihazınız kadar yakın!" />
	<meta name="keywords" content="oktopower, fitness, fitness dersleri" />
	<meta name="author" content="" />

  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,700,800" rel="stylesheet">
	<link rel="shortcut icon" href="images/OKTO POWER LOGO-2.png" type="image/x-icon">

	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">

	<!-- Magnific Popup -->
	<link rel="stylesheet" href="css/magnific-popup.css">

	<!-- Owl Carousel  -->
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">

	<!-- Boom-Lightbox  -->
	<link rel="stylesheet" type="text/css" href="boom-lightbox/css/boom-lightbox/boom-lightbox.1.0.0.min.css" /> 

	<link rel="stylesheet" href="mobile/assets/css/mobster.css">
  	

	<!-- Theme style  -->
	<link rel="stylesheet" href="css/style.css">
	
	 <!--product css-->
     <link rel="stylesheet" href="css/product.css">

	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	
<script type="text/javascript" src="js/boom-lightbox/boom-lightbox.1.0.0.min.js"></script>

<style>
    
</style>
	</head>
	<body>

    <div class="fh5co-loader"></div>
	
	<div id="page">
	<nav class="fh5co-nav" role="navigation">
		<div class="top">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 text-right">
						<p class="num"></p>
						<ul class="fh5co-social">
							<li><a href="https://www.instagram.com/oktopowerofficial/" target="_blank"><i class="icon-instagram"></i></a></li>
							<?php if(isset($_SESSION['customer_email'])): ?>
							<li><a href="logout.php">ÇIKIŞ YAP</a></li>
							<li><a href="profile.php">PROFİLİM</a></li>
							<?php else: ?>
							<li><a href="login.php">MÜŞTERİ GİRİŞİ</a></li>
							<li><a href="register.php">KAYIT</a></li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="top-menu">
			<div class="container">
				<div class="row">
					<div class="col-xs-2">
						<div id="fh5co-logo"><a href="index.php"><img src="images/OKTO POWER LOGO-2.png" alt="" width="75px"></a></div>
					</div>
					<div class="col-xs-10 text-right menu-1">
						<ul>
							<li class="active"><a href="index.php">ANASAYFA</a></li>
							
							
	
						</ul>
					</div>
				</div>
				
			</div>
		</div>
	</nav>

