<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style/style.css">
		<title>Homepage</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	</head>

	<body>
		
		<?php
			
			//koristiti prvo ovaj kod u slucaju da korisnici ovog koda nemaju adekvatnog korisnika i ime baze podataka na svom lokalnom racunaru
			//$connection=new mysqli("localhost","root","");
			//$connection->query("CREATE DATABASE IF NOT EXIST 'sii;");
			//$connection->query("CREATE USER 'Zamachi'@'localhost' IDENTIFIED BY 'asdwclhu'");
			//$connection->query("GRANT ALL ON 'sii'.* TO 'Zamachi'@'localhost' IDENTIFIED BY 'asdwclhu'");
			//$connection->close();
			
			$files = glob('img/users/*'); // dohvati sve slike korisnika
				foreach($files as $file){ // iteriraj kroz fajlove
				if(is_file($file))
					unlink($file); // obrisi fajl(ove)
				}
			
			$files = glob('user_files/*'); // dohvati sve slike korisnika
				foreach($files as $file){ // iteriraj kroz fajlove
				if(is_file($file))
					unlink($file); // obrisi fajl(ove)
				}
			
			echo "<div id=\"loader\">";
				echo "<div>";
				$servername="localhost";
				$username="Zamachi";
				$password="asdwclhu";
				$database="sii";
				
				$connection=new mysqli($servername, $username, $password, $database);
				
				if($connection->connect_error){
					die("Error with establishing database connection: ". $connection->connect_error);
				}else{
					print "Uspesno ste se konektovali na bazu $database , korisnice $username <br>";
				}
				
				echo "Brisanje tabela...<br>";
				$connection->query("SET FOREIGN_KEY_CHECKS = 0");
				$connection->query("DROP TABLE IF EXISTS users");
				$connection->query("DROP TABLE IF EXISTS library");
				$connection->query("DROP TABLE IF EXISTS games");
				$connection->query("DROP TABLE IF EXISTS developed_by");
				$connection->query("DROP TABLE IF EXISTS developers");
				$connection->query("DROP TABLE IF EXISTS games_tags");
				$connection->query("DROP TABLE IF EXISTS tags");
				$connection->query("SET FOREIGN_KEY_CHECKS = 1");
				
				/*users table*/
				$sql="
					CREATE TABLE users(
					user_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
					username varchar(32) NOT NULL,
					password varchar(64) NOT NULL,
					country varchar(64) NOT NULL,
					created_at timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
					account_balance decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.0,
					avatar varchar(512),
					
					UNIQUE INDEX uq_users_username(username) USING BTREE
					)
				";
				
				
				if($connection->query($sql)){
					echo "Tabela users je uspesno kreirana<br>";
				}else{
					echo "Tabela users ne moze da se kreira: " . $connection->error . "<br>";
				}
				
				$sql="
					INSERT INTO users(username, password, country, avatar)
					VALUES
					('Mikeyyyy', '".password_hash('Muddysoda245', PASSWORD_BCRYPT)."','United Kingdom', 'https:\/\/steamcdn-a.akamaihd.net\/steamcommunity\/public\/images\/avatars\/1b\/1b82bca939309ae692dd697df93b3b1281a7dc63_full.jpg'),
					('Steph999',  '".password_hash('jumPybell475', PASSWORD_BCRYPT)."','Serbia', 'https:\/\/steamcdn-a.akamaihd.net\/steamcommunity\/public\/images\/avatars\/00\/006b07a8c10b3b86ac8f4850f4dfd48bf251295c_full.jpg'),
					('StivENDy', '".password_hash('roundfawN789', PASSWORD_BCRYPT)."','Romania', 'https:\/\/steamcdn-a.akamaihd.net\/steamcommunity\/public\/images\/avatars\/00\/00a9394dbe2341bc73d2b198894e246748e93f75_full.jpg'),
					('LinERGEb', '".password_hash('darkisland667', PASSWORD_BCRYPT)."','Bosnia and Herzegovina', 'https:\/\/steamcdn-a.akamaihd.net\/steamcommunity\/public\/images\/avatars\/4d\/4dc5a3517abffa33b060ad3aa5dbbcde80d016a4_full.jpg'),
					('EsTRATei', '".password_hash('Freeedge1999', PASSWORD_BCRYPT)."','Albania', 'https:\/\/steamcdn-a.akamaihd.net\/steamcommunity\/public\/images\/avatars\/c6\/c6867005599b89265633356c9634998b7ac7414e_full.jpg'),
					('IveliSPH', '".password_hash('Ivoryfood945', PASSWORD_BCRYPT)."','Hungary', 'https:\/\/steamcdn-a.akamaihd.net\/steamcommunity\/public\/images\/avatars\/7f\/7f95e593302f4101ec1f72845df62c85b48d0a58_full.jpg'),
					('ITUPTioN', '".password_hash('Mushyfruit58', PASSWORD_BCRYPT)."','Montenegro', 'https:\/\/steamcdn-a.akamaihd.net\/steamcommunity\/public\/images\/avatars\/67\/6737515f5e4a806796cd75677a34c93668fbb5e9_full.jpg'),
					('IZomONso', '".password_hash('Wildmint1492', PASSWORD_BCRYPT)."','Macedonia', 'https:\/\/steamcdn-a.akamaihd.net\/steamcommunity\/public\/images\/avatars\/00\/00cf70a8049a71ea7cae83295f99c88a7b00599b_full.jpg'),
					('DicaitYl', '".password_hash('Weirdivory22', PASSWORD_BCRYPT)."','Bulgaria', 'https:\/\/steamcdn-a.akamaihd.net\/steamcommunity\/public\/images\/avatars\/71\/71d93eb0a8032c081294f8f0f6eac13d12a43131_full.jpg'),
					('ONEwarkl', '".password_hash('Windywater48', PASSWORD_BCRYPT)."','Slovenia', 'https:\/\/steamcdn-a.akamaihd.net\/steamcommunity\/public\/images\/avatars\/https:\/\/steamcdn-a.akamaihd.net\/steamcommunity\/public\/images\/avatars\/d1\/d19fa6b89538f214763e156500f09d44114cd0bb_full.jpg'),
					('HaFTEDiC', '".password_hash('Bumpyjelly90', PASSWORD_BCRYPT)."','United States of America', 'https:\/\/steamcdn-a.akamaihd.net\/steamcommunity\/public\/images\/avatars\/3d\/3d2f1745411fe876d8ceee54df31ac20ef7ffa3e_full.jpg') 
					
				";
				
				if($connection->query($sql)){
					echo "Tabela users je uspesno inicijalizovana...<br>";
				}else{
					echo "Tabela users je neuspesno inicijalizovana: " . $connection->error . "<br>";
				}
				/*users table*/
				
				/*tags table*/
				$sql="
					CREATE TABLE tags(
					tag_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
					tag_name varchar(45) NOT NULL,
					UNIQUE INDEX uq_tags_tag_name(tag_name) 
					)
				";
				
				
				if($connection->query($sql)){
					echo "Tabela tags je uspesno kreirana<br>";
				}else{
					echo "Tabela tags ne moze da se kreira: " . $connection->error . "<br>";
				}
				
				$sql="
					INSERT INTO tags(tag_name)
					VALUES
					('Fantasy'),
					('RPG'),
					('Singleplayer'),
					('Multiplayer'),
					('FPS'),
					('Horror'),
					('2D'),
					('Medieval'),
					('Indie'),
					('Roguelike'),
					('RTS'),
					('MMO'),
					('Sandbox')
				";
				
				if($connection->query($sql)){
					echo "Tabela tags je uspesno inicijalizovana...<br>";
				}else{
					echo "Tabela tags je neuspesno inicijalizovana: " . $connection->error . "<br>";
				}
				/*tags table*/
				
				/*games table*/
				$sql="
					CREATE TABLE games(
					game_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
					title varchar(45) NOT NULL,
					publish_date date NOT NULL,
					price decimal(10,2) UNSIGNED NOT NULL,
					image varchar(512),
					file varchar(512),
					description text,
					UNIQUE INDEX uq_games_title(title)
					)
				";
				
				
				if($connection->query($sql)){
					echo "Tabela games je uspesno kreirana<br>";
				}else{
					echo "Tabela games ne moze da se kreira: " . $connection->error . "<br>";
				}
				
				$sql="
					INSERT INTO games(title, publish_date, price, image, file, description)
					VALUES
					('The Elder Scrolls V Skyrim','2011-11-11', 59.99, 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/img\/games\/Skyrim.png', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/skyrim.php', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Fallout 76','2018-10-23', 39.99, 'https:\/\/steamcdn-a.akamaihd.net\/steam\/apps\/1151340\/header.jpg?t=1588798263', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/fallout76.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Doom Eternal','2020-03-20', 44.99, 'https:\/\/steamcdn-a.akamaihd.net\/steam\/apps\/782330\/header.jpg?t=1588895742', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/doometernal.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Elder Scrolls Online','2014-02-28', 49.99, 'https:\/\/steamcdn-a.akamaihd.net\/steam\/apps\/306130\/header.jpg?t=1586472356', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/eso.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('World of Warcraft','2004-11-20', 49.99, 'https:\/\/upload.wikimedia.org\/wikipedia\/sr\/thumb\/9\/91\/WoW_Box_Art1.jpg\/220px-WoW_Box_Art1.jpg', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/wow.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Overwatch','2016-12-01', 59.99, 'https:\/\/img-a.udemycdn.com\/course\/750x422\/1712892_fcab.jpg', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/overwatch.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Diablo III', '2012-05-24', 29.99, 'https:\/\/upload.wikimedia.org\/wikipedia\/sr\/thumb\/5\/53\/Diablo_III.png\/220px-Diablo_III.png', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/diablo3.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('StarCraft II: Wings of Liberty', '2010-12-24', 29.99, 'https:\/\/www.benchmark.rs\/assets\/img\/article\/large\/3116f3e3c7894eafe2183650340a1198.jpg', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/starcraft2.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Warcraft III', '2002-01-21', 22.99, 'https:\/\/upload.wikimedia.org\/wikipedia\/en\/6\/66\/WarcraftIII.jpg', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/warcraft3.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Lineage II', '2003-03-01', 0.0, 'https:\/\/mmoculture.com\/wp-content\/uploads\/2019\/11\/Lineage-II-image.png', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/lineage2.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Blade & Soul', '2012-08-15', 0.0, 'https:\/\/mos.pcgamebenchmark.com\/img\/game\/blade-soul\/blade-soul-system-requirements.jpg', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/bladeandsoul.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Guild Wars 2', '2012-12-31', 15.0, 'https:\/\/cdna.artstation.com\/p\/assets\/images\/images\/008\/245\/330\/large\/luke-dowding-gw2-pof-s4e01-movie-cover-web.jpg?1511448046', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/guildwars2.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Dota 2', '2013-06-30', 0.0, 'https:\/\/www.benchmark.rs\/assets\/img\/news\/big_thumb\/f5a5527f3ea2c2b26f51dffd64f8ec09.jpg', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/dota2.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Half-Life 2', '2004-02-24', 30.0, 'https:\/\/steamcdn-a.akamaihd.net\/half-life.com\/images\/halflife2\/halflife2_coverart.jpg', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/halflife2.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Portal 2', '2004-02-24', 30.0, 'https:\/\/steamcdn-a.akamaihd.net\/steam\/apps\/620\/header.jpg?t=1587582232', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/portal2.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Counter-Strike: Global Offensive', '2012-02-24', 12.0, 'https:\/\/cdn-cf.gamivo.com\/image_cover.jpg?f=26073&n=47263531930005853.jpg&h=8104eb1555ac18f00b0f464b3a565cae', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/csgo.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Fortnite', '2018-12-29', 0.0, 'https:\/\/play.co.rs\/wp-content\/uploads\/2020\/04\/fortnite-chapter-2-season-2-extended.jpg', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/fortnite.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Cyberpunk 2077', '2020-12-29', 59.99, 'https:\/\/play.co.rs\/wp-content\/uploads\/2019\/11\/keanu-reeves-cyberpunk-2077-johnny-silverhand-740x415.jpg', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/cyberpunk.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Witcher 3: Wild Hunt', '2015-09-12', 59.99, 'https:\/\/upload.wikimedia.org\/wikipedia\/sr\/thumb\/0\/0c\/Witcher_3_cover_art.jpg/220px-Witcher_3_cover_art.jpg', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/witcher3.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Warhammer 40k: Dawn of War', '2004-09-24', 24.99, 'https:\/\/upload.wikimedia.org\/wikipedia\/en\/thumb\/9\/9f\/Dawn_of_War_box_art.jpg/220px-Dawn_of_War_box_art.jpg', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/dawnofwar.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('ArcheAge', '2013-08-01', 0.0, 'https:\/\/mmoexaminer.com\/wp-content\/uploads\/2016\/11\/archeage.jpg', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/archeage.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Grand Theft Auto V', '2013-08-01', 59.99, 'https:\/\/images.g2a.com\/newlayout\/323x433\/1x1x0\/387a113709aa\/59e5efeb5bafe304c4426c47', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/gta5.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Red Dead Redemption 2', '2018-02-01', 59.99, 'https:\/\/lh3.googleusercontent.com\/HCUkD69MAHEOj84Yi7Kb5vxHpCePTsmQI4g9vYuVPUo-87cWE6ZZIk0tiyYzaiS9zaAFMTXRNYJaaRczRN-yQYw', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/rdr2.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('L.A Noire', '2011-02-01', 39.99, 'https:\/\/images.g2a.com\/newlayout\/323x433\/1x1x0\/3f27caac79f1\/59111993ae653ac90c267e63', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/lanoire.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Tom Clancy\'s Rainbow Six Siege', '2015-04-07', 49.99, 'https:\/\/steamuserimages-a.akamaihd.net\/ugc\/960852464597139563\/9C68B626D0D28C71EE4F34D371F4BD406BAE03B8\/', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/rainbowsixsiege.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Assassin\'s Creed Odyssey', '2018-09-07', 69.99, 'https:\/\/play.co.rs\/wp-content\/uploads\/2018\/11\/Assassins-Creed-Odyssey-cover.jpg', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/acodyssey.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Watch Dogs', '2014-05-21', 54.99, 'https:\/\/s3.gaming-cdn.com\/images\/products\/254\/orig\/watch-dogs-cover.jpg', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/watchdogs.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Stardew Valley', '2016-05-21', 14.99, 'https:\/\/lh3.googleusercontent.com\/IRzV1qSynfxIIS3huwZuAc5V8Jbej8N2dvX-yuVcCeCbRfgMGOxOjO_KlJpVH9d8jQ1cOXdSp5cL__8KOdlMeVyh0Q', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/stardewvalley.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Terraria', '2011-05-21', 4.99, 'https:\/\/www.mobygames.com\/images\/covers\/l\/293163-terraria-windows-front-cover.jpg', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/terraria.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
					('Crusader Kings II', '2012-05-21', 99.99, 'https:\/\/images.g2a.com\/newlayout\/323x433\/1x1x0\/f33820499db3\/5911b0d3ae653a3da06fbd97', 'http:\/\/localhost\/ProjekatZaDrugiKolokvijum\/crusaderkings2.php','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.')
					
				";
				
				if($connection->query($sql)){
					echo "Tabela games je uspesno inicijalizovana...<br>";
				}else{
					echo "Tabela games je neuspesno inicijalizovana: " . $connection->error . "<br>";
				}
				/*games table*/
				
				/*developers table*/
				$sql="
					CREATE TABLE developers(
					developer_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
					developer_name varchar(45) NOT NULL,
					UNIQUE INDEX uq_developers_developer_name(developer_name) 
					)
				";
				
				
				if($connection->query($sql)){
					echo "Tabela developers je uspesno kreirana<br>";
				}else{
					echo "Tabela developers ne moze da se kreira: " . $connection->error . "<br>";
				}
				
				$sql="
					INSERT INTO developers(developer_name)
					VALUES
					('Bethesda Softworks'),
					('Blizzard Entertainment'),
					('NCsoft'),
					('VALVE Corporation'),
					('Epic Games'),
					('CD Projekt'),
					('Ubisoft'),
					('EA games'),
					('THQ'),
					('XLGames'),
					('Capcom'),
					('Rockstar'),
					('Square Enix'),
					('Zenimax Media'),
					('Paradox Development Studio')
					
				";
				
				if($connection->query($sql)){
					echo "Tabela developers je uspesno inicijalizovana...<br>";
				}else{
					echo "Tabela developers je neuspesno inicijalizovana: " . $connection->error . "<br>";
				}
				/*developers table*/
				
				/*library table*/
				$sql="CREATE TABLE library(
					library_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
					hours_played decimal(10,2) UNSIGNED NOT NULL,
					user_id int(10) UNSIGNED NOT NULL,
					game_id int(10) UNSIGNED NOT NULL,
					CONSTRAINT fk_library_user_id FOREIGN KEY(user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
					CONSTRAINT fk_library_game_id FOREIGN KEY(game_id) REFERENCES games(game_id) ON DELETE CASCADE ON UPDATE CASCADE,
					UNIQUE INDEX uq_library_user_id_game_id(user_id, game_id)
				)";
				
				
				if($connection->query($sql)){
					echo "Tabela library je uspesno kreirana<br>";
				}else{
					echo "Tabela library ne moze da se kreira: " . $connection->error . "<br>";
				}
				
				$sql="
					INSERT INTO library(user_id, game_id, hours_played)
					VALUES
						(5,7,532.64),
						(1,27,365.15),
						(2,26,924.32),
						(6,23,483.89),
						(3,23,163.06),
						(1,2,693.63),
						(3,15,392.14),
						(7,15,24.15),
						(1,29,69.72),
						(1,25,361.68),
						(6,3,219.77),
						(1,19,515.14),
						(10,12,345.78),
						(8,16,408.10),
						(8,20,815.29),
						(9,7,665.57),
						(7,29,950.54),
						(7,8,240.65),
						(10,21,798.00),
						(8,13,110.49),
						(2,12,982.35),
						(3,30,217.57),
						(5,11,862.66),
						(9,11,374.02),
						(6,17,436.42),
						(10,22,311.44),
						(1,7,793.11),
						(3,12,413.58),
						(8,8,80.40),
						(3,9,337.10),
						(3,11,739.30),
						(9,18,979.02),
						(4,5,352.60),
						(1,26,352.70),
						(8,7,917.75),
						(8,1,544.17),
						(1,6,298.10),
						(3,22,70.21),
						(5,6,309.54),
						(5,15,752.84),
						(9,16,514.98),
						(3,19,437.65),
						(7,27,686.33),
						(9,13,25.27),
						(1,4,867.78),
						(8,12,960.80),
						(8,23,367.99),
						(9,20,354.39),
						(7,25,383.35)

				";
				
				if($connection->query($sql)){
					echo "Tabela library je uspesno inicijalizovana...<br>";
				}else{
					echo "Tabela library je neuspesno inicijalizovana: " . $connection->error . "<br>";
				}
				
				/*library table*/
				
				/*developed_by table*/
				$sql="CREATE TABLE developed_by(
					developed_by_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
					developer_id int(10) UNSIGNED NOT NULL,
					game_id int(10) UNSIGNED NOT NULL,
					CONSTRAINT fk_developed_by_developer_id FOREIGN KEY(developer_id) REFERENCES developers(developer_id) ON DELETE CASCADE ON UPDATE CASCADE,
					CONSTRAINT fk_developed_by_game_id FOREIGN KEY(game_id) REFERENCES games(game_id) ON DELETE CASCADE ON UPDATE CASCADE,
					UNIQUE INDEX uq_developed_by_developer_id_game_id(developer_id, game_id)
				)";
				
				if($connection->query($sql)){
					echo "Tabela developed_by je uspesno kreirana<br>";
				}else{
					echo "Tabela developed_by ne moze da se kreira: " . $connection->error . "<br>";
				}
				
				
				
				$sql="
					INSERT INTO developed_by(developer_id, game_id)
					VALUES
						(1,1),
						(1,2),
						(1,3),
						(1,4),
						(14,2),
						(14,4),
						(2,5),
						(2,6),
						(2,7),
						(2,8),
						(2,9),
						(3,10),
						(3,11),
						(3,12),
						(4,13),
						(4,14),
						(4,15),
						(4,16),
						(5,17),
						(6,18),
						(6,19),
						(9,20),
						(11,21),
						(13,22),
						(13,23),
						(13,24),
						(7,25),
						(7,26),
						(7,27),
						(4,28),
						(4,29),
						(15,30)
					
					
				";
				
				if($connection->query($sql)){
					echo "Tabela developed_by je uspesno inicijalizovana...<br>";
				}else{
					echo "Tabela developed_by je neuspesno inicijalizovana: " . $connection->error . "<br>";
				}
				
				/*developed_by table*/
				
				/*games_tags table*/
				$sql="CREATE TABLE games_tags(
					games_tags_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
					tag_id int(10) UNSIGNED NOT NULL,
					game_id int(10) UNSIGNED NOT NULL,
					CONSTRAINT fk_games_tags_tag_id FOREIGN KEY(tag_id) REFERENCES tags(tag_id) ON DELETE CASCADE ON UPDATE CASCADE,
					CONSTRAINT fk_games_tags_game_id FOREIGN KEY(game_id) REFERENCES games(game_id) ON DELETE CASCADE ON UPDATE CASCADE,
					UNIQUE INDEX uq_games_tags_tag_id_game_id(tag_id, game_id)
				)";
				
				if($connection->query($sql)){
					echo "Tabela games_tags je uspesno kreirana<br>";
				}else{
					echo "Tabela games_tags ne moze da se kreira: " . $connection->error . "<br>";
				}
				
				$sql="
					INSERT INTO games_tags(tag_id, game_id)
					VALUES
						(1,1),
						(1,4),
						(1,5),
						(1,7),
						(1,10),
						(1,11),
						(1,12),
						(1,18),
						(1,19),
						(1,21),
						(1,22),
						(1,26),
						(2,1),
						(2,2),
						(2,4),
						(2,5),
						(2,7),
						(2,8),
						(2,10),
						(2,11),
						(2,12),
						(2,17),
						(2,18),
						(2,19),
						(2,20),
						(2,21),
						(5,2),
						(5,3),
						(5,6),
						(5,14),
						(5,16),
						(5,17),
						(5,18),
						(5,22),
						(5,23),
						(5,25),
						(5,27),
						(11,8),
						(11,9),
						(11,20),
						(13,21)
				";
				
				if($connection->query($sql)){
					echo "Tabela games_tags je uspesno inicijalizovana...<br>";
				}else{
					echo "Tabela games_tags je neuspesno inicijalizovana: " . $connection->error . "<br>";
				}
				
				/*games_tags table*/
				
				echo "<br><p id=\"proceedButton\"><a href=\"index.php\">Proceed to the website</a></p><br>";
				echo "<div>";
				
			echo "</div>";
			$connection->close();
		?>
	
	</body>
</html>