<?php
session_start();
if (isset($_SESSION['userName'])){
	include 'https.php';
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>InstaCopy</title>
    <link href="css/bootstrap.css" rel="stylesheet">
  </head>
  <body>
  <?php if (isset($_SESSION['userName'])){?>
      <nav class="navbar navbar-default">
			<ul class="nav navbar-nav">
				<li><a href="./index.php">InstaCopy</a></li>
				<li><a href="./index.php">Home</a></li>
				<li><a href="./upload_img.php">Upload Images</a></li>
				<li><a href="./find_users.php">Find Users</a></li>
            </ul>
		<ul class="nav navbar-nav navbar-right">
              <li><a href="./logout.php">Log Out</a></li>
			  <li><a href="./view_page.php">Your Page</a></li>
            </ul>
		</nav>
		<?php } 
		else{ ?>
			<nav class="navbar navbar-default">
				<ul class="nav navbar-nav">
					<li><a href="./index.php">InstaCopy</a></li>
					<li><a href="./index.php">Home</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="./login.php">Log In</a></li>
					<li><a href="./registration.php">Sign Up</a></li>
				</ul>
			</nav>
		<?php } ?>
	  <div class="jumbotron text-center" role="main">