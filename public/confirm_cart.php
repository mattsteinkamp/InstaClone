<?php 
	session_start();
	if (empty($_SESSION['cart']) || !isset($_SESSION['cart'])) { 
        echo '<h2>There are no products in your cart.</h2>';
		echo '<h3>Please use the Purchase Prints link to the left to shop.</h3>';
	}
	else { ?>
		<table>
		  <tr id="cart_header">
			<th class="left">Image</th>
			<th class="right">Price</th>
			<th class="right">Quantity</th>
			<th class="right">Total</th>
		  </tr>
		  <?php foreach($_SESSION['cart'] as $img => $item){	?>
		  <!--Print the row: -->
		  <tr>
			<td><?php echo $item['caption']; ?></td>
			<td class="right">$<?php echo $item['price']; ?></td>
			<td class="right"><?php echo $item['quantity'];?>
			</td>
			<?php 
			// Calculate the total and sub-totals.
			if (!isset ($item['quantity']))
				$item['quantity']=0;
			$subtotal = $item['quantity'] * $item['price'];
			$total += $subtotal;?>
			<td class="right">$<?php echo number_format($subtotal, 2); ?></td>
		  </tr>
	<?php 
	} // End of the foreach loop.?> 
	<!-- Print the total, close the table, and the form:-->
		<tr id="cart_footer">
			<td class="right" colspan="3"><strong>Total:</strong></td>
			<td class="right"><strong>$<?php echo number_format($total, 2);?></strong></td>
		</tr>
		<?php $_SESSION['total']=$total; ?>
	</table>
	<a href = "checkout_payment.php">Proceed to payment</a>
	<?php }
	?>