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
					$connection=new mysqli("localhost","Zamachi","asdwclhu","sii");
					
					$cenaIgre=floatval($_POST['pricing']);
					$sifraIgre=$_POST['sifraIgre'];
					
					if($cenaIgre <= $_SESSION['accBalance']){
						
						$sql="
							INSERT INTO library(user_id, game_id, hours_played)
							VALUES ('".$_SESSION['user_id']."','".$sifraIgre."',1000*RAND());
						";
						
						$connection->query($sql);
						
						$sql="
						UPDATE users
						SET account_balance=account_balance-".(number_format($cenaIgre, 2, ".", ""))."
						WHERE user_id=".$_SESSION['user_id']."
						";
						
						$connection->query($sql);
						
						
						$_SESSION['accBalance']=$_SESSION['accBalance']-$cenaIgre;
						$_SESSION['account_balance']=$_SESSION['accBalance']-$cenaIgre;
						
						echo "<div id=\"userCreatedConfirmationSuccess\">";
						
							echo "<div class=\"confirmationIcon\"><i class=\"fas fa-check-circle\"></i></div>";
							echo "<div class=\"\">The game has been successfully added to your library!</div>";
							echo "<div style=\"clear: both;\"></div>";
							echo "<a href=\"library.php\">Proceed to library</a>";
						echo "</div>";
					}
					else{
						
						echo "<div id=\"userCreatedConfirmationFailure\">";
						
							echo "<div class=\"confirmationIcon\"><i class=\"fas fa-exclamation-circle\"></i></div>";
							echo "<div class=\"\">You don't have enough funds on your account.</div>";
							echo "<div style=\"clear: both;\"></div>";
							echo "<a href=\"profile.php\">Visit your profile page to add more funds</a>";
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