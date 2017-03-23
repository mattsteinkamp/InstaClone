<?php //This page is part of the checkout process if the user hasn't yet entered and email address.
	require_once 'secure_conn.php';
	require 'includes/header.php';
	if(!isset($_SESSION['firstName'])) {	//user not logged in
		$guest_info = TRUE; //name and email must be collected
	}
	else
		$validemail = $_SESSION['email'];
	if (isset($_POST['send'])) {
		$missing = array();
		$errors = array();
		$line1= trim(filter_input(INPUT_POST, 'line1', FILTER_SANITIZE_STRING));
		if (empty($line1))
			$missing[] = 'line1';
		$line2= trim(filter_input(INPUT_POST, 'line2', FILTER_SANITIZE_STRING));
		$city = trim(filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING));
		if (empty($city))
			$missing[] = 'city';
		$state = trim(filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING));
		if (empty($state))
			$missing[] = 'state';
		elseif (strlen($state) != 2)
			$errors[] = 'state';
		else {
			$validstate=$state;
			$validstate= strtoupper($validstate);
		}
		$zip = trim(filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_STRING));
		if (empty($zip))
			$missing[] = 'zip';
		elseif (strlen($zip) != 5)
			$errors[] = 'zip';
		else $validzip=$zip;
		if($guest_info){
			$firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING));
			if (empty($firstname))
				$missing[] = 'firstname';
			$lastname = trim(filter_input(INPUT_POST, 'laststname', FILTER_SANITIZE_STRING));
			if (empty($lastname))
				$missing[] = 'lastname';
			$email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));	//returns a string or null if empty or false if not valid	
			if (trim($_POST['email']==''))
				$missing[] = 'email';
			elseif (!$email)
			$errors[] = 'email';
			else 
				$validemail = $email;
			}//guest info
		if (!$missing && !$errors) {
			require_once ('../../pdo_config.php'); // Connect to the db.
			$sql = "INSERT INTO JJ_addresses values (:email, :line1, :line2, :city, :state, :zip)";
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':email', $validemail);
			$stmt->bindValue(':line1', $line1);
			$stmt->bindValue(':line2', $line2);
			$stmt->bindValue(':city', $city);
			$stmt->bindValue(':state', $validstate);
			$stmt->bindValue(':zip', $validzip);
			$stmt->execute();
			$errorInfo = $stmt->errorInfo();
			if (isset($errorInfo[2])){
				echo $errorInfo[2];
				// or echo '<main><h2>We are sorry but we were unable to process your<br> request at this time.</h2></main>';
				exit;
			}else{ ?>
				<main>
				<h2>We have saved your address</h2>
				<a href= "checkout.php">Return to Checkout</a>
				</main>
				<?php
				   include 'includes/footer.php';
				   exit;
			} 
		} // missing || errors 
		} //$_POST['send']	?>
	<main>
        <h2>Japan Journey</h2>
        <p>Ut enim ad minim veniam, quis nostrud exercitation consectetur adipisicing elit. Velit esse cillum dolore ullamco laboris nisi in reprehenderit in voluptate. Mollit anim id est laborum. Sunt in culpa duis aute irure dolor excepteur sint occaecat.</p>
        <form method="post" action="address.php">
			<fieldset>
				<legend>Please enter your shipping address:</legend>
				<?php if ($missing || $errors) { ?>
				<p class="warning">Please fix the item(s) indicated.</p>
				<?php } ?>
				<?php if ($guest_info){ //only collect name and email if user is a guest/not logged in.?>
					<p>
						<label for="fn">First Name: 
						<?php if ($missing && in_array('firstname', $missing)) { ?>
								<span class="warning">Please enter your first name</span>
							<?php } ?> </label>
						<input name="firstname" id="fn" type="text"
						 <?php if (isset($firstname)) {
							echo 'value="' . htmlspecialchars($firstname) . '"';
						} ?> >
					</p>
					<p>
						<label for="ln">Last Name: 
						<?php if ($missing && in_array('lastname', $missing)) { ?>
								<span class="warning">Please enter your last name</span>
							<?php } ?> </label>
						<input name="lastname" id="ln" type="text"
						 <?php if (isset($lastname)) {
							echo 'value="' . htmlspecialchars($lastname) . '"';
						} ?> >
					</p>
					<p>
						<label for="email">Email: 
						<?php if ($missing && in_array('email', $missing)) { ?>
								<span class="warning">Please enter your email address</span>
							<?php } ?>
						<?php if ($errors && in_array('email', $errors)) { ?>
								<span class="warning">The email address you provided is not valid</span>
							<?php } ?>
						</label>
						<input name="email" id="email" type="text"
						<?php if (isset($email) && !$errors['email']) {
							echo 'value="' . htmlspecialchars($email) . '"';
						} ?>>
					</p>
				<?php } //end guest_info ?>
			<p>
                <label for="l1">Street (Line 1): 
				<?php if ($missing && in_array('line1', $missing)) { ?>
                        <span class="warning">Please enter your street address</span>
                    <?php } ?> </label>
                <input name="line1" id="l1" type="text"
				 <?php if (isset($line1)) {
                    echo 'value="'.htmlspecialchars($line1).'"';
                } ?>
				>
            </p>
			<p>
                <label for="l2">Street (Line 2 / Optional): </label>
                <input name="line2" id="l2" type="text"
				 <?php if (isset($line2)) {
                    echo 'value="'.htmlspecialchars($line2).'"';
                } ?>
				>
            </p>
            <p>
                <label for="city">City: 
				<?php if ($missing && in_array('city', $missing)) { ?>
                        <span class="warning">Please enter your city</span>
                    <?php } ?>
				</label>
                <input name="city" id="city" type="text"
				<?php if (isset($city)) {
                    echo 'value="'.htmlspecialchars($city).'"';
                } ?>
				>
            </p>
			<p>
				<label for="state">State:
				<?php if ($errors && in_array('state', $errors)|| $missing && in_array('state', $missing)) { ?>
                        <span class="warning">Please enter your two-letter state code</span>
                    <?php } ?> </label>
          
                <input name="state" id="state" type="text"
				<?php if (isset($state)) {
                    echo 'value="' .htmlspecialchars($state) . '"';
                } ?>
				>
		    </p>
			<p>
                <label for="zip">Zip code:
				<?php if ($missing && in_array('zip', $missing)) { ?>
                        <span class="warning">Please enter your zip code</span>
                <?php } 
					  if ($errors &&in_array('zip',$errors)) { ?>
					  <span class="warning">Please use just your 5-digit zip code</span>
				 <?php } ?>	</label>
                <input name="zip" id="zip" type="text"
				<?php if (isset($zip)) {
                    echo 'value="'.htmlspecialchars($zip).'"';
                } ?>
				>
            </p>
            <p>
                <input name="send" type="submit" value="Register">
            </p>
		</fieldset>
        </form>
	</main>
<?php include 'includes/footer.php'; ?>