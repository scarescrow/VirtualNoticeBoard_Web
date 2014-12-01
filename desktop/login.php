<?php

	include '../connection.php';
	
	if(!isset($_POST['tag']) || $_POST['tag'] != "login") {
	
		die("Access Denied");
	
	}
	
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	
	$query = "SELECT Name FROM admins WHERE Email = '$email' AND Password = '$password'";
	$result = mysql_query($query, $con);
	
	$num_rows = mysql_num_rows($result);
	
	$name = mysql_result($result, 0, "Name");
	
	if($num_rows > 0) {
	
		echo $name;
	
	} else {
		
		echo '#false';
		
	}
	
	mysql_close($con);

?>