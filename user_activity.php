<?php

	if(!isset($_POST['tag']) || $_POST['tag'] == '') {
		die("Access Denied");
	}
	
	$tag = $_POST['tag'];
	
	include 'connection.php';
	
	$response = array('tag' => $tag, 'success' => 0, 'error' => 0);
	
	if($tag == 'login') {
		
		$email = $_POST['email'];
		$password = md5($_POST['password']);
		
		$query = "SELECT * FROM users WHERE email = '$email' && password = '$password'";
		$result = mysql_query($query, $con);
		
		if(mysql_num_rows($result) == 1) {
		
			$response['success'] = 1;
			$response['user']['name'] = mysql_result($result, 0, "name");
			$response['user']['email'] = mysql_result($result, 0, "email");
			
			echo json_encode($response);
		
		} else {
		
			$response['error'] = 1;
			$response['error_message'] = "Incorrect Email or Password";
			
			echo json_encode($response);
		
		}
	} 
	
	else if($tag == 'register') {
	
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = md5($_POST['password']);
		
		$query = "SELECT * FROM users WHERE email = '$email'";
		$result = mysql_query($query, $con);
		
		if(mysql_num_rows($result) > 0) {
		
			$response['error'] = 2;
			$response['error_message'] = "User Already Exists";
			echo json_encode($response);
			
		} else {
		
			$query = "INSERT INTO users (Name, Email, Password) VALUES ('$name', '$email', '$password')";
			if(mysql_query($query)) {
			
				$response['success'] = 1;
				$response['user']['name'] = $name;
				$response['user']['email'] = $email;
				$response['user']['password'] = $password;
				
				echo json_encode($response);
			
			} else {
				
				$response['error'] = 1;
				$response['error_msg'] = "Error occurred during Registration";
				
				echo json_encode($response);
				
			}
		
		}
	
	}
	
	else {
	
		echo "Invalid Request";
		
	}	

?>