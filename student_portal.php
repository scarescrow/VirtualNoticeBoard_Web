<?php

	session_start();
	
	include "connection.php";
	
	if(!isset($_SESSION['email'])  || $_SESSION['role'] != 'student') {
	
		header('location:index.php');
		die();
	
	}
	
	$year = $_SESSION['year'];
	$query = "SELECT SNo, Subject FROM notices WHERE Year LIKE '%$year%' ORDER BY Date DESC, Time DESC";
	$result = mysql_query($query, $con);
	$num_rows = mysql_num_rows($result);
	$i = 0;
	
	mysql_close($con);
	
?>

<html>

<head>

<title>Student Portal</title>

<link rel="stylesheet" href="css/student.css" type="text/css">
<link rel="shortcut icon" href="images/favicon.ico" />

<script type="text/javascript" src="js/jquery.js"></script>

<script type="text/javascript">

	var cls = "0";
	
	$(function() {
	
		get_notice(<?php echo mysql_result($result, $i, "SNo"); ?>);
		cls = <?php echo mysql_result($result, $i, "SNo"); ?>;

	});
	
	function get_notice(id) {
		
			$.ajax({
				url: 'notice.php',
				type: 'POST',
				data: 'id=' + id,
				
				success: function(result) {
				
					var obj = $.parseJSON(result);
					
					$('#notice').fadeOut(200);
					$('#heading').fadeOut(200);
					$('#date').fadeOut(200);
					setTimeout(function() { 
						$('#date').text(obj.date + ", " + obj.time);
						$('#heading').text(obj.subject);
						$('#notice').html(obj.message);
						$('#posted_by').text(obj.posted_by);
					}, 200);
					$('#notice').fadeIn(200);
					$('#heading').fadeIn(200);
					$('#date').fadeIn(200);
					
					$(".class" + id).css('color', 'red');
					
					if(cls != id) {
					
						$(".class" + cls).css('color', '#000');
						cls = id;
						
					}
				
				}
				
			});
			
			return false;
	}

</script>

</head>

<body>

<a href="logout.php" id="logout"><img src="images/logout.png" width="50%"></a>

<h2 id="main_heading" style="margin-top:50px;"> Student Portal </h2>

<div id="main_body">

<div id="all_notices">

<table id="notices">

<tr align="center">
	<th>Notice</th>
	<th>Subject</th>
</tr>

<?php	
	
	for($i = 0; $i < $num_rows; $i++) {
	
		?>
		
		<tr align="center">
			<td><?php echo ($i + 1)."."; ?></td>
			<td><a href="javascript:void(0);" class="class<?php echo mysql_result($result, $i, "SNo"); ?>" onclick="get_notice(<?php echo mysql_result($result, $i, "SNo"); ?>)"><?php echo mysql_result($result, $i, "Subject"); ?></a></td>
		</tr>
		
		<?php
	
	}
	
?>

</table>

</div>

<div class="notice_box">

	<h2 id="heading"></h2>
	
	<p><b>Date: </b> <span id="date"></span></p>
	
	<p id="notice"></p> 
	
	<p id="posted_by" style="text-align:right"></p>

</div>

</div>

</body>

</html>