<?php
	session_start();

	if(!array_key_exists('isLoggedIn', $_SESSION)){
		
		if(!isset($_SESSION['isLoggedIn'])){
			
			header("Location: login.php");
			exit();
		}
	}
	$connection=new mysqli('localhost', 'Zamachi', 'asdwclhu', 'sii') or die("Neuspesno povezivanje na bazu");
	
	$sql="
		SELECT games.game_id, games.title, games.price, games.image, games.file, games.description 
		FROM games LEFT JOIN library USING(game_id) INNER JOIN games_tags ON games_tags.game_id = games.game_id INNER JOIN tags ON tags.tag_id = games_tags.tag_id 
		WHERE 
			(library.user_id IS NULL OR library.game_id NOT IN(SELECT library.game_id FROM 
			`users` INNER JOIN library ON `users`.user_id = library.user_id INNER JOIN games ON library.game_id = games.game_id
		WHERE 
			library.user_id=".$_SESSION['user_id']." )) ".((isset($_POST['filter'])) ? ("AND UPPER(tags.tag_name) = UPPER(\"" . $_POST['filter'] . "\")"):"")."
		GROUP BY
			title
		ORDER BY ".((isset($_POST['sortiraj'])) ? $_POST['sortiraj']:"library.game_id ASC")."";
			
		
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<title>Store</title>
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
							<li><a class="active" href="store.php"><span>Store</span></a></li>
							<li><a href="library.php"><span>Library</span></a></li>
							<li><a href="register.php"><span>Register</span></a></li>
																		
						</ul>
					</div>
				</nav>
				
			</div>
		</header>
		
		<section id="teloStrane">
			
			<div id="filtracija">
				
				<form method="POST" id="filteri" name="filteri" action="store.php">
					
					<p>Filters</p>
					<br><hr><br>
					<?php
					
						$sqlFilterTag="
						SELECT tag_name
						FROM tags
						ORDER BY tag_name ASC";
						
						$rezultatFiltera=$connection->query($sqlFilterTag);
						
						while($tagovi=$rezultatFiltera->fetch_assoc()){
							
							echo "<input type=\"radio\" value=\"".$tagovi['tag_name']."\" name=\"filter\">";
							echo "<label for=\"".$tagovi['tag_name']."\"> ".$tagovi['tag_name']."</label><br>";
							
						}
						
					?>
					<br><hr><br>
					<p>Sort</p>
					<br><hr><br>
					<input type="radio" id="titleASC" value="title ASC" name="sortiraj"> <label for="titleASC"> Title ascending</label><br>
					<input type="radio" id="titleDESC" value="title DESC" name="sortiraj"> <label for="titleDESC"> Title descending</label><br>
					<input type="radio" id="priceASC" value="price ASC" name="sortiraj"> <label for="priceASC"> Price ascending</label><br>
					<input type="radio" id="priceDESC" value="price DESC" name="sortiraj"> <label for="priceDESC"> Price descending</label><br>
					
					<input type="submit" style="display: block; margin: 0px auto;" value="Apply">
					
				</form>
				
			</div>
			
			<div class="aligner">
				<div id="pretraga">
				<?php
						
						$rezultat=$connection->query($sql) or die("Doslo je do greske pri selektu");
						
						while($red=$rezultat->fetch_assoc()){
								
								
							echo "<form method=\"POST\" name=\"".$red['title']."\" action=\"process_order.php\">";
								echo "<div class=\"gameRow\">";
									
										echo "<div class=\"gameImage\"><a href=".$red['file']."><img src=".$red['image']."></a></div>";
									
									
									echo "<div class=\"gameInfo\">";
										echo "<a href=".$red['file'].">";
											echo "<h3 class=\"gameTitle\">".$red['title']."</h3>";
										echo "</a>";
										
										echo "<br><hr><br>";
										
										echo "<div class=\"gameDescription\">";
											
											echo "<p>".$red['description']."</p>";
											
										echo "</div>";
										
										echo "<div class=\"gamePricing\">";
											echo "<div>";
												echo "<div class=\"pricing\">Price: <input type=\"text\" name=\"pricing\" readonly value=\"".$red['price']."\">$</div>";
												
												$sqlTags="SELECT tag_name 
												FROM
													games INNER JOIN games_tags ON games.game_id=games_tags.game_id INNER JOIN tags ON games_tags.tag_id=tags.tag_id
												WHERE
													games.game_id=".$red['game_id']."";
												
												$tagovi=$connection->query($sqlTags);
									
									
										echo "<div class=\"tagovi\">Game tags: &nbsp;";
										while($tag=$tagovi->fetch_assoc()){
											echo "<span class=\"gameTag\">".$tag['tag_name']."</span>";
										}
										echo "</div>";
													
													
												echo "</div>";
												
												$sqlZaUserId="
													SELECT library.user_id
													FROM 
														library INNER JOIN games ON library.game_id = games.game_id
													WHERE
														library.user_id = ".$_SESSION['user_id']." AND library.game_id = ".$red['game_id']."
												";
												
												if($connection->query($sqlZaUserId)->num_rows>0){
													
													echo "<br>This game is already in your library<br>";
													
												}else{
													
													if($red['price']>0){
														echo "<input type=\"text\" style=\"display: none;\" name=\"sifraIgre\" readonly value=\"".$red['game_id']."\"><br>";
														echo "<input class=\"kupi\" type=\"submit\" value=\"Buy now!\"><br>";
														
													}else{
														echo "<input type=\"text\" style=\"display: none;\" name=\"sifraIgre\" readonly value=\"".$red['game_id']."\"><br>";
														echo "<input class=\"kupi\" type=\"submit\" value=\"Add game to your library!\"><br>";
														
													}
													
												}
												
											echo "</div>";
											
										echo "</div>";
									
								echo "</div>";
							echo "</form>";
						}
						
						$connection->close();
					?>
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
		<script src="js/javascript.js"></script>
	</body>
</html>