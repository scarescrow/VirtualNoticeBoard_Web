<?php

	session_start();
	
	include "connection.php";
	
	if(!isset($_SESSION['email'])) {
	
		header('location:index.html');
		die();
	
	}
	
	$id = $_GET['id'];
	
	$query = "SELECT Subject, Message FROM notices WHERE SNo ='$id'";
	$result = mysql_query($query, $con);
	
	$subject = mysql_result($result, 0, "Subject");
	$message = mysql_result($result, 0, "Message");
	
	mysql_close($con);

?>

<html>

<head>

<title>Notice Details</title>

</head>

<body>

	<p><b><?php echo $subject; ?></b></p>
	<p><?php echo $message; ?></p>

</body>

</html>