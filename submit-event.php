<?php
	include('shared/functions.php');
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$eventStatus = submitEvent($_POST['title'], $_POST['address'], $_POST['description'], $_POST['latitude'], $_POST['longitude'], $_POST['phone'], $_POST['email'], $_POST['image_key']);

		$response_array['status'] = $eventStatus;

		
		header('Content-type: application/json');
		echo json_encode($response_array);
	}

?>