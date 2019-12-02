<!-- After a user clicks on one of the events listed on the results page they are redirected here for a more detailed description of the event -->
<?php 
	$page_title = 'Result';	
	include('shared/header.php'); 
	include('shared/functions.php');


	$event_id = $_GET['id'];

	$eventStmt = $GLOBALS['pdo']->prepare("SELECT * FROM events WHERE id = ?");
	$eventStmt->execute([$event_id]);
	$event = $eventStmt->fetch();

	$reviewStmt  = $GLOBALS['pdo']->prepare("SELECT * FROM reviews join users on reviews.reviewer_id = users.id where event_id = ?");

	$reviewStmt->execute([$event_id]);
	$reviews = $reviewStmt->fetchAll();
	$reviewCount = $reviewStmt->rowCount();

	$average_review_score = getAverageRating($event_id);

?>


	<section id="add-content">
		<div class="container">
			<h2><?php echo $event['title'] ?></h2>
		</div>
	</section>

	<!-- Single result window with a more detailed view of the event. Contains metadata on each review as well as location meta data -->

	<section id="main">
		<div class="container">
			<article id="main-col">
				<h2 class="page-title">About: <?php echo $event['title'] ?></h2>
				<p><?php echo $event['desc'] ?></p>
			<div class="single-result-image-container">			
				<picture>
				  <source media="(min-width: 650px)" srcset=<?php echo "./img/event-images/". $event['image_key']  .".jpg" ?> >
				  <source media="(min-width: 375px)" srcset=<?php echo "./img/event-images/". $event['image_key'] ."_small.jpg" ?> >
				  <img src=<?php echo "./img/event-images/". $event['image_key'] .".jpg" ?> alt="main image">
				</picture>
			</div>
			<picture>
				<br>
				<img id="average_review_image" class="average_review_image" src=<?php echo "img/". $average_review_score."_average.png" ?> alt="average score">
				<br>
				<br>
				<br>
			</picture>	

			<div id="review-container">
			<?php
				foreach ($reviews as $review) {
					echo '
					<aside itemscope itemtype="http://schema.org/Review" class="review">
						<div class="individual_review">
							<h3 itemprop="summary">'. $review['first_name'] .'</h3>
							<span itemprop="description">'. $review['review'] .'</span>
							<br>
							<br>
							<img class="review-image" src="img/'. $review['num_stars'] .'_stars.png" alt="positive review">
						</div>
					</aside>';
				}
			?>
			</div>

			<video width="320" height="240" controls>
			  <source src="vid/team_building.mp4" type="video/mp4">
			Your browser does not support the video tag.
			</video>

			<div class="review-container">
				<form>
					<label for="review">Review</label>
					<input type="hidden" name="eventid" id="eventid" value=<?php echo $event_id ?>>
					<input type="text" id="review" name="review" placeholder="Enter review here..." >
					<br>
					<br>
					<label for="review_status">How many stars?</label>
					<select id="review_status" class="review-ddl" name="review-status" >
						<option value="default">Number of Stars</option>
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
					<button type="button" id="submit-review" onclick="submitReview()">Submit</button>
				</form>
			</div>
			</article>

			<aside class="sidebar">
				<div class="map-container">
					<h3>Location: <?php echo $event['address'] ?></h3>
					<div id="map"></div>
					<script>
						var currentEventLat = <?php echo $event['lat'] ?>;
						var currentEventLng = <?php echo $event['lng'] ?>;
					</script>
					<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACmALJxFSXPsfcTmHGQR8Q2tuVyQUzWdg&callback=initIndividualResultMap" type="text/javascript">
					</script>
				</div>
			</aside>
		</div>

	</section>

<!-- 	<div itemscope itemtype="http://schema.org/LocalBusiness">
		<h3><span itemprop="name">Amazing Chase</span></h3>
		<span itemprop="description"> Top team building event in Toronto</span>
		<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
		<span itemprop="streetAddress">8 Elmsthorpe Avenue</span>
		<span itemprop="addressLocality">Toronto</span>,
		<span itemprop="addressRegion">ON</span>
		</div>
		<meta itemprop="latitude" content="43.700114" />
		<meta itemprop="latitude" content="-79.409499" />
		Phone: <span itemprop="telephone">850-648-4200</span>
	</div> -->

	<!-- Standard footer with copyright  -->
	<?php include('shared/footer.php'); ?>


</body>
</html>