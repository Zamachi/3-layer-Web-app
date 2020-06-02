<?php
	define("fajloviProjekat","c:/xampp/htdocs/ProjekatZaDrugiKolokvijum/img/users/"); 
	$connection=new mysqli("localhost","Zamachi","asdwclhu","sii");
	session_start();
	
	if(isset($_POST['newPassword1']) && $_POST['newPassword1'] != NULL && $_POST['newPassword1']!='' && $_POST['newPassword1'] != ' '){
		
		$newPassword=password_hash($_POST['newPassword1'],PASSWORD_BCRYPT);
		$sqlUpdate="
		UPDATE users
		SET password='".$newPassword."'
		WHERE user_id=".$_SESSION['user_id']."
		";
		
		$connection->query($sqlUpdate);
		$_SESSION['password']=$_POST['newPassword1'];
		
	}
	
	if(isset($_POST['uplata'])){
		
		$accBalance=abs(floatval($_POST['uplata']));
		$sqlUpdate="
		UPDATE users
		SET account_balance=account_balance+".(number_format($accBalance, 2, ".", ""))."
		WHERE user_id=".$_SESSION['user_id']."
		";
	
		$connection->query($sqlUpdate);
		
		$sql="
		SELECT account_balance 
		FROM
			users
		WHERE 
			users.user_id = '".$_SESSION['user_id']."'
		";
		
		$rezultat=$connection->query($sql)->fetch_assoc();
		
		$_SESSION['accBalance']=$rezultat['account_balance'];
		$_SESSION['account_balance']=$rezultat['account_balance'];
	}
	
	if(isset($_FILES['fileToUpload'])){
						
			if(is_uploaded_file($_FILES['fileToUpload']['tmp_name'])){
				
				if(!($_FILES['fileToUpload']['type']!='image/png' || $_FILES['fileToUpload']['type']!='image/jpg' || $_FILES['fileToUpload']['type']!='image/jpeg')){
					echo "<p style=\"color: red !important;\">Pogresan format fajla!</p>";
				}else{
				
					$files = glob(''.$_SESSION['avatar']); 
						foreach($files as $file){ 
							if(is_file($file))
								unlink($file); 
					}
					
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
						UPDATE users
						SET avatar='".$connection->real_escape_string('img/users/' . $_FILES['fileToUpload']['name'])."'	
						WHERE user_id=".$_SESSION['user_id']."
						";
						
						echo strval($_SESSION['avatar']) . "<br>";
						
						$connection->query($sql);
						$_SESSION['avatar']='img/users/' . $_FILES['fileToUpload']['name'];
						
						echo strval($_SESSION['avatar']) . "<br>";
						
					}
					else {
						echo "<p>Fajl nije uspesno uploadovan</p>";
					}
				}	
			}else{
			}
		}else{
		}
	$connection->close();
	header("Location: profile.php");
	exit();
?>