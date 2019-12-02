<?php 
	include('shared/functions.php');
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$newUserStatus = createNewUser($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'], $_POST['phone'], $_POST['birth_date']);

		$response_array['status'] = $newUserStatus;

		
		header('Content-type: application/json');
		echo json_encode($response_array);
	}


?>