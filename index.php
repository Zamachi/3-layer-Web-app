<!DOCTYPE html>
<?php
	session_start();
	
	$connection=new mysqli("localhost", "Zamachi", "asdwclhu", "sii");
	
	$sqlFirst="
		SELECT *
		FROM
			games
		ORDER BY
			games.publish_date DESC
		LIMIT 5;
	";
	
	$resultFirst = $connection->query($sqlFirst);
	
	$sqlSecond="
		SELECT 
			games.game_id, games.title, games.publish_date, games.image, games.file, games.description, SUM(hours_played) AS suma_vremena
		FROM
			library INNER JOIN games ON library.game_id = games.game_id
		GROUP BY
			library.game_id
		ORDER BY
			suma_vremena DESC
		LIMIT 5;
	";
	
	$resultSecond = $connection->query($sqlSecond);
	
	
?>
<html lang="en">
	<head>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
							<li><a class="active" href="index.php"><span>Home</span></a></li>
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
				
		
						<h3 style="text-align: center;">Latest games:</h3>
						<div class="slajder">
						<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
								<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
								<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
								<li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
								<li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
							</ol>
							<div class="carousel-inner">
							
								<?php
									$counter=1;
									while($redovi=$resultSecond->fetch_assoc()){
									
										if($counter==1){
											echo "<div class=\"carousel-item active\">";
											$counter++;
										}
										else{
											echo "<div class=\"carousel-item\">";
										}
										
										if(array_key_exists('isLoggedIn', $_SESSION)){
		
											if(isset($_SESSION['isLoggedIn'])){
												
												echo "<a href=\"".$redovi['file']."\"> <img class=\"d-block w-100\" src=\"".$redovi['image']."\" alt=\"First slide\"> </a>";
											}
										}else{
											
											echo "<a href=\"login.php\"> <img class=\"d-block w-100\" src=\"".$redovi['image']."\" alt=\"First slide\"> </a>";
											
										}
										
										
										echo "</div>";
									
									}
									
								?>
							
							</div>
							<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
						</div>
						</div>
						<br>
						<h3 style="text-align: center;">Most popular games:</h3>
						<div class="slajder">
						<div id="carouselExampleIndicators1" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								<li data-target="#carouselExampleIndicators1" data-slide-to="0" class="active"></li>
								<li data-target="#carouselExampleIndicators1" data-slide-to="1"></li>
								<li data-target="#carouselExampleIndicators1" data-slide-to="2"></li>
								<li data-target="#carouselExampleIndicators1" data-slide-to="3"></li>
								<li data-target="#carouselExampleIndicators1" data-slide-to="4"></li>
							</ol>
							<div class="carousel-inner">
							
								<?php
									$counter=1;
									while($red=$resultFirst->fetch_assoc()){
									
										if($counter==1){
											echo "<div class=\"carousel-item active\">";
											$counter++;
										}
										else{
											echo "<div class=\"carousel-item\">";
										}
										
										
										if(array_key_exists('username', $_SESSION)){
		
											if(isset($_SESSION['username'])){
												
												echo "<a href=\"".$red['file']."\"> <img class=\"d-block w-100\" src=\"".$red['image']."\" alt=\"First slide\"> </a>";
											}
										}else{
											
											echo "<a href=\"login.php\"> <img class=\"d-block w-100\" src=\"".$red['image']."\" alt=\"First slide\"> </a>";
											
										}
										
										echo "</div>";
									
									}
									
								?>
								
							</div>
							<a class="carousel-control-prev" href="#carouselExampleIndicators1" role="button" data-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="carousel-control-next" href="#carouselExampleIndicators1" role="button" data-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
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
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="js/javascript.js"></script>
	</body>
</html>