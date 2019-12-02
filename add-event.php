<!-- This page is for adding new events that are not already listed on the site. Users can then add reviews that relate to these events -->
<?php 
	$page_title = 'Add Event';
	include('shared/header.php'); 
?>

	<!-- Here the user can add an event with information on the event's name, company name, address, description, latitude and longitude which can be filled out using the users current location as well as an image and video associated with the event -->
	<section id="add-content">
		<div class="page-title">
			<h4>Add an Event</h4>
		</div>
		<div class="review-container">
			<form class="input_form">
				<label for="event_name">Event Name</label>
				<br>
				<input id="event_name" type="text" required>
				<br>
				<label for="address">Address</label>
				<br>
				<input id="address" type="text" required>
				<br>
				<label for="event_description">Event Description</label>
				<br>
				<input id="event_description" type="text" required>
				<br>
				<label for="latitude">Latitude</label>
				<br>
				<input id="latitude" type="text">
				<br>
				<label for="longitude">Longitude</label>
				<br>
				<input id="longitude" type="text">
				<br>
				<label for="phone">Telephone (xxx-xxx-xxxx)</label>
				<br>
				<input type="tel" name="phone" id="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
				<br>
				<label for="email">Email</label>
				<br>
				<input type="email" name="email" id="email">
				<br>
				OR
				<button type="button" class="select_button" onclick="setCurrentLocation()">Set Current Location as Event Location</button>
				<br>
				<label for="file_upload">Select an Image to Upload</label>
				<input id="file_upload" type="file" name="fileToUpload">
				<label for="video_link">File to Upload</label>
				<br>	
				<input id="video_link" type="text" placeholder="Link to Video (i.e. https://www.youtube.com/...)">
				<br>
				<button type="button" class="select_button" type="submit" onclick="submitEvent()">Submit</button>
			</form>
		</div>
	</section>

	<!-- Footer containing title and copyright logo -->
	<?php include('shared/footer.php'); ?>

</body>
</html>