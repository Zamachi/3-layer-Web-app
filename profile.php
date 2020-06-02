<!DOCTYPE html>
<?php

	$connection=new mysqli("localhost","Zamachi","asdwclhu","sii");
	session_start();

	$file=fopen("user_files/".$_COOKIE['fileName']."","w+");
	
	fwrite($file, "<p>Username</p>\n");
	fwrite($file, "<p>".$_SESSION['username']."</p><br>\n");
	fwrite($file, "<p>Account created at:</p>\n");
	fwrite($file, "<p>".$_SESSION['created_at']."</p><br>\n");
	fwrite($file, "<p>Country of origin:</p>\n");
	fwrite($file, "<p>".$_SESSION['country']."</p><br>\n");
	fwrite($file, "<p>Account balance:</p>\n");
	fwrite($file, "<p>".$_SESSION['accBalance']."</p><br>\n");
	
	fclose($file);

?>
<html lang="en">
	<head>
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<title>Homepage</title>
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
							<input type="search"  required id="gsearch" name="gsearch" placeholder="Search for...">
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
				
				<div id="profilePage">
					
					<div id="profilePageAligner">
						<?php
							
							$results=$connection->query("SELECT * FROM users WHERE users.user_id = ".$_SESSION['user_id']."")->fetch_assoc();
						
							echo "<form method=\"POST\" enctype=\"multipart/form-data\" name=\"azurirajPodatke\" id=\"azurirajPodatke\" action=\"update_data.php\">";
								
								echo "<div id=\"formTitle\">	
										<label for=\"azurirajPodatke\" style=\"color: black; text-align: center;\">You can update your data on this page</label>
									</div><br><br>";
								
								echo "<div class=\"formRow\">";
									
									echo "<div id=\"promeniSliku\">";
										
										echo "<div style=\"height: 150px; width: 150px;\"><img style=\"height: 100%; width: 100%;\" src=\"".$_SESSION['avatar']."\"></div>";
										
										echo "<div><input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\" form=\"azurirajPodatke\" accept=\".jpeg,.jpg,.png\"></div>";
										
									echo "</div>";
									
								echo "</div>";
								
								echo "<div class=\"formRow\">";
									

									echo "<label for=\"azurirajPodatke\" style=\"color: black; text-align: center;\">Your new password: </label><div><input type=\"password\" size=\"30\" placeholder=\"Enter your new password...\" maxlength=\"16\" name=\"newPassword1\" id=\"newPassword1\" form=\"azurirajPodatke\"></div>";
									echo "<label for=\"azurirajPodatke\" style=\"color: black; text-align: center;\">Confirm new password: </label><div><input type=\"password\" size=\"30\" placeholder=\"Confirm your new password...\" maxlength=\"16\" name=\"newPassword2\" id=\"newPassword2\" form=\"azurirajPodatke\"></div>";
									
									
								echo "</div>";
								
								echo "<div class=\"formRow\">";
									
									echo "<label for=\"azurirajPodatke\" style=\"color: black; text-align: center;\">Add currency to your account: </label><div><input type=\"number\" step=\"0.01\" min=\"0\" name=\"uplata\" form=\"azurirajPodatke\" id=\"uplata\"></div>";
									
								echo "</div>";
								
								echo "<div class=\"formRow\">";
								
									echo "<input type=\"submit\" id=\"dugmeZaSlanje\" name=\"dugmeZaSlanje\" value=\"Update your info\" form=\"azurirajPodatke\">";
								
								echo "</div>";
								
								echo "<div class=\"formRow\" id=\"poljeGresaka\">";
								echo "</div>";
								
								
							echo "</form>";
						?>
						<div id="podaci" style="text-align: center;">
							<?php
								
								if(file_exists("user_files/".$_COOKIE['fileName']."")){
									
									$file=fopen("user_files/".$_COOKIE['fileName']."","r");
									
									while(!feof($file)){
										
										echo fgets($file);
										
									}
									
									fclose($file);
								}
								
							?>
						
						</div>
						<a href="disable.php" style="width: 100%; text-align: center; display: block; clear: both;">Disable account</a>
					</div>
				</div>
				
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
		<script src="js/javascriptProfile.js"> //var trenutnaSifra = <?php echo strval($_SESSION['password'])?>;</script>
	</body>
</html>