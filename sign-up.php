<!-- This is where new users can create an account on the website -->
<?php 
	$page_title = 'Sign Up';
	include('shared/header.php'); 
	include('shared/functions.php');

?>

	<section id="add-content">
		<div class="page-title">
			<h3>Create an Account</h3>
		</div>
		<div class="review-container">
			<!-- in order to validate the input from the form the submit button will call validateSignUp() from script.js which will check for blank values as well as ensuring that the two password entries match -->
			<form id="sign_up_form">
				<label for="first_name">First Name</label>
				<br>
				<input type="text" name="first_name" id="first_name">
				<br>
				<label for="last_name">Last Name</label>
				<br>
				<input type="text" name="last_name" id="last_name">
				<br>
				<label for="email">Email</label>
				<br>
				<input type="email" name="email" id="email">
				<br>
				<label for="password">Password</label>
				<br>
				<input type="password" name="password" id="password">
				<br>
				<label for="password_confirm">Confirm Password</label>
				<br>
				<input type="password" name="password_confirm" id="password_confirm">
				<br>
				<label for="telephone">Telephone (xxx-xxx-xxxx)</label>
				<br>
				<input type="tel" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" id="telephone">
				<br>
				<label for="birth_date">Date of Birth</label>
				<br>
				<input type="date" name="birth_date" id="birth_date">
				<br>
				<br>
				<button type="button" class="sign_up_button" onclick="validateSignUp()">Submit</button>
			</form>
			<div id="error"></div>
			<!-- If a user already has an account they can login here -->
			Already have an account? <a href="login.php">Log-in</a>

		</div>
	</section>

	<?php include('shared/footer.php'); ?>

</body>
</html>