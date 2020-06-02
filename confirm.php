<!DOCTYPE html>

<?php

	session_start();
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<title>Confimation page</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	</head>

	<body>
	
		<section id="searchWindow">
			
			<div id="searchWrapper">
				<div style="margin-top: 50px;">
					<div id="zatvori" onclick="zatvori();"><span>x</span></div>
					<div>
						<form action="search.php" method="POST" name="pretraga" novalidate style="position: fixed;left: 25%;top: 50%;width: 50%;">
							<input type="search" required  id="gsearch" name="gsearch" placeholder="Search for...">
						</form>
					</div>
				</div>
			</div>
		</section>
		<header>
			
			<div class="aligner">
			
				<div>
					<div id="logo">
						<img src="img/logo.png" style="height: 100px;width:100px;" alt="Slika ne radi">
					</div>
					<div class="widgets">
						<?php
							
							if(!isset($_SESSION['isLoggedIn'])){
								echo "<a href=\"login.php\" style=\"line-height: 2.5;\">Log in&nbsp;</a>";
							}else{
								echo "<a href=\"logout.php\" style=\"line-height: 2.5;\">Log out&nbsp;</a>";
							
							}
						
						?>
						<i class="fas fa-search" onclick="prikazi();" style="line-height: 2.1;">&nbsp;&nbsp;</i>
						<?php
							if(isset($_SESSION['isLoggedIn'])){
								echo "<a href=\"profile.php\"><div id=\"profile\" style=\"display: block;\"><img style=\"height: 100%; width: 100%;\" src=\"".$_SESSION['avatar']."\" alt=\"?\"></div></a>";
							
							}else{
								echo "<div id=\"profile\" style=\"display: none;\"><img src=\"\" alt=\"?\"></div>";
							}
						
						?>
					</div>
					
				</div>
				<nav>
					<div class="navigacija">
						<ul>
							<li><a href="index.php"><span>Home</span></a></li>
							<li><a href="store.php"><span>Store</span></a></li>
							<li><a href="library.php"><span>Library</span></a></li>
							<li><a href="register.php"><span>Register</span></a></li>
																
						</ul>
					</div>
				</nav>
				
			</div>
		</header>
		
		<section id="teloStrane">
			
			
			<div class="aligner">
				<?php
					define("fajloviProjekat","c:/xampp/htdocs/ProjekatZaDrugiKolokvijum/img/users/"); 
					$connection=new mysqli("localhost","Zamachi","asdwclhu","sii");
					
					$username=$_POST['username'];
					$password=password_hash($_POST['password'], PASSWORD_BCRYPT);
					$country=$_POST['country'];
					$imeFajla=$_FILES['fileToUpload']['name'];
					
					if(isset($_FILES['fileToUpload'])){
						
						if(is_uploaded_file($_FILES['fileToUpload']['tmp_name'])){
							
							if(!($_FILES['fileToUpload']['type']!='image/png' || $_FILES['fileToUpload']['type']!='image/jpg' || $_FILES['fileToUpload']['type']!='image/jpeg')){
								echo "<p style=\"color: red !important;\">Pogresan format fajla!</p>";
								
								$sql="
									INSERT INTO users(username, password, country)
									VALUES
									('$username','$password','$country')		
									";
								
								
							}else{
							
								if(file_exists(fajloviProjekat . $_FILES['fileToUpload']['name'])){
									
									$osnovnoIme=basename(fajloviProjekat . $_FILES['fileToUpload']['name'], ".png");
									
									$ekstenzijaFajla=pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);
									
									$counter=0;
									$noviNaziv="";
									do{
										$counter++;
										$noviNaziv="".$osnovnoIme."(".strval($counter).")".".".$ekstenzijaFajla;
									
									}while(file_exists(fajloviProjekat . strval($noviNaziv)));
									
									$_FILES['fileToUpload']['name']=$noviNaziv;
									
									
								}
								
								$image=move_uploaded_file($_FILES['fileToUpload']['tmp_name'], fajloviProjekat . $_FILES['fileToUpload']['name']);
								
								if($image==1){ 
								
									$sql="
									INSERT INTO users(username, password, country, avatar)
									VALUES
									('$username','$password','$country', '".$connection->real_escape_string('img/users/' . $_FILES['fileToUpload']['name'])."')		
									";
								}
								else {
									echo "<p>Fajl nije uspesno uploadovan</p>";
									
									$sql="
										INSERT INTO users(username, password, country)
										VALUES
										('$username','$password','$country')		
										";
									
								}
							}
							
						}else{
							
							$sql="
							INSERT INTO users(username, password, country)
							VALUES
							('$username','$password','$country')		
							";
							
						}
						
					}else{
						$sql="
						INSERT INTO users(username, password, country)
						VALUES
						('$username','$password','$country')		
						";
					}
					
					if($connection->query($sql)){
						echo "<div id=\"userCreatedConfirmationSuccess\">";
						
							echo "<div class=\"confirmationIcon\"><i class=\"fas fa-check-circle\"></i></div>";
							echo "<div class=\"\">User was successfully created!</div>";
							echo "<div style=\"clear: both;\"></div>";
							echo "<a href=\"login.php\">Proceed to login</a>";
						echo "</div>";
					}
					else{
						
						echo "<div id=\"userCreatedConfirmationFailure\">";
						
							echo "<div class=\"confirmationIcon\"><i class=\"fas fa-exclamation-circle\"></i></div>";
							echo "<div class=\"\">An error occured whilst trying to create a user: " . $connection->error . "</div>";
							echo "<div style=\"clear: both;\"></div>";
							echo "<a href=\"register.php\">Try registering again?</a>";
						echo "</div>";
						
					}
					
					$connection->close();
				?>
			</div>
			
		</section>
		
		<footer>
			<div class="aligner">
				<div id="logo">
						<img src="img/logo.png" style="height: 100px;width:100px;" alt="Slika ne radi">
				</div>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua lacus vel facilisis.</p>
				<hr>
				<br>
				<nav style="background: none;">
					<div class="navigacija">
						<ul style="display: block; font-size: 16pt;">
							<li><a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f ikonice"></i></a></li>
							<li><a href="https://twitter.com/" target="_blank"><i class="fab fa-twitter ikonice"></i></a></li>
							<li><a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram ikonice"></i></a></li>										
						</ul>
					</div>
				</nav>
				<br><hr><br>
				<div id="copyright">
					<p>Copyright ©2020 All rights reserved | Made by Stefan Dimitrijević</p>
					<ul>
						<li><a href="about.php">About us</a></li>
						<li><a href="contact.php">Contact us</a></li>
						
					</ul>
				</div>
			</div>
		</footer>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="js/javascript.js"></script>
	</body>
</html>