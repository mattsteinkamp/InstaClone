<?php 
	require 'secure_conn.php';
	require 'includes/header.php'; 
?>
<main>
    <?php if (empty($_SESSION['cart']) || !isset($_SESSION['cart'])) { 
        echo '<h2>There are no products in your cart.</h2>';
		echo '<h3>Please use the Purchase Prints link to the left to shop.</h3>';
	} elseif (empty($_SESSION['email']) || !isset($_SESSION['email'])) { //user is not logged in ?>
		<h3>If you are a registered user, please log in using the link at the left</h3>
		<h3>Or choose one of the other options below</h3>
		<h3><a href='create_acct.php'>Register as a new user</a> or <a href='checkout_view.php?guest=yes'>Continue checkout as a guest</a><h3>
	<?php } 
	else  { //user logged in
		$firstName = $_SESSION['firstName']; //set at login ?>	
		<h3>Hello <?php echo $firstName;?>,<br>
		<h3>Please choose one of the options below:</h3>
		<h3><a href='product_list.php'>Keep Shopping</a> or <a href="cart_view.php">View Cart</a> or <a href='checkout_view.php?guest=no'>Proceed to Checkout</a><h3>
	<?php } ?>
</main>
<?php include 'includes/footer.php'; ?>