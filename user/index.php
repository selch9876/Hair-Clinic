<?php include 'header.php'; 

$email = $_SESSION['email'];

if (!isset($_SESSION['email'])) {
    header("Location: login.php");  
}

$query = "SELECT * FROM users WHERE `email` = '$email'" ;
$result = mysqli_query($link, $query);
$row = mysqli_fetch_array($result);

$userId = $row['user_id'];

if ($row['photo_start']==1) {
	
?>

		
	<header id="fh5co-header"  data-stellar-background-ratio="0.5">
		
		<div class="container">	
			<div class="row">

			<h3>Beş Adet Fotoğraf</h3>
			<form  action="../netting/function.php" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="userId" value="<?php echo $userId; ?>">
				<div class="row">  <!--image row--> 

					<div class="col-md-4">  
						<div class="form-group text-center" >
							<span class="img-div">
							<div class="text-center img-placeholder"  onClick="triggerClick()">
								<h5>Görseli Güncelle</h5>
							</div>
							<img src="../assets/img/plus.png" onClick="triggerClick()" id="profileDisplay" style="max-width: 50%;">
							</span>
							<input type="file" name="frontImage" onChange="displayImage(this)" id="profileImage" class="form-control" style="display: none;">
							<label>Ön</label>
						</div>
					</div>

					<div class="col-md-4">  
						<div class="form-group text-center" >
							<span class="img-div">
							<div class="text-center img-placeholder"  onClick="triggerClick2()">
								<h5>Görseli Güncelle</h5>
							</div>
							<img src="../assets/img/plus.png" onClick="triggerClick2()" id="profileDisplay2" style="max-width: 50%;">
							</span>
							<input type="file" name="backImage" onChange="displayImage2(this)" id="profileImage2" class="form-control" style="display: none;">
							<label>Arka</label>
						</div>
					</div>

					<div class="col-md-4">  
						<div class="form-group text-center" >
							<span class="img-div">
							<div class="text-center img-placeholder"  onClick="triggerClick3()">
								<h5>Görseli Güncelle</h5>
							</div>
							<img src="../assets/img/plus.png" onClick="triggerClick3()" id="profileDisplay3" style="max-width: 50%;">
							</span>
							<input type="file" name="topImage" onChange="displayImage3(this)" id="profileImage3" class="form-control" style="display: none;">
							<label>Tepe</label>
						</div>
					</div>

				</div><!--end of image row-->
				<div class="row">
					<div class="col-md-4">
						<div class="form-group text-center" >
							<span class="img-div">
							<div class="text-center img-placeholder"  onClick="triggerClick4()">
								<h5>Görseli Güncelle</h5>
							</div>
							<img src="../assets/img/plus.png" onClick="triggerClick4()" id="profileDisplay4" style="max-width: 50%;">
							</span>
							<input type="file" name="rightImage" onChange="displayImage4(this)" id="profileImage4" class="form-control" style="display: none;">
							<label>Sağ</label>
						</div>
					</div>
					<div class="col-md-4">  
						<div class="form-group text-center" >
							<span class="img-div">
							<div class="text-center img-placeholder"  onClick="triggerClick5()">
								<h5>Görseli Güncelle</h5>
							</div>
							<img src="../assets/img/plus.png" onClick="triggerClick5()" id="profileDisplay5" style="max-width: 50%;">
							</span>
							<input type="file" name="leftImage" onChange="displayImage5(this)" id="profileImage5" class="form-control" style="display: none;">
							<label>Sol</label>
						</div>
					</div>
				</div><!--end of image row-->
				<button type="submit" class="btn btn-success" name="addPhotos">Kaydet </button>
			</form>
			<?php } if ($row['wash_start']==1) { ?>

			
			<form action="../netting/function.php" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="userId" value="<?php echo $userId; ?>">
			<button type="submit" class="btn btn-success" name="addWash">Yıkama Ekle </button>
			</form>	
				
			</div>
		</div>
	</header>

	

	
	<?php } include 'footer.php'; ?>