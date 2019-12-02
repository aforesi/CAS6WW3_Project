<!-- This page lists the search results that come from index.php's search features -->
<?php 
	$page_title = 'Results';
	include('shared/header.php'); 
	include('shared/functions.php');
?>

	<section id="add-content">
		<div class="container">
			

	<?php

		if ($_GET['searchMethod'] == 'keyword') {
			
			$searchQuery = $_GET['search'];
			$search = "%$searchQuery%";
			$stmt  = $GLOBALS['pdo']->prepare("SELECT * FROM events WHERE title LIKE ? OR address LIKE ?");
			$stmt->execute([$search, $search]);
			$events = $stmt->fetchAll();	
			$numEvents = $stmt->rowCount();

			echo getResultString($_GET['search'], $numEvents);

			//define which javascript function to call to instantiate the map
			// $mapFunction = "initSearchResultsMap";			

		} else if ($_GET['searchMethod'] == 'rating') {
			$rating = $_GET['review-status'];
			if ($rating == 'all') {
					$stmt  = $GLOBALS['pdo']->prepare("SELECT * FROM events");
					$stmt->execute();
					$events = $stmt->fetchAll();	
					$numEvents = $stmt->rowCount();
			} else {
					$stmt  = $GLOBALS['pdo']->prepare("SELECT *, AVG(r.num_stars) AS average
														FROM events e JOIN reviews r 
														ON e.id = r.event_id
														GROUP By e.id
														HAVING average > ?");
					$stmt->execute([$rating]);
					$events = $stmt->fetchAll();	
					$numEvents = $stmt->rowCount();
			}


		} else if ($_GET['searchMethod'] == 'location') {
			$resultsArray = getEventsByLocation(floatval($_GET['latitude']), floatval($_GET['longitude']), 0.001);
			$events = $resultsArray[0];
			$numEvents = $resultsArray[1];

			echo getResultString('location', $numEvents);

			echo '<script>
				var currentUserLatitude = '.$_GET['latitude'].';
				var currentUserLongitude = '.$_GET['longitude'].';
			</script>';

			//define which javascript function to call to instantiate the map
			// $mapFunction = "initSearchResultsMap";


		};

	?>

				</div>
			</section>


			<!-- This section contains all of the results in tabular format. Each title will link to one example results page -->
			<section id="main">
				<div class="container">


			<?php

			if (count($events) > 0) {
				$eventArray = array();			
		    	foreach($events as $event) {
		    		$average_review_score = getAverageRating($event['id']);

		    		echo '
						<aside class="sidebar">
							<div class="dark">
								<a href="single-result.php?id='. $event['id'].'">
									<div class="image-title-container">
										<img class="single-result-image" src="img/event-images/' . $event['image_key'] . '.jpg" alt="result-image">
										<h2 class="result-title">' . $event['title'] . '</h2>
									</div>
									<p style="padding: 10px 15px; height: 30%">'. $event['desc'] .'</p>
									<p><img class="logo" src="./img/phone-logo.png">'. $event['phone'] .'</p>
									<p><img class="logo" src="./img/email-logo.png">'. $event['email'] .'</p>
									<img class="average_review_image" src="img/' . $average_review_score . '_average.png" alt="average score">
								</a>
							</div>
						</aside>

		    		';

		    		array_push($eventArray, $event);
		    	};
		    
			    echo '
					<aside id="location-sidebar">
						<div class="dark" id="map"></div>
						<!-- pass array of latitude and longitudes -->
							<script>
								var eventArray = ' . json_encode($eventArray) .';
								var searchMethod = '. json_encode($_GET['searchMethod']) .';
							</script>
							<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACmALJxFSXPsfcTmHGQR8Q2tuVyQUzWdg&callback=initSearchResultsMap" type="text/javascript">
							</script>						
					</aside>
			    ';
		    };
    ?>

			<!-- This is the map provided by the Google Maps API that will center the the user's location if they grant permission. -->

		</div>

	</section>

	<!-- Standard footer with copyright -->
	<?php include('shared/footer.php'); ?>

</body>
</html>