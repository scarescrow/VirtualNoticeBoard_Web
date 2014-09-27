<?php

	include 'connection.php';
	
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	
	$query = "INSERT INTO notices (Subject, Message) VALUES ('$subject', '$message')";
	mysql_query($query, $con);

?>