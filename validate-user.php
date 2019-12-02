<?php
	include('shared/functions.php');
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$validationStatus = loginUser($_POST['email'], $_POST['password']);

		$response_array['status'] = $validationStatus; 
		$response_array['userid'] = getUserId($_POST['email']); 
		
		header('Content-type: application/json');
		echo json_encode($response_array);
	}


?>