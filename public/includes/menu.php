	<?php $currentPage = basename($_SERVER['SCRIPT_FILENAME']); ?>
	<ul id="nav">
        <li><a href="index.php" <?php if ($currentPage == 'index.php') {echo 'id="here"'; } ?>>Home</a></li>
        <li><a href="blog.php" <?php if ($currentPage == 'blog.php') {echo 'id="here"'; } ?>>Blog</a></li>
        <li><a href="gallery.php" <?php if ($currentPage == 'gallery.php') {echo 'id="here"'; } ?>>Gallery</a></li>
        <li><a href="contact_us.php" <?php if ($currentPage == 'contact_us.php') {echo 'id="here"'; } ?>>Contact</a></li>
		<li><a href="login.php" <?php if ($currentPage == 'login.php') {echo 'id="here"'; } ?>>Login</a></li>
		<li><a href="create_acct.php" <?php if ($currentPage == 'create_acct.php') {echo 'id="here"'; } ?>>Register</a></li>
	<?php if (isset($_SESSION['email'])){ ?>
		<li><a href="show_image.php" <?php if ($currentPage == 'show_image.php') {echo 'id="here"'; } ?>>View Images</a></li>
		<li><a href="logout.php" <?php if ($currentPage == 'logout.php') {echo 'id="here"'; } ?>>Logout</a></li>
		<li><a href="upload_image.php" <?php if ($currentPage == 'upload_image.php') {echo 'id="here"'; } ?>>Upload Images</a></li>
    </ul>
	<?php } ?>