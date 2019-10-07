Name: Andrew Foresi
StudentID: 001420367
Course: CS6WW3

Brief Description of Site: This website allows you to search for 
	team building events in your area. These events could be for
	corporate team building or educational team building excercises
	for classrooms and even sports teams.

Add-on task 2:

i) 
	Two versions of the main website logo have been provided on each webpage.
	The first version is 313x191 pixels, the second is 188x115 pixels.
	
	Code example:
		<picture>
			<source media="(min-width: 650px)" srcset="img/Logo_1.png">
			<source media="(min-width: 375px)" srcset="img/Logo_2.png">
			<img src="img/Logo_2.png" alt="Main_Logo">
		</picture>
	When the width of the device is 650 pixels or greater then Logo_1.png is displayed.
	When the width of the device is between 374 pixels and 650 pixels, Logo_2.png is displayed.
	In all other cases, Logo_2.png is displayed.
ii) 
	PROS:
	- Avoids having to download multiple images all at once. This will only download the image
	  for the associated screen size.
	- Can be used to crop images or add totally different images for different screen sizes. An example
	  would be the inclusion of a mobile logo when the user is on a mobile device and the same for tablet or
          a desktop machine.
	- Can be used as a substitute to using JavaScript for making simple animations and display changes
	- Allows multiple images with differing resolutions instead of only one image with one resolution

iii) 	
	CONS:
	- When you use the <picture> tag, you are not allowing the browser to help decide which images to show since it
	  MUST follow the rules that are specified in the <picture> tag. In some cases the browser will take into consideration
	  a whole number of different factors when deciding on how best to display images. This can be mitigated by
	  adding srcset="" or sizes="" attributes to the native <img> tags. Of course the downside to this is that all of 
	  these images will be loaded at once versus seperately using the <picture> tag











	