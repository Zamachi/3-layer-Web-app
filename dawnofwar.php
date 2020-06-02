<!DOCTYPE html>
<?php

	$connection=new mysqli('localhost', 'Zamachi', 'asdwclhu', 'sii');
	$fileName = basename(__FILE__); 
	
	$sql="
		SELECT * FROM games WHERE file LIKE '%".$fileName."%'
	";
	
	$rezultat=$connection->query($sql)->fetch_assoc();
	
	session_start();	
	
?>
<html lang="en">
	<head>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<title>Homepage</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
				
				<div id="gameWrapper">
					
					<?php
						echo "<h3 style=\"text-align: center;\">".$rezultat['title']."</h3>";
					?>
					
					<div class="slajder">
						<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
								<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
								<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
							</ol>
							<div class="carousel-inner">
								<div class="carousel-item active">
								<img class="d-block w-100" src="https://steamcdn-a.akamaihd.net/steam/apps/4570/ss_fc65017b6edb65844990bcb2c2a83058db5a1ec3.600x338.jpg?t=1576607781" alt="First slide">
								</div>
								<div class="carousel-item">
								<img class="d-block w-100" src="https://steamcdn-a.akamaihd.net/steam/apps/4570/ss_84251dedf0d37557863cc98950901c4a47549da5.600x338.jpg?t=1576607781" alt="Second slide">
								</div>
								<div class="carousel-item">
								<img class="d-block w-100" src="https://steamcdn-a.akamaihd.net/steam/apps/4570/ss_a26fba878b09aecb305712220e53094d85f818e0.600x338.jpg?t=1576607781" alt="Third slide">
								</div>
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
				
					<?php
						
						echo "<form method=\"POST\" action=\"process_order.php\">";
							echo "<div class=\"opisIgre\">";
								
								echo "<div style=\"height: 300px; float: left;\"><img src=".$rezultat['image']." alt=\"Slika ne radi\"></div>";
								echo "<div class=\"deskripshn\"><p>".$rezultat['description']."</p></div>";
								
								echo "<div class=\"podaciOIgri\">";
									
									echo "<div>Date published: ".$rezultat['publish_date']."</div><br>";
									echo "<div class=\"pricing\">Price: <input type=\"text\" name=\"pricing\" readonly value=\"".$rezultat['price']."\">$</div><br>";
									
									
									$sqlTags="SELECT tag_name 
									FROM
										games INNER JOIN games_tags ON games.game_id=games_tags.game_id INNER JOIN tags ON games_tags.tag_id=tags.tag_id
									WHERE
										games.game_id=".$rezultat['game_id']."";
									
									$tagovi=$connection->query($sqlTags);
									
									
									echo "<div>Game tags: &nbsp;";
									while($tag=$tagovi->fetch_assoc()){
										echo "<span class=\"gameTag\">".$tag['tag_name']."</span>";
									}
									echo "</div>";
									
									$sqlDevelopers="
										SELECT developer_name 
										FROM
											games INNER JOIN developed_by ON games.game_id = developed_by.game_id INNER JOIN developers ON developed_by.developer_id = developers.developer_id
										WHERE 
											games.game_id=".$rezultat['game_id'].";
									";
									$developeri=$connection->query($sqlDevelopers);
									
									echo "<div>Developed by: &nbsp;";
									while($developer=$developeri->fetch_assoc()){
										echo "<span class=\"gameDev\">".$developer['developer_name']."</span>";
									}
									echo "</div>";
									
									$sqlZaUserId="
										SELECT library.user_id
										FROM 
											library INNER JOIN games ON library.game_id = games.game_id
										WHERE
											library.user_id = ".$_SESSION['user_id']." AND library.game_id = ".$rezultat['game_id']."
									";
									
									if($connection->query($sqlZaUserId)->num_rows>0){
										
										echo "<br>This game is already in your library<br>";
										
									}else{
										
										if($rezultat['price']>0){
											echo "<input type=\"text\" style=\"display: none;\" name=\"sifraIgre\" readonly value=\"".$rezultat['game_id']."\"><br>";
											echo "<input class=\"kupi\" type=\"submit\" value=\"Buy now!\"><br>";
											
										}else{
											echo "<input type=\"text\" style=\"display: none;\" name=\"sifraIgre\" readonly value=\"".$rezultat['game_id']."\"><br>";
											echo "<input class=\"kupi\" type=\"submit\" value=\"Add game to your library!\"><br>";
											
										}
										
									}
									
								echo "</div>";
								
							echo "</div>";
						echo "</form>";
						$connection->close();
					?>
					
					<div style="clear: both;"> </div>
				</div>
			</div>
			
		</section>
		
		<footer>
			<div class="aligner">
				<div id="logo">
						<img src="img/logo.png" style="height: 100px;width:100px;" alt="Slika ne radi">
				</div>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua lacus vel facilisis.</p>
				<hr style="color: white !important; border: 1px solid white;">
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
				<br><hr style="color: white !important; border: 1px solid white;"><br>
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