<?php 
session_start();
  // Access the existing session.
	if ((isset($_SESSION['firstName'])) && (isset($_SESSION['email']))){ //check for session variable
			$firstname = $_SESSION['firstName'];
			$_SESSION = array();
			session_destroy();
			setcookie('PHPSESSID', '', time()-3600, '/');
			$message = "You are now logged out $firstname";
			$message2 = "Come Back Soon";
		} else { 
			$message = 'You have reached this page in error';
			$message2 = 'Please use the menu at the right';	
		}
		// Print the message:
		require 'includes/header.php';
		echo '<main>';
		echo '<h2>'.$message.'</h2>';
		echo '<h3>'.$message2.'</h3>';
		echo '</main>'
		?>

<?php // Include the footer and quit the script:
	include ('./includes/footer.php');?>