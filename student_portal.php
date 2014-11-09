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
	
	mysql_close($con);
	
?>

<html>

<head>

<title>Student Portal</title>

<link rel="stylesheet" href="css/student.css" type="text/css">

</head>

<body>

<a href="logout.php" id="logout"><img src="images/logout.png" width="50%"></a>

<h2> Student Portal </h2>

<div id="main_body">

<div id="all_notices">

<h2>Notices</h2>

<table id="notices">

<tr align="center">
	<th>S. No.</th>
	<th>Subject</th>
</tr>

<?php	
	
	for($i = 0; $i < $num_rows; $i++) {
	
		?>
		
		<tr align="center">
			<td><?php echo ($i + 1)."."; ?></td>
			<td><a href="notice.php?id=<?php echo mysql_result($result, $i, "SNo"); ?>"><?php echo mysql_result($result, $i, "Subject"); ?></a></td>
		</tr>
		
		<?php
	
	}
	
?>

</table>

</div>

<div class="notice_box">

	<h2 id="heading">Title</h2>
	
	<p id="notice">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc</p> 

</div>

</div>

</body>

</html>