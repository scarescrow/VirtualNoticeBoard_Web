<?php

	session_start();
	
	include "connection.php";
	
	if(!isset($_SESSION['email'])) {
	
		header('location:index.html');
		die();
	
	}
	
	$id = $_POST['id'];
	
	$query = "SELECT * FROM notices WHERE SNo ='$id'";
	$result = mysql_query($query, $con);
	
	$json['subject'] = mysql_result($result, 0, "Subject");
	$json['message'] = nl2br(mysql_result($result, 0, "Message"), false);
	$json['date'] = mysql_result($result, 0, "Date");
	$json['time'] = mysql_result($result, 0, "Time");
	$json['posted_by'] = mysql_result($result, 0, "Posted_By");
	
	mysql_close($con);

	echo json_encode($json);