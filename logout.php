<?php
session_start();
	if (isset($_SESSION['userName'])){ //check for session variable
			$username = $_SESSION['userName'];
			$_SESSION = array();
			session_destroy();
			setcookie('PHPSESSID', '', time()-3600, '/'); //delete the cookie
			include 'http.php'; //revert to http
		} 
		else { 
			$message = 'You are Now logged out';
			$message2 = 'Please use the menu at the top to continue browsing';	
		}
		// Print the message:
		require 'includes/header.php';
		echo '<main>';
		echo '<h2>'.$message.'</h2>';
		echo '<h3>'.$message2.'</h3>';
		echo '</main>'
		?>

<?php // Include the footer and quit the script:
	include ('includes/footer.php');?>