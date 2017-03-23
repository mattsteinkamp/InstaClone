<?php
if (isset($_POST['size'])){
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Order Pizza</title>
</head>
<?php
	if (isset($_POST['name'])){
		$name = trim(filter_input(INPUT_POST, 'name'));
		echo "The Name of the Orderer is ".$name;
		echo "</br>";
		}
	else{
		echo "No name was inputed";
		echo "</br>";
	}
	if (isset($_POST['size'])){
		if ($_POST['size'] == 1){
			echo "They want a Small Pizza";
			echo "</br>";
		}
		elseif ($_POST['size'] == 2){
			echo "They want a Medium Pizza";
			echo "</br>";
		}
		else{
			echo "They want a Large Pizza";
			echo "</br>";
		}
	}
	else{
		echo "No pizza size was selected";
	}
	if (isset($_POST['cheese'])){
		if ($_POST['cheese'] == 1){
			echo "They want Light Cheese";
			echo "</br>";
		}
		else{
			echo "They want Extra Cheese";
			echo "</br>";
		}
	}
	else{
		echo "They want neither extra cheese or light cheese";
		echo "</br>";
	}
	if (isset($_POST['topping'])){
		$toppings = $_POST['topping'];
		foreach ($toppings as $item){
			echo "They want Pizza with ".$item;
			echo "</br>";
		}
	}
	else{
		echo "No toppings";
		}

}
else{
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Order Pizza</title>
</head>
<body>
  	<form method="post" action="processFl.php">
        <h3>Seahawk Pizza</h3>
        <hr>
        <fieldset>
          <legend>Personal Information</legend>
          Name <input type = "text" id="name" name="name"><br>
        </fieldset>
        <fieldset>
          <legend>Pizza order</legend>
          <select name="size">
            <option>Select Pizza Size</option>
            <option value="1">Small</option>
            <option value="2">Medium</option>
            <option value="3">Large</option>
          </select>
        </fieldset>
        <fieldset>
          <legend>Cheeses</legend>
          <input type="radio" name="cheese" value="1">Light cheese
          <input type="radio" name="cheese" value="2">Extra cheese
        </fieldset>
        
		<fieldset>
          <legend>Choose Toppings - $1.79 Each</legend>
            <input type="checkbox" name="topping[]" value=
			"Pepperoni"> Pepperoni<br>
            <input type="checkbox" name="topping[]" value="Olives"> Olives<br>
            <input type="checkbox" name="topping[]" value="Peppers"> Peppers<br>
            <input type="checkbox" name="topping[]" value="Mushrooms"> Mushrooms<br>
        </fieldset>
        <input type="submit" value="PLACE YOUR ORDER">
        <input type="reset" value="START OVER">
  </form>
</body>
</html>
<?php
}
?>