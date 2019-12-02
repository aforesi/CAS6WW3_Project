<!-- Main landing page for events site, here you can search for events by keyword, your current location or by the overall rating of an event -->

<?php 
	// $page_title = 'Team Building Events';
	include('shared/header.php'); 
?>

	<script>
		window.onload = function() {
			setCurrentLocation();
		};

	</script>
	<!-- Showcase section contains main image bar and title, background image is passwed through the css file -->
	<section id="showcase">
		<div class="layer">
		</div>
		<div class="container">
			<h1>Find Team Building Events Near You</h1>
		</div>
	</section>

	<!-- Contains search fields that allow the user to search events by keyword, ratings or based on their current location via the Google Maps API -->
	<section id="add-content">
		<div class="container">
			<form action="results.php" method="get">
				<label for="search">Search by Keyword</label>
				<input type="hidden" name="searchMethod" value="keyword">
				<br>
				<input type="text" name="search" id="search" placeholder="I.e. Ice Skating">
				<br>
				<br>
				<button type="submit" class="select_button">Search by Keyword</button>
			</form>
			OR
			<form action="results.php" method="get">
				<input type="hidden" name="searchMethod" value="rating">
				<select id="review_select" class="review-ddl" name="review-status">
					<option value="all">All Ratings</option>
					<option value="4">4-5 Star Average</option>
					<option value="3">3-4 Star Average</option>
					<option value="2">2-3 Star Average</option>
				</select>
				<button type="submit" class="select_button">Search by Rating</button>
			</form>
			OR
			<form action="results.php" method="get" onsubmit="return checkForLocation()">
				<input type="hidden" name="searchMethod" value="location">
				<input type="hidden" id="latitude" name="latitude">
				<input type="hidden" id="longitude" name="longitude">
				<button class="select_button">Search by Your Location</button>
			</form>
		</div>
	</section>

	<section id="boxes">
		<div class="container">
			<div class="box">
				<img src="./img/corporate.jpg" alt="html5 Logo">
				<h2>Corporate</h2>
			</div>
			<div class="box">
				<img src="./img/classroom.jpg" alt="CSS Logo">
				<h2>Classroom</h2>
			</div>
			<div class="box">
				<img src="./img/sports.jpg" alt="html5 Logo">
				<h2>Athletic</h2>
			</div>
		</div>

	</section>

	<!-- Footer containing title and copyright logo -->
	<?php include('shared/footer.php'); ?>


</body>
</html>