<!-- This page is for adding reviews to various events that are listed on the site -->
<?php 
	$page_title = 'Add Review';
	include('shared/header.php'); 
	include('shared/functions.php');
?>
	<!-- Section where a user can add a review to a copmany that hosts a particular event. Includes fields like user, company name, address, longitude and latitude and the review itself. There is also a section to leave the overall rating score  -->
	<section id="add-content">
		<div class="page-title">
			<h4>Add a Review</h4>
		</div>
		<div class="review-container">
			<form>
				<label for="company_name">Select an Event to Review</label>
				<select id="event_ddl">';
					<?php
						$events = getEventList();
						foreach ($events as $event) {
							echo '<option id="event" name="event" value='. $event['id'] .'>' . $event['title'] . '</option>';
						};
					?>
				</select>
				<br>
				<label for="review">Review</label>
				<input type="text" id="review" name="review" placeholder="Enter review here..." >
				<br>
				<br>
				<label for="review_status">How many stars?</label>
				<select id="review_status" class="review-ddl" name="review-status">
					<option value="default">Number of Stars</option>
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				<button type="submit" id="submit-review">Submit</button>
			</form>
		</div>
	</section>

	<!-- Footer containing title and copyright logo -->
	<?php include('shared/footer.php'); ?>


</body>
</html>