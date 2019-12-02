<?php

	$pdo = connectToDb('localhost', 'root', '', 'cs6ww3');

	function submitEvent($title, $address, $description, $latitude, $longitude, $phone, $email, $image_key) {
		// $pdo = global $pdo;

		$stmt = $GLOBALS['pdo']->prepare("SELECT * FROM `events` where `title` = ?");
		$stmt->execute([$title]);
		$events = $stmt->fetchAll();
		$eventCount = $stmt->rowCount();

		if ($eventCount > 0) {
			return false;
		} else {
			$stmt = $GLOBALS['pdo']->prepare("INSERT INTO `events` (`title`, `lat`, `lng`, `desc`, `address`, `phone`, `email`, `image_key`) VALUES (?,?,?,?,?,?,?,?)");
			$stmt->execute([$title, $latitude, $longitude, $description, $address, $phone, $email, $image_key]);
			return true;
		}


	}


	function loginUser($email, $password) {
		//first check if the email already exists

		$stmt = $GLOBALS['pdo']->prepare("SELECT * FROM `users` where `email` = ?");
		$stmt->execute([$email]);
		$user = $stmt->fetch(PDO::FETCH_ASSOC);


		return password_verify($password, $user['password']);
		

	}

	function createNewUser($first_name, $last_name, $email, $password, $phone, $birth_date) {
		//first check if the email already exists

		$stmt = $GLOBALS['pdo']->prepare("SELECT * FROM `users` where `email` = ?");
		$stmt->execute([$email]);
		$users = $stmt->fetchAll();
		$userCount = $stmt->rowCount();

		if ($userCount > 0) {
			return false;
		} else {
			$stmt = $GLOBALS['pdo']->prepare("INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`, `phone`, `birth_date`) VALUES (?,?,?,?,?,?)");
			$stmt->execute([$first_name, $last_name, $email, password_hash($password, PASSWORD_DEFAULT), $phone, $birth_date]);
			return true;
		}


	}



	function outputReview($reviewerName, $review, $num_stars) {
		echo '
			<aside itemscope itemtype="http://schema.org/Review" class="review">
				<div class="individual_review">
					<h3 itemprop="summary">'. $reviewerName .'</h3>
					<span itemprop="description">'. $review .'</span>
					<br>
					<br>
					<img class="review-image" src="img/'. $num_stars .'_stars.png" alt="positive review">
				</div>
			</aside>';
	}

	function getUserFirstName($userid) {

		//check if the user has already submitted a review for this event
		$stmt = $GLOBALS['pdo']->prepare("SELECT * FROM `users` where `id` = ?");
		$stmt->execute([$userid]);
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		return $user['first_name'];
	}

	function getUserId($email) {

		//check if the user has already submitted a review for this event
		$stmt = $GLOBALS['pdo']->prepare("SELECT * FROM `users` where `email` = ?");
		$stmt->execute([$email]);
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		return $user['id'];
	}

	function submitReview($eventid, $review, $rating, $userid) {

		//check if the user has already submitted a review for this event
		$stmt = $GLOBALS['pdo']->prepare("SELECT * FROM `reviews` where `event_id` = ? and `reviewer_id` = ?");
		$stmt->execute([$eventid, $userid]);
		$reviews = $stmt->fetchAll();
		$reviewCount = $stmt->rowCount();

		if ($reviewCount > 0) {
			return false;
		} else {
			$stmt  = $GLOBALS['pdo']->prepare("INSERT INTO `reviews` (`event_id`, `review`, `num_stars`, `reviewer_id`) VALUES (?,?,?,?)");
			$stmt->execute([$eventid, $review, $rating, $userid]);
			return true;
		}
		
	}


	function getAverageRating($eventId) {
		$stmt = $GLOBALS['pdo']->prepare("SELECT * FROM reviews WHERE event_id = ?");
		$stmt->execute([$eventId]);
		$reviews = $stmt->fetchAll();
		$reviewCount = $stmt->rowCount();
		$average_review_score = 0;
		
		foreach ($reviews as $review) {
			$average_review_score += intval($review['num_stars']);
		}
		if ($reviewCount > 0) {
	    	 $average_review_score = round((($average_review_score/$reviewCount) * 2)/2);
		} else {
		    $average_review_score = 0;
		}
		return $average_review_score;
	}

	function connectToDb($host, $user, $password, $dbname) {
		// Set DSN

		$dsn = 'mysql:host='. $host . ';dbname='. $dbname;

		//Create PDO instance

		$pdo = new PDO($dsn, $user, $password);

		return $pdo;
	}

	function getResultString($search, $numEvents) {
		if ($search == 'location') {
			$searchDesc = 'Current Location';
		} else if ($search == '') {
			$searchDesc = 'All';
		} else {
			$searchDesc = $search;
		}

		if ($numEvents == '1') {
			$resultDesc = '(1 Result)';
		} else {
			$resultDesc = '('. $numEvents .' Results)';
		}

		return '<h1>Search Results For: '. $searchDesc . ' ' . $resultDesc . '</h1>';		
	}

	function getEventsByLocation($userLat, $userLng, $threshold) {
		

		$latUpperBound = $userLat + ($userLat * $threshold);
		$latLowerBound = $userLat - ($userLat * $threshold);
		$lngUpperBound = $userLng + ($userLng * $threshold);
		$lngLowerBound = $userLng - ($userLng * $threshold);

		$stmt  = $GLOBALS['pdo']->prepare("SELECT * FROM events WHERE lat BETWEEN ? AND ?");
		$stmt->execute([$latLowerBound, $latUpperBound]);
		$events = $stmt->fetchAll();
		$numEvents = $stmt->rowCount();
		$returnArray = array();
		array_push($returnArray, $events, $numEvents);

		return $returnArray;
	}

	class Event{

		public $id;
		public $lat;
		public $lng;
		public $title;
		public $desc;

		public function __construct($id, $lat, $lng, $title, $desc){
			$this->id = $id;
			$this->lat = $lat;
			$this->lng = $lng;
			$this->title = $title;
			$this->desc = $desc;
		}
	}


	//return an array of event objects
	function getEventList() {
		$stmt  = $GLOBALS['pdo']->prepare("SELECT * FROM events");
		$stmt->execute();
		$events = $stmt->fetchAll();
		return $events;
	}


?>