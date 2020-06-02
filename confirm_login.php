<?php
	
	$connection=new mysqli("localhost","Zamachi", "asdwclhu", "sii");
	
	$username=$_POST['usernameLogin'];
	$password=$_POST['passwordLogin'];
	
	echo "Korisnicko ime je: $username <br>";
	echo "Sifra je: $password <br>";

	$sql="
		SELECT * 
		FROM
			users
		WHERE 
			users.username = '$username'
	";
	
	if($rezultat=$connection->query($sql)){
		
		if($rezultat->num_rows == 1){
			$hashedPwd=$connection->query("SELECT password FROM users WHERE users.username = '$username'")->fetch_assoc();
			if(password_verify($password, $hashedPwd['password'])){
			
				$parametri=$rezultat->fetch_assoc();
				echo "Postoji korisnik! <br>";
				session_start();
				$_SESSION['isLoggedIn']=TRUE;
				$_SESSION['user_id']=$parametri['user_id'];
				$_SESSION['created_at']=$parametri['created_at'];
				$_SESSION['account_balance']=$parametri['account_balance'];
				$_SESSION['avatar']=$parametri['avatar'];
				$_SESSION['username']=$parametri['username'];
				$_SESSION['password']=$password;
				$_SESSION['accBalance']=$parametri['account_balance'];
				$_SESSION['country']=$parametri['country'];
				
				
				setcookie("fileName",strval($_SESSION['username']) . ".txt",time() + 86400, "/");
				
				header("Location: index.php");
			}else{
				
				header("Location: login_fail_wrong_combination.php");
			}
		}else{
			
			header("Location: login_fail_no_user.php");
		}
		
	}else{
		echo "Greska sa query-jem<br>";
	}
	
?>