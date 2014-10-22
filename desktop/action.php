<?php

	include '../connection.php';
	
	$subject = $_POST['subject'];
	$message = $_POST['message'];
	$posted_by = $_POST['admin'];
	$year_temp = $_POST['year'];
	
	if($year_temp == "First")
		$year = 1;
	else if($year_temp == "Second")
		$year = 2;
	else if($year_temp == "Third")
		$year = 3;
	else if($year_temp == "Fourth")
		$year = 4;
	else
		$year = 1234;
	
	$query = "INSERT INTO notices (Subject, Message, Posted_By, Year) VALUES ('$subject', '$message', '$posted_by', '$year')";
	mysql_query($query, $con);

?>