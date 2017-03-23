<?php 
	require 'secure_conn.php';
	require_once '../../pdo_config.php';
	require 'includes/header.php'; 
	$guest = trim(filter_input(INPUT_GET, 'guest', FILTER_SANITIZE_STRING));
?>
<main>
    <?php if (empty($_SESSION['cart']) || !isset($_SESSION['cart'])) { 
        echo '<h2>There are no products in your cart.</h2>';
		echo '<h3>Please use the Purchase Prints link to the left to shop.</h3>';
	} elseif (!isset($_SESSION['email']) || empty($_SESSION['email']) || $guest=="yes") { 
	// User is not logged in or is a guest
	} else {
		//check for existing address for this  registered user:
		$email = $_SESSION['email'];
		$query = 'SELECT * FROM JJ_addresses WHERE customerEmail = :email';
		$statement = $conn->prepare($query);
		$statement->bindValue(':email', $email);
		$statement->execute();
		$errorInfo = $statement->errorInfo();
		if (isset($errorInfo[2])) {
			$error = $errorInfo[2];
			echo $error;
			exit;
		} else { //query executed without errors
			$rows = $statement->rowCount();
			if ($rows == 1) { // Address found
				// Fetch the information.
				$address = $statement->fetch();
				$street1 = $address['street1'];
				$street2 = $address['street2'];
				$city = $address['city'];
				$state = $address['state'];
				$zip = $address['zip'];
				echo "<h3>We have your address as:</h3>";
				echo "<h4>".$_SESSION['firstName'].'  '.$_SESSION['lastName']."<br>";
				echo "$street1<br>";
				if (!empty($street2)) echo "$street2<br>";
				echo "$city, $state  $zip</h4><br>";
				include 'confirm_cart.php';
			} else { //no address found	?>		
				<h3>We do not have an address on file for you.</h3>
				<h3>Please proceed to the <a href = "address.php">Enter Address</a> page</h3> 
			<?php 
			}
		}  //query OK
	} //registered user ?>
		
</main>
<?php include 'includes/footer.php'; ?>