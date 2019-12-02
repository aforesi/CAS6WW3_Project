<?php
	if(!isset($page_title)) { $page_title = 'Team Building Events'; }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title><?php echo $page_title; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="./css/style.css">
	<meta property="og:title" content="Find team building events near your" />
	<meta property="og:type"               content="website" />
	<meta property="og:title"              content="Find team building events near you" />
	<meta property="og:description"        content="Search for corporate and academic team building events in your area" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link rel="shortcut icon" type="image/png" href="img/favicon.png">
	<link rel="apple-touch-icon" href="/apple-touch-icon.png">
	<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
	<script src="script.js"></script>
</head>


<body>
	<!-- Header contains navigation bar and links to other sections of the website as well as the two main website logos based on the size of the display -->
	<header>
		<div class="container">
			<div id="branding">
			<a href="index.php">
				<picture>
					<source media="(min-width: 650px)" srcset="img/Logo_1.png">
					<source media="(min-width: 375px)" srcset="img/Logo_2.png">
					<img src="img/Logo_2.png" alt="Main_Logo">
				</picture>
			</a>
			</div>
			<nav>
				<ul>
					<li><a href="index.php">Search</a></li>
					<!-- <li><a href="add-review.php">Add Review</a></li> -->
					<li><a href="add-event.php">Add Event</a></li>
					<li><a href="sign-up.php">Sign-up/Login</a></li>
					<li id="userStatus"></li>
				</ul>
			</nav>
			<script>
				// document.getElementById('userStatus').innerHTML = 'Andrew Foresi';
				if (sessionStorage.getItem('userid')) {
					document.getElementById('userStatus').innerHTML = "<a href='#' onclick='logout(); return false;'>Logout</a>";
				} else {
					document.getElementById('userStatus').innerHTML = "<a href='login.php'>Login</div>";
				}
			</script>
		</div>
	</header>