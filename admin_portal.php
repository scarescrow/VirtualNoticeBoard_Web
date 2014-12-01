<?php

	session_start();
	
	include "connection.php";
	
	if(!isset($_SESSION['email']) || $_SESSION['role'] != "admin") {
	
		header('location:admin.php');
		die();
	
	}
	
	$query = "SELECT SNo, Subject FROM notices ORDER BY Date DESC, Time DESC";
	$result = mysql_query($query, $con);
	$i = 0;
	$num_rows = mysql_num_rows($result);
	
	mysql_close($con);
	
	$final_id = 0;
	
?>

<html>

<head>

<title>Admin Portal</title>

<link rel="stylesheet" href="css/student.css" type="text/css">
<link type='text/css' href='css/contact.css' rel='stylesheet' media='screen' />
<link rel="shortcut icon" href="images/favicon.ico" />

<script type="text/javascript" src="js/jquery.js"></script>
<script type='text/javascript' src='js/jquery.simplemodal.js'></script>
<script type='text/javascript' src='js/contact.js'></script>

<script type="text/javascript">

	var cls = "0";
	
	$(function() {
			
		get_notice(<?php echo mysql_result($result, $i, "SNo"); ?>);
		cls = <?php echo mysql_result($result, $i, "SNo"); ?>
		

	});
	
	function get_notice(id) {
		
		if(cls == id)
			return false;
			
		$(".class" + id).css('color', 'red');
		$(".class" + cls).css('color', '#000');
		cls = id;
			
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
			
			}
			
		});
		
		return false;
	}

</script>

</head>

<body>

<a href="logout_admin.php" id="logout"><img src="images/logout.png" width="50%"></a>

<h3 id="main_heading" style="margin-top:50px;">Admin Portal</h3>

<div id="main_body">

<div id="all_notices">

<table id="notices">

<tr align="center">
	<th>Notice.</th>
	<th>Subject</th>
</tr>

<?php	
	
	for($i = 0; $i < $num_rows; $i++) {
	
		$final_id = mysql_result($result, $i, "SNo");
	
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

<a href='#' class='contact' id="add"><img src="images/add_new.png"></a>
</body>

</html>