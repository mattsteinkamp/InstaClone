<?php 
	require './includes/header.php';
	require_once '../../pdo_config.php';
	
	function shortTitle ($title){
		$title = substr($title, 0, -4);
		$title = str_replace('_', ' ', $title);
		$title = ucwords($title);
		return $title;
	}
	
	if (isset($_POST['image_id'])){
		$sql = "SELECT * FROM JJ_images WHERE image_id =".$_POST['image_id'];
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$errorInfo = $conn->errorInfo();
		if (isset($errorInfo[2])) {
			$error = $errorInfo[2];
			echo $error;
			exit;
		} else {
			$row = $stmt->fetch();
		}
	}
?>

<main>
<h2>Purchase: <?php echo shortTitle($row['filename']);?></h2>
<img src = "images/<?php echo $row['filename'];?>" alt="Japan Image">
<h4> Details :<?php echo $row['caption'];?> </h4>
<h4><?php echo $row['details'];?></h4>
<h4>Price : <?php echo $row['price'];?></h4>
<form action="cart_view.php" method="post">
	<input type="submit" value="Add to Cart" name="image_id" value="<?php echo $row['image_id']; ?>">
</form>
