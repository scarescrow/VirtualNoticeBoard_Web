<?php

	session_start();
	
	include "connection.php";
	
	if(!isset($_SESSION['email'])) {
	
		header('location:index.html');
		die();
	
	}
	
	$query = "SELECT SNo, Subject FROM notices";
	$result = mysql_query($query, $con);
	$num_rows = mysql_num_rows($result);
	
	$query_2 = "SELECT Name, Email FROM admins";
	$result_2 = mysql_query($query_2, $con);
	$num_rows_2 = mysql_num_rows($result_2);
	
	mysql_close($con);
	
?>

<html>

<head>

<title>Student Portal</title>

</head>

<body>

<h3>View Admins</h3>

<table>

<tr align="center">
	<th>S. No.</th>
	<th>Name</th>
	<th>Email</th>
</tr>

<?php	
	
	for($i = 0; $i < $num_rows_2; $i++) {
	
		?>
		
		<tr align="center">
			<td><?php echo $i + 1; ?></td>
			<td><?php echo mysql_result($result_2, $i, "Name"); ?></td>
			<td><?php echo mysql_result($result_2, $i, "Email"); ?></td>
		</tr>
		
		<?php
	
	}
	
?>

</table>

<br><br>

<h3>Add New Admin</h3>

<form action="submit_admin.php" method="post">

	Name: <input type="text" name="name"> <br><br>
	Email: <input type="text" name="email"><br><br>
	Password: <input type="password" name="password"><br><br>
	<input type="submit" value="Submit">
	
</form>

<br><br>

<h3>View Notices</h3>

<table>

<tr align="center">
	<th>S. No.</th>
	<th>Subject</th>
</tr>

<?php	
	
	for($i = 0; $i < $num_rows; $i++) {
	
		?>
		
		<tr align="center">
			<td><?php echo $i + 1; ?></td>
			<td><a href="notice.php?id=<?php echo mysql_result($result, $i, "SNo"); ?>"><?php echo mysql_result($result, $i, "Subject"); ?></a></td>
		</tr>
		
		<?php
	
	}
	
?>

</table>

<br><br>

<h3>Post New Notice</h3>

<form action="submit_notice.php" method="post">

	Subject: <input type="text" name="subject"> <br><br>
	Message: <textarea name="message" rows = "7" cols="15"></textarea><br><br>
	Year: <select name="year">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="1234">All</option>
	</select>
	<br><br>
	<input type="submit" value="Submit">
	
</form>

<br><br>

<a href="logout.php">Logout</a>

</body>

</html>