<?php

session_start();

$action = isset($_POST["action"]) ? $_POST["action"] : "";
if (empty($action)) {
	// Send back the contact form HTML
	$output = "<div style='display:none'>
	<div class='contact-top'></div>
	<div class='contact-content'>
		<h1 class='contact-title'>Add a new notice:</h1>
		<div class='contact-loading' style='display:none'></div>
		<div class='contact-message' style='display:none'></div>
		<form action='#' style='display:none'>
			<label for='contact-name'>*Title:</label>
			<input type='text' id='contact-title' class='contact-input' name='title' tabindex='1001' />
			<label for='contact-email'>*Notice:</label>
			<textarea rows=\"7\" cols=\"15\" id='contact-message' class='contact-input' name='message' tabindex='1002' ></textarea>
			<label for='contact-subject'>*Subject:</label>
			<select id='contact-year' class='contact-input' name='year' tabindex='1002'>
				<option value=\"1\">First</option>
				<option value=\"2\">Second</option>
				<option value=\"3\">Third</option>
				<option value=\"4\">Fourth</option>
				<option value=\"1234\">All</option>
			</select>";

	$output .= "
			<label>&nbsp;</label>
			<button type='submit' class='contact-send contact-button' tabindex='1006'>Send</button>
			<button type='submit' class='contact-cancel contact-button simplemodal-close' tabindex='1007'>Cancel</button>
			<br/>
		</form>
	</div>
</div>";

	echo $output;
}
else if ($action == "send") {
	// Send the email
	$title = isset($_POST["title"]) ? $_POST["title"] : "";
	$message = isset($_POST["message"]) ? $_POST["message"] : "";
	$year = isset($_POST["year"]) ? $_POST["year"] : "";
	$admin = $_SESSION['email'];
	
	date_default_timezone_set('Asia/Calcutta');
	
	$date = date('Y-m-d', time());
	$time = date('H:i:s', time());
	
	include "connection.php";
	
	$query = "INSERT INTO notices (Subject, Message, Posted_By, Year, Date, Time) VALUES ('$title', '$message', '$admin', '$year', '$date', '$time');";
	$result = mysql_query($query, $con) or die(mysql_error());
	
	if($year == "1234")
		
		$query = "SELECT GCM_id FROM users WHERE GCM_id IS NOT NULL";
	
	else
	
		$query = "SELECT GCM_id FROM users WHERE Year = '$year' AND GCM_id IS NOT NULL";
		
	$result = mysql_query($query, $con);
	
	$gcm_ids = array();
	
	for($i = 0; $i < mysql_num_rows($result); $i++) {
	
		$gcm_ids[] = mysql_result($result, $i, "GCM_id");
	
	}
	
	$pushStatus = $title;	
	$pushMessage = $title;	
	
	$query = "SELECT SNo FROM notices WHERE Subject LIKE '%$title%'";
	$result = mysql_query($query);
	$id = mysql_result($result, 0, "SNo");
	
	$message = array("id" => $id,"subject" => $pushMessage, "message" => $message, "admin" => $admin, "date" => $date, "time" => $time);	
	$pushStatus = sendPushNotificationToGCM($gcm_ids, $message);
	
	mysql_close($con);
	if ($result) {
		echo "Your notice has been posted successfully.".mysql_error();
	}
	else {
		echo "Unfortunately, your notice could not be posted.";
	}
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