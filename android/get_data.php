<?php

	include '../connection.php';
	
	$year = $_POST['year'];
	
	$query = "SELECT * FROM notices WHERE Year LIKE '%$year%' ORDER BY Date DESC, Time DESC";
	$result = mysql_query($query, $con);
	
	mysql_close($con);
	
	$num_rows = mysql_num_rows($result);
	
	$response = array('success' => 1, 'num' => $num_rows);
	
	$i = 0;
	
	while($i < $num_rows) {
	
		$response['data'][$i]['subject'] = mysql_result($result, $i, "Subject");
		$response['data'][$i]['message'] = mysql_result($result, $i, "Message");
		$response['data'][$i]['posted_by'] = mysql_result($result, $i, "Posted_By");
		$response['data'][$i]['date'] = mysql_result($result, $i, "Date");
		$response['data'][$i]['time'] = mysql_result($result, $i, "Time");
		
		$i++;
		
	}
	
	echo json_encode($response);

?>