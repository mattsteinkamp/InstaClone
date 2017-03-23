<?php
session_start();
	//make sure only the admin can can use these functions
	if ($_SESSION['email'] == "admin@admin.com"){
		//the code to change a phone number
		if (isset($_POST['userName']) && isset($_POST['phonenumber'])){
			$userName = trim(filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_STRING));
			$phonenumber = trim(filter_input(INPUT_POST, 'phonenumber', FILTER_SANITIZE_STRING));
			require_once ('../pdo_config.php');
			$sql = "UPDATE insta_reg_users SET phonenumber = :phonenumber WHERE userName = :userName ";
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':phonenumber',$phonenumber);
			$stmt->bindValue(':userName',$userName);
			$stmt->execute();
			$errorInfo = $stmt->errorInfo();
			if (isset($errorInfo[2])){
				echo $errorInfo[2];
				exit;
			}
			echo "Change Successful" ;
			echo"</br>";
			}
		//the code to delete a user
		elseif (isset($_POST['userNameDelete']) && isset($_POST['userNameConfirm'])){
			if ($_POST['userNameDelete'] == $_POST['userNameConfirm']){
				$userNameConfirm = trim(filter_input(INPUT_POST, 'userNameConfirm', FILTER_SANITIZE_STRING));
				$userNameDelete = trim(filter_input(INPUT_POST, 'userNameDelete', FILTER_SANITIZE_STRING));
				require_once ('../pdo_config.php');
				$sql = "DELETE FROM insta_reg_users WHERE userName=:userName; DELETE FROM insta_user_images WHERE userName=:userNameConfirm";
				$stmt = $conn->prepare($sql);
				$stmt->bindValue(':userName',$userNameConfirm);
				$stmt->bindValue(':userNameConfirm',$userNameConfirm);
				$stmt->execute();
				$errorInfo = $stmt->errorInfo();
				if (isset($errorInfo[2])){
					echo $errorInfo[2];
					exit;
				}
				echo "Change Successful" ;
				echo"</br>";
				}
			}
		
		else{}
	}
	// if they are not the admin move them to login screen
	else{
		header('Location: login.php');
	}
require "includes/header.php";
?>
Update PhoneNumbers
		<form method="post">
			UserName
			<input type="text" id="userName"  name="userName"><br>
			New PhoneNumber
			<input type="text" id="phonenumber" name="phonenumber"><br>
			<button type="submit" class="btn btn-default"> Change Number</button>
		</form>
		</br>
		</br>
Delete User
		<form method="post">
			UserName
			<input type="text" id="userNameDelete"  name="userNameDelete"><br>
			Confirm UserName
			<input type="text" id="userNameConfirm"  name="userNameConfirm"><br>
			<button type="submit" class="btn btn-default"> Delete User</button>
		</form>
<?php include './includes/footer.php'; ?>