<!-- This page is for existing users to login to the site -->
<?php 
	$page_title = 'Login';
	include('shared/header.php'); 
?>

	<!-- This is the form used to enter the login credentials of the user -->
	<section id="add-content">
		<div class="page-title">
			<h3>Login</h3>
		</div>
		<div class="review-container">
			<form>
				<label for="email">Email</label>
				<br>
				<input id="email" type="email" placeholder="Email">
				<br>
				<label for="password">Password</label>
				<br>
				<input id="password" type="password" placeholder="Password">
			</form>

			<!-- If the user does not have an account they can use this link to sign up for an account -->
			Don't have an account? <a href="sign-up.php">Sign-up</a>

			<button type="button" class="select_button" onclick="loginUser()">Submit</button>

		</div>
	</section>

	<!-- Standard footer with copyright -->
	<?php include('shared/footer.php'); ?>

</body>
</html>