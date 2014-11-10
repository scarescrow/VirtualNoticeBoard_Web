<?php

	session_start();
	
	include "connection.php";
	
	if(!isset($_SESSION['email'])) {
	
		header('location:index.html');
		die();
	
	}
	
	$id = $_POST['id'];
	
	$query = "SELECT Subject, Message FROM notices WHERE SNo ='$id'";
	$result = mysql_query($query, $con);
	
	$json['subject'] = mysql_result($result, 0, "Subject");
	$json['message'] = mysql_result($result, 0, "Message");
	
	mysql_close($con);

	echo json_encode($json);