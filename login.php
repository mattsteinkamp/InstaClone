<?php
if (isset($_POST['send'])) {
	$missing = array();
	$errors = array();
	
	$valid_email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));	//returns a string or null if empty or false if not valid	
	if (trim($_POST['email']=='')|| (!$valid_email))  //Either empty or invalid email will be considered missing
		$missing[] = 'email';
	else
		$email = $valid_email;
	
	$password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
	
	// Check for a password:
	if (empty($password))
		$missing[]='password';
	
	if (!$missing && !$errors) {
		require_once ('../pdo_config.php'); // Connect to the db.
		// Make the query:
		$sql = "SELECT firstName, emailAddr, pw, userName, folder FROM insta_reg_users WHERE emailAddr = :email";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':email', $email);
		$stmt->execute();
		$errorInfo = $stmt->errorInfo();
		if (isset($errorInfo[2])){
			echo $errorInfo[2];
			exit;
		}
		else {
			$rows = $stmt->rowCount();
			if ($rows==0) { //email not found
				$errors[] = 'email';
			}
			else { // email found, validate password
				$result = $stmt->fetch();
				if ($password == password_verify($password, $result['pw'])) { //passwords match
					session_start();
					$_SESSION['firstName'] = $result['firstName'];
					$_SESSION['email'] = $email;
					$_SESSION['folder'] = $result['folder'];
					$_SESSION['userName'] = $result['userName'];
					header('Location: index.php'); //return to the home page
				}
				else {
					$errors[]='password';
				}
			} 
		} // End of else errors
	
	}
}
include 'https.php';
require 'includes/header.php';
?>
	<main>
	<div class="container">
	<div class="row">
        <div class="col-md-offset-5 col-md-5">
		<div class="form-login">
        <h2>InstaCopy</h2>
        <form method="post">
			<fieldset>
				<legend>Registered Users Login</legend>
				<?php if ($missing || $errors) { ?>
				<p class="warning">Please fix the item(s) indicated.</p>
				<?php } ?>
            <p>
                <label for="email">Please enter your email address:
				
				<?php if ($missing && in_array('email', $missing)) { ?>
                        <span class="warning">An email address is required</span>
                    <?php } ?>
				<?php if ($errors && in_array('email', $errors)) { ?>
                        <span class="warning">The email address you provided is not associated with an account</span>
                    <?php } ?>
				</label>
				<br>
                <input name="email" id="email" type="text"
				<?php if (isset($email) && !$errors['email']) {
                    echo 'value="' . htmlspecialchars($email) . '"';
                } ?>>
            </p>
			<p>
				<?php if ($errors && in_array('password', $errors)) { ?>
                        <span class="warning">The password supplied does not match the password for this email address. Please try again.</span>
                    <?php } ?> 
                <label for="pw">Password: 
				
				<?php if ($missing && in_array('password', $missing)) { ?>
                        <span class="warning">Please enter a password</span>
                    <?php } ?> </label>
					<br>
                <input name="password" id="pw" type="password">
            </p>
			
            <p>
                <input name="send" type="submit" value="Login">
            </p>
		</fieldset>
        </form>
		</div>
		</div>
		</div>
		</div>
	</main>
<?php include './includes/footer.php'; ?>
