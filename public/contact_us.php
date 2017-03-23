<?php //This page checks for required content, errors, and provides sticky output
	require './includes/header.php';
	if (isset($_GET['send'])) {
	//step 2: Determine if name or email is missing and report
	$missing = array();
	$errors = array();
	
	$name = trim(filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING)); //returns a string
	if (empty($name)) 
		$missing[]='name';
	
	$valid_email = trim(filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL));	//returns a string or null if empty or false if not valid	
	if (trim($_GET['email']==''))
		$missing[] = 'email';
	elseif (!$valid_email)
		$errors[] = 'email';
	else $email = $valid_email;
		
			
	$comments = trim(filter_input(INPUT_GET, 'comments')); //returns a string
	if (empty($comments)) 
		$missing[]='comments';
	else $comments = nl2br($comments, false); //Use <br> tags rather than <br />
	
	$subscribe = filter_input(INPUT_GET, 'subscribe');	
	if ($subscribe !== 'yes' && $subscribe !== 'no') 
		$missing[]='subscribe';
		
	//$checked = array("");
	$checked=filter_input(INPUT_GET, 'interests', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
	if (empty($checked))
		$missing[] = 'interests';
		
	$howhear = filter_input(INPUT_GET, 'howhear');
	if (empty($howhear))
			$missing[] = 'howhear';
		
	$accepted = filter_input(INPUT_GET, 'terms');
	if (empty($accepted) || $accepted !='accepted')
		$missing[] = 'accepted';
	
	if (!$missing && !$errors) {
		//Split name into first, last
		$tempName = explode(" ",$name);
		//separates a string based on the first argument, creates an array of strings
		$firstName= $tempName[0];
		if (!empty($tempName[1])) {
			$lastName = $tempName[1];
		} 
		else {
			$lastName = null;
			}
		if ($subscribe == "yes"){
			$subscribe = 1;
			}
		else {
			$subscribe = 0;
		}
		$interests = implode(",", $checked);
		require_once ('../pdo_config.php'); // Connect to the db.
		$sql = $conn->prepare("INSERT into JJ_contacts (firstName, lastName, emailAddr, comments, newsletter, howHear, interests)
		VALUES (:firstName,:lastName,:email,:comments,:subscribe,:howhear,:interests)");
		$sql->bindParam(':firstName', $firstName);
		$sql->bindParam(':lastName', $lastName);
		$sql->bindParam(':email', $email);
		$sql->bindParam(':comments', $comments);
		$sql->bindParam(':subscribe', $subscribe);
		$sql->bindParam(':howhear', $howhear);
		$sql->bindParam(':interests', $interests);
		if($sql->execute())
			echo '<main><h2>Thank you for contacting us</h2><h3>We have saved your information</h3></main>';
		else{
			echo '<main><h2>We are sorry but we were unable to process your<br> request at this time.</h2></main>';
			}
	exit;
	}
	}
?>

	<main>
        <h2>Japan Journey</h2>
        <p>Ut enim ad minim veniam, quis nostrud exercitation consectetur adipisicing elit. Velit esse cillum dolore ullamco laboris nisi in reprehenderit in voluptate. Mollit anim id est laborum. Sunt in culpa duis aute irure dolor excepteur sint occaecat.</p>
        <form method="get" action="contact_us.php">
			<fieldset>
				<legend>Contact Us</legend>
				<?php if ($missing || $errors) { ?>
				<p class="warning">Please fix the item(s) indicated.</p>
				<?php } ?>
            <p>
                <label for="name">Name: 
				<?php if ($missing && in_array('name', $missing)) { ?>
                        <span class="warning">Please enter your name</span>
                    <?php } ?> </label>
                <input name="name" id="name" type="text"
				 <?php if (isset($name)) {
                    echo 'value="' . htmlspecialchars($name) . '"'; } ?>
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
                    echo 'value="' . htmlspecialchars($email) . '"'; } 
					?> >
            </p>
			<p>
                <label for="comments">Comments: 
				<?php if ($missing && in_array('comments', $missing)) { ?>
                        <span class="warning">Please enter a comment</span>
                    <?php } ?> 
				</label>
                <textarea name="comments" id="comments">
				 <?php if (isset($comments)) {
                    echo htmlspecialchars($comments); } ?>
				</textarea>
            </p>

            <fieldset id="subscribe">
                <h2>Subscribe to newsletter?
				<?php if ($missing && in_array('subscribe', $missing)) { ?>
                        <span class="warning">Please Make a Selection</span>
                    <?php } ?>
					</h2>
                <p>
				
                    <input name="subscribe" type="radio" value="yes" id="subscribe-yes"
						<?php if ($subscribe=='yes'){
						echo 'checked="checked"';}?>
					>
                    <label for="subscribe-yes">Yes</label>
                    <input name="subscribe" type="radio" value="no" id="subscribe-no"
						<?php if ($subscribe=='no'){
						echo 'checked="checked"';}?>
					>
                    <label for="subscribe-no">No</label>
                </p>
            </fieldset>
            <fieldset id="interests">
                <h2>Interests in Japan
					<?php if ($missing && in_array('interests', $missing)) { ?>
                        <span class="warning">Select at least 1 Interest</span>
                    <?php } ?>
				</h2>
                <div>
                    <p>
                        <input type="checkbox" name="interests[]" id="anime" value="anime"
								<?php if (isset($_GET['send'])) {
										foreach ($checked as $value){
											if ($value=="anime"){
												echo 'checked="checked"';
												}
											} 
										}?>

						>
                        <label for="anime">Anime/manga</label>
                    </p>
                    <p>
                        <input type="checkbox" name="interests[]" id="art" value="arts"
									<?php if (isset($_GET['send'])) {
										foreach ($checked as $value){
											if ($value=="arts"){
												echo 'checked="checked"';
												}
											} 
										}?>

						>
                        <label for="art">Arts &amp; crafts</label>
                    </p>
                    <p>
                        <input type="checkbox" name="interests[]" id="judo" value="judo"
									<?php if (isset($_GET['send'])) {
										foreach ($checked as $value){
											if ($value=="judo"){
												echo 'checked="checked"';
												}
											} 
										}?>

						
						>
                        <label for="judo">Judo, karate, etc</label>
                    </p>
                </div>
                <div>
                    <p>
                        <input type="checkbox" name="interests[]" id="lang_lit" value="lang"
									<?php if (isset($_GET['send'])) {
										foreach ($checked as $value){
											if ($value=="lang"){
												echo 'checked="checked"';
												}
											} 
										}?>

						>
                        <label for="lang_lit">Language/literature</label>
                    </p>
                    <p>
                        <input type="checkbox" name="interests[]" id="scitech" value="scitech"
									<?php if (isset($_GET['send'])) {
										foreach ($checked as $value){
											if ($value=="scitech"){
												echo 'checked="checked"';
												}
											} 
										}?>

						>
                        <label for="scitech">Science &amp; technology</label>
                    </p>
                    <p>
                        <input type="checkbox" name="interests[]" id="travel" value="travel"
									<?php if (isset($_GET['send'])) {
										foreach ($checked as $value){
											if ($value=="travel"){
												echo 'checked="checked"';
												}
											} 
										}?>

						>
                        <label for="travel">Travel</label>
                    </p>
                </div>
            </fieldset>
            <p>
                <label for="howhear">How did you hear of Japan Journey? 
					<?php if ($missing && in_array('howhear', $missing)) { ?>
                        <span class="warning">Please Make a Selection</span>
                    <?php } ?>
					</label>
				
                <select name="howhear" id="howhear">
                    <option value="">Select one</option>
                    <option value="apress" <?php if ($howhear=='apress'){
						echo 'selected="selected"';}?>
					>Apress</option>
                    <option value="friend"<?php if ($howhear=='friend'){
						echo 'selected="selected"';}?>
					>Recommended by a friend</option>
                    <option value="search_eng"	<?php if ($howhear=='search_eng'){
						echo 'selected="selected"';}?>
					>Search engine</option>
                </select>
            </p>
            <p>
			
                <input type="checkbox" name="terms" value="accepted" id="terms" 
					<?php if ($accepted =="accepted"){
						echo 'checked="checked">';?>
						<?php } ?>
                <label for="terms">I accept the terms of using this website</label>
					<?php if ($missing && in_array('accepted', $missing)) { ?>
                        <span class="warning">Please Accept the Terms of Service for this Site</span>
                    <?php } ?>
            </p>
            <p>
                <input name="send" type="submit" value="Send message">
            </p>
		</fieldset>
        </form>
	</main>
<?php include './includes/footer.php'; ?>
