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
	$time = date('h:i:s', time());
	
	$query = "INSERT INTO notices (Subject, Message, Posted_By, Year, Date, Time) VALUES ('$subject', '$message', '$posted_by', '$year', '$date', '$time')";
	mysql_query($query, $con);
	
	if($year == "1234")
		
		$query = "SELECT GCM_id FROM users WHERE GCM_id IS NOT NULL";
	
	else
	
		$query = "SELECT GCM_id FROM users WHERE Year = '$year' AND GCM_id IS NOT NULL";
		
	$result = mysql_query($query, $con);
	
	$gcm_ids = array();
	
	for($i = 0; $i < mysql_num_rows($result); $i++) {
	
		$gcm_ids[] = mysql_result($result, $i, "GCM_id");
	
	}
	
	$pushStatus = "New notice posted!";	
	$pushMessage = "New notice!";	
	
	$message = array("m" => $pushMessage);	
	$pushStatus = sendPushNotificationToGCM($gcm_ids, $message);
	
	
	mysql_close($con);
	
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