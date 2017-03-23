<?php
	session_start();
	if ((!isset($_SESSION['userName']))){
		header('Location: login.php');
	}
	// Check if the form has been submitted:
	if (isset($_POST['submit'])) {
	// Check for an uploaded file:
	if (isset($_FILES['upload'])) {
		// Validate the type. Should be JPEG or PNG.
		$allowed = array ('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png');
		if (in_array($_FILES['upload']['type'], $allowed)) {
			// Move the file over.
			$folder = $_SESSION['folder'];
			$name=$_FILES['upload']['name'];
			$type=$_FILES['upload']['type'];
			$path = "../uploads/".$folder."/".$name;
			if (move_uploaded_file ($_FILES['upload']['tmp_name'], $path)){
				require_once ('../pdo_config.php');
				$sql = "INSERT into insta_user_images (userName, imageName, imageType) VALUES (:userName, :imageName, :imageType)";
				$stmt= $conn->prepare($sql);
				$stmt->bindValue(':userName', $_SESSION['userName']);
				$stmt->bindValue(':imageName', $name);
				$stmt->bindValue(':imageType', $type);
				$success = $stmt->execute();
				include './includes/header.php';
				echo '<h2>The file '.$_FILES['upload']['name'].' has been uploaded!</h2>';	
				include './includes/footer.php'; 
				// Delete the file if it still exists:
				if (file_exists ($_FILES['upload']['tmp_name']) && is_file($_FILES['upload']['tmp_name'])) {
					unlink ($_FILES['upload']['tmp_name']);
				}
				exit;
			} // End of move... IF.		
		} else { // Invalid type.
			echo '<h2 class="warning">Please upload a JPEG or PNG image.</h2>';
			}	
	} // End of isset($_FILES['upload']) IF.
	
	// Check for an error:
	if ($_FILES['upload']['error'] > 0) {
		echo '<p class="warning">The file could not be uploaded because: <strong>';
		// Print a message based upon the error.
		switch ($_FILES['upload']['error']) {
			case 1:
				echo 'The file exceeds the upload_max_filesize setting in php.ini.';
				break;
			case 2:
				echo 'The file exceeds the MAX_FILE_SIZE setting in the HTML form.';
				break;
			case 3:
				echo 'The file was only partially uploaded.';
				break;
			case 4:
				echo 'No file was uploaded.';
				break;
			case 6:
				echo 'No temporary folder was available.';
				break;
			case 7:
				echo 'Unable to write to the disk.';
				break;
			case 8:
				echo 'File upload stopped.';
				break;
			default:
				echo 'A system error occurred.';
				break;
		} // End of switch.
		echo '</strong></p>';
	
	} // End of error IF.
			
} // End of the submitted conditional.
include './includes/header.php';
?>
<div class="container">
	<div class="form-group row">
	<h2>Upload an image</h2>
	<form enctype="multipart/form-data" action="upload_img.php" method="post">
		<input type="hidden" name="MAX_FILE_SIZE" value="2097152">
		<fieldset>
			<legend>Select a JPEG or PNG image of 2M or smaller to be uploaded:</legend>
			<label for="file">
			File:<input type="file" name="upload" id="file"></label>
			<label for = "submit">And press
			<input type="submit" name="submit" value="Submit" id="submit"></label>
		</fieldset>
	</form>
	</div>
	</div>
<?php include './includes/footer.php'; ?>