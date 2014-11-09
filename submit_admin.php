<?php

	session_start();
	
	include "connection.php";
	
	if(!isset($_SESSION['email'])) {
	
		header('location:index.html');
		die();
	
	}
	
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	
	$query = "INSERT INTO admins (Name, Email, Password) VALUES ('$name', '$email', '$password')";
	$result = mysql_query($query, $con) or die(mysql_error());
	
	mysql_close($con);
	
	header('location:superadmin_portal.php');

?>