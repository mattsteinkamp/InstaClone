<?php 
	require 'secure_conn.php';
	require_once '../../pdo_config.php';
	require 'includes/header.php'; 
?>
<main><?php 
	if (!$_SESSION['payment']) { 
        echo '<h2>We were unable to process your payment.</h2>';
		echo '<h3>Please try again later</h3>';
	} elseif (isset($_SESSION['email']) && !empty($_SESSION['email']) && $_SESSION['payment']) {
		$email = $_SESSION['email'];
		date_default_timezone_set("America/New_York");
		$orderDate = date("Y-m-d");
		$total = $_SESSION['total'];
				
		//insert data into JJ_orders table
		$qry1 = "INSERT INTO JJ_orders (customerEmail, orderDate, total) VALUES (:email, :date, :total)";
		$stmt1= $conn->prepare($qry1);
		$stmt1->bindValue(':email',$email);
		$stmt1->bindValue(':date',$orderDate);
		$stmt1->bindValue(':total',$total);
		$stmt1->execute();
		$errorInfo = $stmt1->errorInfo();
		if (isset($errorInfo[2])){
			echo $errorInfo[2];
			// or echo '<main><h2>We are sorry but we were unable to process your<br> request at this time.</h2></main>';
			exit;
		}else{ //Orders table updated successfully.  Now update order_details
			$orderID = $conn->lastInsertID(); //retrieves the autonum assigned 
			$cart = $_SESSION['cart'];
			//initialize any unset values
			$itemNum=1;
			$qry2 = "INSERT INTO JJ_order_details values (:item, :orderID, :imageID, :qty, :price)";
			$stmt2 = $conn->prepare($qry2);
			foreach($cart as $img => $item) { //retrieve the cart variables from the session
				$imageID = $img;
				$qty = $item['quantity'];
				$price = $item['price'];
				$stmt2->bindValue(':item', $itemNum);
			$stmt2->bindValue(':orderID', $orderID);
			$stmt2->bindValue(':imageID', $imageID);
			$stmt2->bindValue(':qty', $qty);
			$stmt2->bindValue(':price', $price);
				$stmt2->execute();
				$errorInfo = $stmt2->errorInfo();
				if (isset($errorInfo[2])){
					echo $errorInfo[2];
					// or echo '<main><h2>We are sorry but we were unable to process your<br> request at this time.</h2></main>';
					exit;
				}
				$itemNum++;
			} //foreach
		} //else orders table successful
		?>
			<main>
			<h2>Your order is complete. A summary is below:</h2>
				<?php
				echo "<h3>Order number: $orderID</h3>";
				echo "<h3>Order date: $orderDate</h3>";
				echo "<h3>Order Total: $".$total."</h3>";
				echo "<h3>Order details: </h3>";
				echo "</main>";
				include 'includes/footer.php';
				exit;
		} //first elseif
	else
		echo "You havae reached this page in error."
	?>	
</main>
<?php include 'includes/footer.php'; ?>