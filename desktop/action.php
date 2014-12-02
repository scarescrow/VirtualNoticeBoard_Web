<?php

	include '../connection.php';
	
	$subject = $_POST['title'];
	$message = $_POST['message'];
	$posted_by = $_POST['admin'];
	$year_temp = $_POST['year'];
	
	if($year_temp == "I")
		$year = 1;
	else if($year_temp == "II")
		$year = 2;
	else if($year_temp == "III")
		$year = 3;
	else if($year_temp == "IV")
		$year = 4;
	else
		$year = 1234;
		
	date_default_timezone_set('Asia/Calcutta');
	
	$date = date('Y-m-d', time());
	$time = date('H:i:s', time());
	
	$query = "INSERT INTO notices (Subject, Message, Posted_By, Year, Date, Time) VALUES ('$subject', '$message', '$posted_by', '$year', '$date', '$time')";
	mysql_query($query, $con) or die(mysql_error());
	
	if($year == "1234")
		
		$query = "SELECT GCM_id FROM users WHERE GCM_id IS NOT NULL";
	
	else
	
		$query = "SELECT GCM_id FROM users WHERE Year = '$year' AND GCM_id IS NOT NULL";
		
	$result = mysql_query($query, $con);
	
	$gcm_ids = array();
	
	for($i = 0; $i < mysql_num_rows($result); $i++) {
	
		$gcm_ids[] = mysql_result($result, $i, "GCM_id");
	
	}
	
	$pushStatus = $subject;	
	$pushMessage = $subject;	
	
	$query = "SELECT SNo FROM notices WHERE Subject LIKE '%$subject%'";
	$result = mysql_query($query);
	$id = mysql_result($result, 0, "SNo");
	
	$message = array("id" => $id, "subject" => $pushMessage, "message" => $message, "admin" => $posted_by, "date" => $date, "time" => $time);
	$pushStatus = sendPushNotificationToGCM($gcm_ids, $message);
	
	
	mysql_close($con);
	
	if ($result) {
		echo "Your notice has been posted successfully.".mysql_error();
	}
	else {
		echo "Unfortunately, your notice could not be posted.";
	}
	
	function sendPushNotificationToGCM($registatoin_ids, $message) {
		
		//Google cloud messaging GCM-API url
		$url = 'https://android.googleapis.com/gcm/send';
		$fields = array(
			'registration_ids' => $registatoin_ids,
			'data' => $message,
		);
		
		// Google Cloud Messaging GCM API Key
		define("GOOGLE_API_KEY", "AIzaSyBKkSsXzjRXOmJA6SmjZEvQh5cJ-aoQYg0"); 		
		
		$headers = array(
			'Authorization: key=' . GOOGLE_API_KEY,
			'Content-Type: application/json'
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);	
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		
		$result = curl_exec($ch);				
		
		if ($result === FALSE) {
			die('Curl failed: ' . curl_error($ch));
		}
		
		curl_close($ch);
		return $result;
	}

?>