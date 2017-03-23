<?php //This page checks for required content, errors, and provides sticky output
	require 'includes/header.php';
	if (isset($_POST['send'])) {
	$missing = array();
	$errors = array();
	
	$firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING)); //returns a string
	if (empty($firstname)) 
		$missing[]='firstname';
	
	$lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING)); //returns a string
	if (empty($lastname)) 
		$missing[]='lastname';
	
	$valid_email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));	//returns a string or null if empty or false if not valid	
	if (trim($_POST['email']==''))
		$missing[] = 'email';
	elseif (!$valid_email)
		$errors[] = 'email';
	else
		$email = $valid_email;
	
	$password1 = trim(filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_STRING));
	$password2 = trim(filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_STRING));
	// Check for a password:
	if (empty($password1) || empty($password2)) 
		$missing[]='password';
	elseif ($password1 !== $password2) 
			$errors[] = 'password';
	else $password = $password1;
	
	$accepted = filter_input(INPUT_POST, 'terms');
	if (empty($accepted) || $accepted !='accepted')
		$missing[] = 'accepted';
	
	if (!$missing && !$errors) {
		require_once ('../pdo_config.php'); // Connect to the db.
		$folder = preg_replace("/[^a-zA-Z0-9]/", "", $email);
		// make lowercase
		$folder = strtolower($folder);
		$sql = "INSERT into JJ_reg_users (firstName, lastName, emailAddr, pw, folder) VALUES (:firstName, :lastName, :email, :pw, :folder)";
		$pw = 
	$stmt= $conn->prepare($sql);
	$stmt->bindValue(':firstName', $firstname);
	$stmt->bindValue(':lastName', $lastname);
	$stmt->bindValue(':email', $email);
	$stmt->bindValue(':pw', password_hash($password1, PASSWORD_DEFAULT));
	$stmt->bindValue(':folder', $folder);
	$success = $stmt->execute();
	$errorInfo = $stmt->errorInfo();
	//create the directory in the uploads folder
	$dirPath = "../../uploads/".$folder;
	mkdir($dirPath,0777);
	if (isset($errorInfo[2]))
		echo $errorInfo[2];
	else
		echo '<main><h2>Thank you for registering</h2><h3>We have saved your information</h3></main>';
	include 'includes/footer.php'; 
	exit;
	}
}?>

	<main>
        <h2>Japan Journey</h2>
        <p>Ut enim ad minim veniam, quis nostrud exercitation consectetur adipisicing elit. Velit esse cillum dolore ullamco laboris nisi in reprehenderit in voluptate. Mollit anim id est laborum. Sunt in culpa duis aute irure dolor excepteur sint occaecat.</p>
        <form method="post" action="">
			<fieldset>
				<legend>Please Register:</legend>
				<?php if ($missing || $errors) { ?>
				<p class="warning">Please fix the item(s) indicated.</p>
				<?php } ?>
            <p>
                <label for="fn">First Name: 
				<?php if ($missing && in_array('firstname', $missing)) { ?>
                        <span class="warning">Please enter your first name</span>
                    <?php } ?> </label>
                <input name="firstname" id="fn" type="text"
				 <?php if (isset($firstname)) {
                    echo 'value="' . htmlspecialchars($firstname) . '"';
                } ?>
				>
            </p>
			<p>
                <label for="ln">Last Name: 
				<?php if ($missing && in_array('lastname', $missing)) { ?>
                        <span class="warning">Please enter your last name</span>
                    <?php } ?> </label>
                <input name="lastname" id="ln" type="text"
				 <?php if (isset($lastname)) {
                    echo 'value="' . htmlspecialchars($lastname) . '"';
                } ?>
				>
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
			<p>
				<?php if ($errors && in_array('password', $errors)) { ?>
                        <span class="warning">The entered passwords do not match. Please try again.</span>
                    <?php } ?> </label>
                <label for="pw1">Password: 
				
				<?php if ($missing && in_array('password', $missing)) { ?>
                        <span class="warning">Please enter a password</span>
                    <?php } ?> </label>
                <input name="password1" id="pw1" type="password">
            </p>
			<p>
                <label for="pw2">Confirm Password: 
				<?php if ($missing && in_array('password', $missing)) { ?>
                        <span class="warning">Please confirm the password</span>
                    <?php } ?> </label>
                <input name="password2" id="pw2" type="password">
            </p>
         
            <p>
			<?php if ($missing && in_array('accepted', $missing)) { ?>
                        <span class="warning">You must agree to the terms</span><br>
                    <?php } ?>
                <input type="checkbox" name="terms" value="accepted" id="terms"
				     <?php if ($accepted) {
                                echo 'checked';
                            } ?>
				>
                <label for="terms">I accept the terms of using this website</label>
            </p>
            <p>
                <input name="send" type="submit" value="Register">
            </p>
		</fieldset>
        </form>
	</main>
<?php include './includes/footer.php'; ?>
