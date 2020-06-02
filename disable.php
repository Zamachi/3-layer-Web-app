<?php
	$connection=new mysqli("localhost","Zamachi","asdwclhu","sii");
	session_start();

	$sql="
	DELETE FROM library
	WHERE user_id=".$_SESSION['user_id']."
	";

	$connection->query($sql);
	
	$sql="
	DELETE FROM users
	WHERE user_id=".$_SESSION['user_id']."
	";

	$connection->query($sql);
	
	$_SESSION=[];
	session_destroy();
	
	
	
	$connection->close();
	header("Location: index.php");
	exit();
?>