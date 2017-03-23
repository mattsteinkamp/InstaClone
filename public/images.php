<?php require 'includes/header.php'; ?>
<main>
	<p>Click on an image to view it in a separate window.</p>
	<ul>
	<?php 	// This script lists the images in the uploads directory.
	if ((!isset($_SESSION['firstName']))){
		echo "You need to login first";
	else{
		$folder = $_SESSION['folder']
		$dir = '../../uploads'.$folder; // Define the directory to view.
		$files = scandir($dir); // Read all the images into an array.

	// Display each image caption as a link 
		foreach ($files as $image) {
			if (substr($image, 0, 1) != '.') { // Ignore anything starting with a period.
			// Get the image's size in pixels:
				$image_size = getimagesize ("$dir/$image");

			// Make the image's name URL-safe:
				$image_name = urlencode($image);
			
			// Print the information:
				echo "<li><a href=\"show_image.php?image=".$image."\">".$image."</a></li>\n";
			
			} // End of the IF.
		}
	}// End of the foreach loop.
	?>
	</ul>
</main>
<?php include './includes/footer.php'; ?>