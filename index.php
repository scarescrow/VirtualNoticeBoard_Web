<?php

	session_start();
	
	if(isset($_SESSION['email'])) {
		
		header('location: student_portal.php');
		die();
		
	}

?>

<html>

<head>

<title>Virtual Notice Board</title>

<link rel="stylesheet" type="text/css" href="css/student.css">
<link href="//fonts.googleapis.com/css?family=Convergence&subset=latin" rel="stylesheet" type="text/css">

</head>

<body>

<div class = "login_box">

<h2 id="heading">Student Login</h2>

<form action="action_student.php" method="post">

<table border="0" id="details" cellspacing="2" cellpadding="2">

<tr align="center">
<td>Email:</td><td> <input type="text" name="email"></td>
</tr>
<tr align="center">
<td>Password:</td><td> <input type="password" name="password"></td>
</tr>

</table>

<input type="submit" value="Submit" id="button">

</form>

</div>

</body>

</html>