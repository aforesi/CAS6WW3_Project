<?php 
	include('shared/functions.php');
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$submitStatus = submitReview($_POST['eventid'], $_POST['review'], $_POST['rating'], $_POST['userid']);

		if ($submitStatus) {
			$response_array['status'] = $submitStatus; 
			$response_array['eventid'] = $_POST['eventid'];
			$response_array['review'] = $_POST['review'];
			$response_array['rating'] = $_POST['rating'];
			$response_array['userFirstName'] = getUserFirstName($_POST['userid']);
			$response_array['averageRating'] = getAverageRating($_POST['eventid']);
		} else {
			$response_array['status'] = $submitStatus; 
		}
		
		header('Content-type: application/json');
		echo json_encode($response_array);
	}
	


?>