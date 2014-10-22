<?php

	include '../connection.php';
	
	$query = "SELECT * FROM notices";
	$result = mysql_query($query, $con);
	
	$num_rows = mysql_num_rows($result);
	
	$response = array('success' => 0, 'num' => $num_rows);
	
	$i = 0;
	
	while($i < $num_rows) {
	
		$response['data'][$i]['subject'] = mysql_result($result, $i, "Subject");
		$response['data'][$i]['message'] = mysql_result($result, $i, "Message");
		
		$i++;
		
	}
	
	echo json_encode($response);

?>