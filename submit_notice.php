<?php

	session_start();
	
	include "connection.php";
	
	if(!isset($_SESSION['email'])) {
	
		header('location:index.html');
		die();
	
	}
	
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	$year = $_POST['year'];
	$email = $_SESSION['email'];
	
	$query = "INSERT INTO notices (Subject, Message, Posted_By, Year) VALUES ('$subject', '$message', '$email', '$year')";
	$result = mysql_query($query, $con) or die(mysql_error());
	
	mysql_close($con);
	
	header('location:admin_portal.php');

?>