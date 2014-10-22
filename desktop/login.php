<?php

	include '../connection.php';
	
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	
	$query = "SELECT * FROM users WHERE Email = '$email' AND Password = '$password'";
	$result = mysql_query($query, $con);
	
	$num_rows = mysql_num_rows($result);
	
	if($num_rows > 0) {
	
		echo 'A';
	
	} else {
		
		echo 'B';
		
	}
	
	mysql_close($con);

?>