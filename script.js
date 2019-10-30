// script.js is called by all pages on the site for map functionality and form validation
// The Google Maps API has been used for the mapping functionality on results.html and single-result.html

// initResultsMap() is called from results.html and will ask the user to allow the site to access the users location
// If the user accepts then their latitude and longitude will be recorded and used for a few different purposes
// on the site. Including

function initResultsMap() {

	// Six hardcoded location coordinates that will be used by the markers on the results map
	var location1 = {lat: 43.645903, lng: -79.379080};
	var location2 = {lat: 43.650708, lng: -79.377268};
	var location3 = {lat: 43.649927, lng: -79.386738};
	var location4 = {lat: 43.653697, lng: -79.373391};
	var location5 = {lat: 43.652249, lng: -79.386992};
	var location6 = {lat: 43.653973, lng: -79.379937};

	// Instantiate a new google map object
	var map = new google.maps.Map(document.getElementById("map"), {
		zoom: 12, 
		center: location1,
	});

	// Instatiate all markers with an initial location that will be set if the user does not allow geolocation
	var marker1 = new google.maps.Marker({
		position: location1,
		map: map,
	});
	var marker2 = new google.maps.Marker({
		position: location2,
		map: map
	});
	var marker3 = new google.maps.Marker({
		position: location3,
		map: map
	});
	var marker4 = new google.maps.Marker({
		position: location4,
		map: map
	});
	var marker5 = new google.maps.Marker({
		position: location5,
		map: map
	});
	var marker6 = new google.maps.Marker({
		position: location6,
		map: map
	});


    // Try HTML5 geolocation. If user accepts, the map will be recentered to their location and 7 position markers will be dropped at fixed distances around that location
    if (navigator.geolocation) {

      	navigator.geolocation.getCurrentPosition(function(position) {
        
        // variables currentLat and currentLon will store the users current longitude and latitude if they accept access
        var currentLat = position.coords.latitude;
        var currentLon = position.coords.longitude;

        // The six position markers will be dropped at a fixed distance around the users current location
        // This is just for visualization. Once there is a backend to this website this will be changed and only
        // the actual location of saved events will be shown.
        marker1Pos = {
        	lat: currentLat + 0.005,
        	lng: currentLon	+ 0.005 
        }
        marker2Pos = {
        	lat: currentLat - 0.01,
        	lng: currentLon	- 0.0 
        }
        marker3Pos = {
        	lat: currentLat - 0.01,
        	lng: currentLon	+ 0.01 
        }
        marker4Pos = {
        	lat: currentLat - 0.02,
        	lng: currentLon	- 0.02 
        }
        marker5Pos = {
        	lat: currentLat + 0.03,
        	lng: currentLon	+ 0.03 
        }
        marker6Pos = {
        	lat: currentLat + 0.005,
        	lng: currentLon	+ 0.001 
        }

        // position object of users current location which will be used by setCenter()
        var pos = {
          lat: currentLat,
          lng: currentLon
        };

        // Center the map to the current users location
        map.setCenter(pos);

        // relocate the markers to a fixed idstance around the users location 
        // NOTE: This is just for project 2. Once there is a database implementation this functionality
        // will be modified so that only valid events will be droped on the map
        marker1.setPosition(marker1Pos);
        marker2.setPosition(marker2Pos);
        marker3.setPosition(marker3Pos);
        marker4.setPosition(marker4Pos);
        marker5.setPosition(marker5Pos);
        marker6.setPosition(marker6Pos);

      // Callback function
      }, function() {
        handleLocationError(true, infoWindow, map.getCenter());
      });
    } else {
      // Browser doesn't support Geolocation
      handleLocationError(false, infoWindow, map.getCenter());
    }

    // This event html is for the label on the markers. Right now it is the same label for all 7 markers with a link to the example individual result page

	var event = '<div id="content"><h1>Cardboard Boat Building Challenge</h1>' +
				'<a href="single-result.html">' +
				'Detailed Description</a></p></div>';

	//Create an infoWindow object that will hold the information contained in the label
	var infoWindow = new google.maps.InfoWindow({
		content: event
	});

	//when a user clicks on each marker it will open up the infoWindow label
	marker1.addListener('click', function(){
		infoWindow.open(map, marker1);
	});
	marker2.addListener('click', function(){
		infoWindow.open(map, marker2);
	});
	marker3.addListener('click', function(){
		infoWindow.open(map, marker3);
	});
	marker4.addListener('click', function(){
		infoWindow.open(map, marker4);
	});
	marker5.addListener('click', function(){
		infoWindow.open(map, marker5);
	});
	marker6.addListener('click', function(){
		infoWindow.open(map, marker6);
	});


}

// Called by the singe-result.html page to load a map with a predifined location
function initIndividualResultMap() {

	// Hardcoded location for individual event
	var location1 = {lat: 43.700114, lng: -79.409499};

	// instantiate a map centered at the fixed location above
	var map = new google.maps.Map(document.getElementById("map"), {
		zoom: 12, 
		center: location1,
	});

	// Information for the marker label
	var event = '<div id="content"><h1>The Amazing Chase</h1>' +
				'<a href="single-result.html">' +
				'Detailed Description</a></p></div>';

	// Instantiate a new infowindow
	infoWindow = new google.maps.InfoWindow({
		content: event
	});

	// Instantiate a marker and drop it on the map above
	var marker = new google.maps.Marker({
		position: location1,
		map: map,
	});

	// add a listener so that when a user clicks on the marker the label opens
	marker.addListener('click', function() {
		infoWindow.open(map, marker);
	})

}

// Called by the add-event.html page to set the event's longitude and latitude to the current location of the user
function setCurrentLocation() {
	// Try HTML5 geolocation.
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var currentLat = position.coords.latitude;
        var currentLon = position.coords.longitude;

        // Populate the appropriate form fields on add-event.html
        document.getElementById("latitude").value = currentLat;
        document.getElementById("longitude").value = currentLon;

      }, function() {
        handleLocationError(true, infoWindow, map.getCenter());
      });
    } else {
      // Browser doesn't support Geolocation
      handleLocationError(false, infoWindow, map.getCenter());
    }
}


// Javascript form validation for sign-up.html. Does not let the site redirect unless all conditions are successfully met. In this case if all conidtions are met, the page simply reloads.
// This function is called when the user clicks the sign-up button on sign-up.html

function validateSignUp () {
	// When the user clicks the submit button all of the contents from the form fields will be recorded in the follow variables
	var first_name = document.getElementById('first_name');
	var last_name = document.getElementById('last_name');
	var email = document.getElementById('email');
	var password = document.getElementById('password');
	var password_confirm = document.getElementById('password_confirm');
	var telephone = document.getElementById('telephone');

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
		return true;
	}
}

