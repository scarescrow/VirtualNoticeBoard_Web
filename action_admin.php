<?php

	session_start();
	
	include "connection.php";
	
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	
	$query = "SELECT * FROM admins WHERE Email = '$email' AND Password = '$password'";
	$result = mysql_query($query, $con) or die(mysql_error());
	$num_rows = mysql_num_rows($result);
	
	mysql_close($con);
	
	if($num_rows == 1) {
	
		
		$_SESSION['email'] = mysql_result($result, 0, "Name");
		$_SESSION['role'] = "admin";
		
		header('location:admin_portal.php');
	
	} else {
	
		session_destroy();
		echo "Invalid Email/Password.";
	
	}
	
	

?>