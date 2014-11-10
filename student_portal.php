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

<script type="text/javascript" src="js/jquery.js"></script>

<script type="text/javascript">

	var cls = "1";
	
	$(function() {
	
		$('.class' + cls).trigger('click');
		$('.class' + cls).css('color', 'red');

	});
	
	function get_notice(id) {
		
			$.ajax({
				url: 'notice.php',
				type: 'POST',
				data: 'id=' + id,
				
				success: function(result) {
				
					var obj = $.parseJSON(result);
					$('#notice').fadeOut(500);
					$('#heading').fadeOut(500);
					setTimeout(function() { 
						$('#heading').text(obj.subject);
						$('#notice').text(obj.message);
					}, 500);
					$('#notice').fadeIn(500);
					$('#heading').fadeIn(500);
					
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
	
	<p id="notice"></p> 

</div>

</div>

</body>

</html>