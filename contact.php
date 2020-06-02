
<!DOCTYPE html>

<?php
	session_start();
	
	$to="stefan.dimitrijevic.18@singimail.rs";
	$subject=( array_key_exists('subject', $_POST) ? $_POST['subject']:NULL);
	$emailContent=(array_key_exists('description', $_POST) ? $_POST['description']:NULL);
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: <".(array_key_exists('email', $_POST) ? $_POST['email']:"").">" . "\r\n";
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<title>Contact us</title>
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
							<input type="search" required id="gsearch" name="gsearch" placeholder="Search for...">
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
				<p style="text-align: center;">PAZNJA! Ova forma nece funkcionisati ukoliko ne postoji SMTP server na lokalnoj masini!</p>
				<form id="kontaktForma" name="registracija" method="POST" action="contact.php">
						
						<div id="formTitle">	
							<label for="kontaktForma" style="color: black; text-align: center;">Contact us</label>
						</div>
					
						<div class="formRow">
							<input required type="text" size="30" placeholder="Subject" id="subject" name="subject" form="kontaktForma"> 
						</div>
						<div class="formRow">
							<input required type="email" size="30" placeholder="Enter your email..." maxlength="30" name="email" id="email" form="kontaktForma"> 
						</div>
						<div class="formRow">
							<textarea placeholder="Your message goes here..." name="description" id="description" form="kontaktForma"></textarea>
						</div>
						
						<div class="formRow">
							<input  type="submit" disabled value="Send your email..." id="dugmeZaSlanje" name="dugmeZaSlanje" form="kontaktForma">
						</div>
						
				</form>
				<?php
					if(((($subject) !== NULL) && ($emailContent !== NULL) && ( $_POST['email']) !== NULL)){
						if(mail($to, $subject, $emailContent, $headers)){//prijavice gresku ukoliko nema SMTP servera na lokalnoj masini!
							
						echo "<div id=\"userCreatedConfirmationSuccess\">";
							
								echo "<div class=\"confirmationIcon\"><i class=\"fas fa-check-circle\"></i></div>";
								echo "<div class=\"\">Email was successfully sent!</div>";
								echo "<div style=\"clear: both;\"></div>";
								
							echo "</div>";
						}
						else{
							
							echo "<div id=\"userCreatedConfirmationFailure\">";
							
								echo "<div class=\"confirmationIcon\"><i class=\"fas fa-exclamation-circle\"></i></div>";
								echo "<div class=\"\">Email wasn't sent due to an error!</div>";
								echo "<div style=\"clear: both;\"></div>";
								
							echo "</div>";
						}
					}
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