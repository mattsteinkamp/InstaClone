<?php require './includes/header.php';
//Matt Steinkamp
if (isset($_POST['send'])) {
	//step 2: Determine if name or email is missing and report
	$missing = array();
	$errors = array();
	
	$firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING)); //returns a string
	if (empty($firstname)) 
		$missing[]='firstname';
	
	$lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING)); //returns a string
	if (empty($lastname)) 
		$missing[]='lastname';
	
	$username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING)); //returns a string
	if (empty($username)) 
		$missing[]='username';
	
	$phonenumber = trim(filter_input(INPUT_POST, 'phonenumber', FILTER_SANITIZE_STRING));
	if (empty($phonenumber))
		$phonenumber = 0;
	
	
	$valid_email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));	//returns a string or null if empty or false if not valid	
	if (trim($_POST['email']==''))
		$missing[] = 'email';
	elseif (!$valid_email){
		$errors[] = 'email';
		}
	else{
		$email = $valid_email;
	}
	$password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
	$password_confirm = trim(filter_input(INPUT_POST, 'password_confirm', FILTER_SANITIZE_STRING));
	if (($password != $password_confirm) || (strlen($password)<=3)){
		$errors[] = 'password';
		$missing[] = 'password';
	}
	if (!$missing && !$errors) {
		require_once ('../pdo_config.php'); // Connect to the db.
		$folder = $username;	//the folder is just the userName since usernames have to be unique
		$sql = "INSERT into insta_reg_users (firstName, lastName,userName, emailAddr, pw, phonenumber, folder) VALUES (:firstName, :lastName,:userName, :email, :pw, :phonenumber, :folder)";
		$stmt= $conn->prepare($sql);
		$stmt->bindValue(':firstName', $firstname);
		$stmt->bindValue(':lastName', $lastname);
		$stmt->bindValue(':userName', $username);
		$stmt->bindValue(':email', $valid_email);
		$stmt->bindValue(':pw', password_hash($password, PASSWORD_DEFAULT));
		$stmt->bindValue(':phonenumber', $phonenumber);
		$stmt->bindValue(':folder', $folder);
		$success = $stmt->execute();
		$errorInfo = $stmt->errorInfo();
		$dirPath = "../uploads/".$folder;
		mkdir($dirPath,0777);
		if (isset($errorInfo[2]))
				echo 'That Email is already in use';
		else
		echo '<main><h2>Thank you for registering</h2><h3>We have saved your information</h3></main>';
		include 'includes/footer.php'; 
		exit;
	}
	echo "<br>";
}?>
	
	<form class="form-inline" method="post">
  <fieldset>
	    <div class="control-group">
      <!-- FirstName -->
      <label class="control-label"  for="firstname">First Name</label>
      <div class="controls">
        <input type="text" id="firstname" name="firstname"  <?php if (isset($firstname)) { echo 'value="' . htmlspecialchars($firstname) . '"'; } ?> class="input-xlarge">
		<?php if ($missing && in_array('firstname', $missing)) {
                        echo '<div class="text-danger">Please enter your name</div>';} 
						else {
							echo '<p class="help-block">Please enter your first name</p>';
						}?> 
      </div>
    </div>
	    <div class="control-group">
      <!-- LastName -->
      <label class="control-label"  for="lastname">Last Name</label>
      <div class="controls">
        <input type="text" id="lastname" name="lastname" <?php if (isset($lastname)) { echo 'value="' . htmlspecialchars($lastname) . '"'; } ?> class="input-xlarge">
        <?php if ($missing && in_array('lastname', $missing)) {
                        echo '<div class="text-danger">Please enter your Last name</div>';} 
						else {
							echo '<p class="help-block">Please enter your Last Name</p>';
						}?> 
      </div>
    </div>
    <div class="control-group">
      <!-- Username -->
      <label class="control-label"  for="username">Username</label>
      <div class="controls">
        <input type="text" id="username" name="username" <?php if (isset($username)) { echo 'value="' . htmlspecialchars($username) . '"'; } ?> class="input-xlarge">
        <?php if ($missing && in_array('username', $missing)) {
                        echo '<div class="text-danger">Please enter a username</div>';} 
						else {
							echo '<p class="help-block">Please enter your username</p>';
						}?> 
      </div>
    </div>
 
    <div class="control-group">
      <!-- E-mail -->
      <label class="control-label" for="email">E-mail</label>
      <div class="controls">
        <input type="text" id="email" name="email" <?php if (isset($email)) { echo 'value="' . htmlspecialchars($email) . '"'; } ?> class="input-xlarge">
        <?php if ($missing && in_array('email', $missing)) {
                        echo '<div class="text-danger">Please enter a valid email</div>';} 
						else {
							echo '<p class="help-block">Please enter your email</p>';
						}?> 
      </div>
    </div>
 
    <div class="control-group">
      <!-- Password-->
      <label class="control-label" for="password">Password</label>
      <div class="controls">
        <input type="password" id="password" name="password" class="input-xlarge">
        <?php if ($missing && in_array('password', $missing)) {
					if ($password != $password_confirm){
						echo '<div class="text-danger">Please make sure your password matches </div>';}
					else{
						echo '<div class="text-danger">Please make sure your password is longer than 3 characters</div>';
					}
				}
			else {
				echo '<p class="help-block">Password should be at least 4 characters long</p>';}?> 
      </div>
    </div>
    <div class="control-group">
      <!-- Password -->
      <label class="control-label"  for="password_confirm">Password (Confirm)</label>
      <div class="controls">
        <input type="password" id="password_confirm" name="password_confirm" class="input-xlarge">
        <p class="help-block">Please confirm password</p>
      </div>
    </div>
	<div class="control-group">
      <!-- PhoneNumber -->
      <label class="control-label"  for="phonenumber">PhoneNumber (Optional)</label>
      <div class="controls">
        <input type="text" id="phonenumber" name="phonenumber" class="input-xlarge">
        <p class="help-block">Optional phone number</p>
      </div>
    </div>
 
    <div class="control-group">
      <!-- Button -->
      <div class="controls">
        <button class="btn btn-success" name="send" type="submit" value="Send message">Register</button>
      </div>
    </div>
  </fieldset>
  </form>
<?php include './includes/footer.php'; ?>