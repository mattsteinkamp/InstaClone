<?php
	session_start();
	// the main site page used to view images
	//if the user got here by a search make sure that has first precedent
	if (isset($_GET['user'])) {
		$user= $_GET['user'];
	}
	//if they didnt get here by searching but they are logged in they want to view there own page
	elseif (isset($_SESSION['userName'])){
		$user = $_SESSION['userName'];
	}
	//if not logged in and didnt search redirect to home page
	else{
		header("Location: index.php");
	}
		require_once ('../pdo_config.php');
		//grab all img names from DB
		$sql = "SELECT imageName FROM insta_user_images WHERE userName = :userName";
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':userName', $user);
		$stmt->execute();
		$errorInfo = $stmt->errorInfo();
		if (isset($errorInfo[2])){
			echo $errorInfo[2];
			exit;
		}
		else {
			$rows = $stmt->rowCount();
			//no results mean no images to display
			if ($rows==0) {
				require 'includes/header.php';
				echo '<p>There are no Images to View</p>';
				include 'includes/footer.php';
			}
			else{
				//call the proxy script with the username of the person there search for and the image name
				require 'includes/header.php';
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				foreach ($results as $result){
					$path = $user."/".$result['imageName'];
					echo "<img src=\"file.php?img=$path\" alt=\"A image\"/>";
				}			
				include 'includes/footer.php';				
			}
	}

?>