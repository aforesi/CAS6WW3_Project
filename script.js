// script.js is called by all pages on the site for map functionality and form validation
// The Google Maps API has been used for the mapping functionality on results.php and single-result.php
const indexPage = 'http://localhost/cs6ww3/index.php';
const loginPage = 'http://localhost/cs6ww3/login.php';

function submitEvent() {
	//form validation

	var latitude = document.getElementById('latitude').value;
	var longitude = document.getElementById('longitude').value;

	if (!sessionStorage.getItem('userid')){
		alert("You need to be logged in to submit a review");
	} else if (latitude < -90 || latitude > 90) {
		alert("latitude out of bounds");
		document.getElementById('latitude').value = "";
	} else if (longitude < -180 || longitude > 180 ) {
		alert("longitude out of bounds");
		document.getElementById('longitude').value = "";
	} else {
		$.ajax({
			url: 'submit-event.php',
			method: "POST",
			dataType: "json",
			data: {
				title: document.getElementById("event_name").value,
				address: document.getElementById("address").value,
				description: document.getElementById("event_description").value,
				latitude: document.getElementById("latitude").value,
				longitude: document.getElementById("longitude").value,
				phone: document.getElementById("phone").value,
				email: document.getElementById("email").value,
				image_key: (Math.floor(Math.random() * 9) + 1)
			},
			success: function(data, status) {
				console.log(status);
				if (!data.status) {
					alert("There is already an event with that title");
					document.getElementById('event_name').value = "";
				} else {
					alert("Successfully submitted event");
					window.location.href = indexPage;
				}

			},
			error: function(data, status) {
				console.log(status);
			}
		})
	}
}

function logout() {
	sessionStorage.removeItem('userid');
	document.getElementById('userStatus').innerHTML = "<a href='login.php'>Login</div>"
}


function loginUser() {
	$.ajax({
			url: 'validate-user.php',
			method: "POST",
			dataType: "json",
			data: {
				email: document.getElementById('email').value,
				password: document.getElementById('password').value
			},
			success: function(data, status) {
				if (!data.status) {
					alert("Incorrect Credentials")
					document.getElementById('email').value = "";
					document.getElementById('password').value = "";
				} else {
					alert("Successfully logged in");
					document.getElementById('userStatus').innerHTML = "<a href=''>Logout</a>";
					window.location.href = indexPage;
					sessionStorage.setItem("userid", data.userid);
				}

			},
			error: function(data, status) {
				console.log(status);
			}
		})
}

function createNewUser(first_name, last_name, email, password, phone, birthdate) {


		$.ajax({
			url: 'submit-user.php',
			method: "POST",
			dataType: "json",
			data: {
				first_name: first_name,
				last_name: last_name,
				email: email,
				password: password,
				phone: phone,
				birth_date: birthdate
			},
			success: function(data, status) {
				if (!data.status) {
					alert("A user with that email already exists.")
					document.getElementById('email').value = "";
				} else {
					window.location.href = loginPage;
				}

			},
			error: function(data, status) {
				console.log(status);
			}
		})
}


function submitReview() {

	//form validation
	if (!sessionStorage.getItem('userid')){
		alert("You need to be logged in to submit a review");
	} else if (document.getElementById("review").value == "") {
		alert("Please enter a review");
	} else if (document.getElementById("review_status").value == "default") {
		alert("Please enter a rating");
	} else {
		$.ajax({
			url: 'submit-review.php',
			method: "POST",
			dataType: "json",
			data: {
				userid: sessionStorage.getItem('userid'),
				eventid: document.getElementById("eventid").value,
				review: document.getElementById("review").value,
				rating: document.getElementById("review_status").value
			},
			success: function(data, status) {
				document.getElementById("review").value = "";
				document.getElementById("review_status").value = "default";
				if (!data.status) {
					alert("You already submitted a review for this event.")
				} else {
					$('#review-container').append(
						'<aside itemscope itemtype="http://schema.org/Review" class="review">' +
						'<div class="individual_review">' +
							'<h3 itemprop="summary">' + data.userFirstName + '</h3>'+
							'<span itemprop="description">' + data.review + '</span>'+
							'<br>'+
							'<br>'+
							'<img class="review-image" src="img/'+ data.rating +'_stars.png" alt="positive review">'+
						'</div>'+
					'</aside>'
					);

					$("#average_review_image").attr("src","img/" + data.averageRating + "_average.png");
				}
				console.log(status);

			},
			error: function(data, status) {
				document.getElementById("review").value = "";
				document.getElementById("review_status").value = "default";
				console.log(status);
			}
		})
	}

	

}



function checkForLocation() {
	var locationEnabled = sessionStorage.getItem("locationEnabled");

	if (locationEnabled == "true") {
		return true;
	} else {
		alert('You must have location services enabled to use this feature');
		return false;
	}
}


// initResultsMap() is called from results.php and will ask the user to allow the site to access the users location
// If the user accepts then their latitude and longitude will be recorded and used for a few different purposes
// on the site. Including

function initSearchResultsMap() {

	//set the center of the map to the location of the first event or to Toronto as default	

	if (searchMethod == 'location') {
		var centerLocation = {
			lat: parseFloat(currentUserLatitude),
			lng: parseFloat(currentUserLongitude)
		};
	} else {
		var centerLocation = {
			lat: parseFloat(eventArray[0].lat),
			lng: parseFloat(eventArray[0].lng)
		};
	}


	// Instantiate a new google map object
	var map = new google.maps.Map(document.getElementById("map"), {
		zoom: 12, 
		center: centerLocation,
	});

	eventArray.forEach(function(event){

		var infoWindow = new google.maps.InfoWindow({
			content:
				'<div id="content">' +
					'<a href="single-result.php?id=' + event['id'] + '">' +
						'<h1>' + event['title'] + '</h1>' +
					'</a>'+
					'<p>' + event['desc'] + '</p>' +
				'</div>'
		})

		new google.maps.Marker({
			position: {
				lat: parseFloat(event['lat']),
				lng: parseFloat(event['lng'])
			},
			map: map
		}).addListener('click', function(){
			infoWindow.open(map, this); 	
		});
	});

}


// Called by the singe-result.html page to load a map with a predifined location
function initIndividualResultMap() {

	// Hardcoded location for individual event
	var location1 = {lat: currentEventLat, lng: currentEventLng};

	// instantiate a map centered at the fixed location above
	var map = new google.maps.Map(document.getElementById("map"), {
		zoom: 12, 
		center: location1,
	});

	// Instantiate a marker and drop it on the map above
	var marker = new google.maps.Marker({
		position: location1,
		map: map,
	});

}

// Called by the add-event.html page to set the event's longitude and latitude to the current location of the user
function setCurrentLocation() {
	sessionStorage.setItem("locationEnabled", false);

	// Try HTML5 geolocation.
    if (navigator.geolocation) {
	
      navigator.geolocation.getCurrentPosition(function(position) {
      	
        // Populate the appropriate form fields on add-event.html
        document.getElementById("latitude").value = position.coords.latitude;
        document.getElementById("longitude").value = position.coords.longitude;

        sessionStorage.setItem('locationEnabled', true);

      });
    } else {
	
    }
}



// Javascript form validation for sign-up.php. Does not let the site redirect unless all conditions are successfully met. In this case if all conidtions are met, the page simply reloads.
// This function is called when the user clicks the sign-up button on sign-up.php

function validateSignUp () {
	// When the user clicks the submit button all of the contents from the form fields will be recorded in the follow variables
	var first_name = document.getElementById('first_name');
	var last_name = document.getElementById('last_name');
	var email = document.getElementById('email');
	var password = document.getElementById('password');
	var password_confirm = document.getElementById('password_confirm');
	var telephone = document.getElementById('telephone');
	var birthdate = document.getElementById('birth_date');

	// console.log(first_name.value, typeof(first_name.value));
	// console.log(last_name.value, typeof(last_name.value));
	// console.log(email.value, typeof(email.value));
	// console.log(password.value, typeof(password.value));
	// console.log(password_confirm.value, typeof(password_confirm.value));
	// console.log(telephone.value, typeof(telephone.value));
	// console.log(birthdate.value, typeof(birthdate.value));


	// The below logic will validate the users input. If anything does not meet these requirements, an alert will be present to
	// the user and they will have to review their submission

	// first name must not be blank
	if (first_name.value == '') {
		alert('Please enter first name');
		return false;
	// last name must not be empty
	} else if (last_name.value == '') {
		alert('Please enter last name');
		return false;
	// email field must not be empty
	} else if (email.value == '') {
		alert('Please enter an email');
		return false;
	// password field must not be empty
	} else if (password.value == '') {
		alert('Please enter a password');
		return false;
	// password confirm field must not be empty
	} else if (password_confirm.value == '') {
		alert('Please confirm password');
		return false;
	// password field and the password confirmation field must match
	} else if (password.value != password_confirm.value) {
		alert('Passwords must match');
		return false;
	// must provide a telphone number, there is also HTML5 validation included in this field as well.
	} else if (telephone.value == '') {
		alert('Please enter a phone number');
		return false;
	} else {
		// console.log('here');
		createNewUser(first_name.value, last_name.value, email.value, password.value, telephone.value, birthdate.value);
	}
}

