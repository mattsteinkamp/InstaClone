<?php 
session_start();
if (isset($_POST['send'])) {
	$user = trim(filter_input(INPUT_POST, 'search', FILTER_SANITIZE_STRING));
	require_once ('../pdo_config.php'); // Connect to the db.
	$sql = 'SELECT userName FROM insta_reg_users WHERE userName LIKE ? '; //using like so they don't have to be an exact match
	$stmt= $conn->prepare($sql);
	$stmt->bindValue(1, "%$user%", PDO::PARAM_STR);
	$stmt->execute();
	$errorInfo = $stmt->errorInfo();
	if (isset($errorInfo[2])){
		echo $errorInfo[2];
		exit;
	}
	else {
		require "includes/header.php";?>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div id="custom-search-input">
						<div class="input-group col-md-12">
						<form method="post">
							<input type="text" id="search" name="search" class="form-control input" placeholder="Search Users" />
							<span class="input-group-btn">
								<button type="submit" class="btn btn-info btn" name="send">
									<i class="glyphicon glyphicon-search"></i>
								</button>
							</span>
							</form>
						</div>
					</div>
				</div>
			<form action="view_page.php" action="post">
			<div class="col-md-6">
			
		<?php
		$rows = $stmt->rowCount();
			if ($rows==0) {
				echo '<p>No Matches</p>';
			}
			else{
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				foreach ($results as $result){
					?>
					<button type="submit" name="user" value=<?php echo $result['userName'];?> class="btn-link"><?php echo $result['userName'];?></button>
					<?php
					}
					?>
				</div>
				</form>
			</div>
		</div>
			<?php
			}
	}
}
else{
	require "includes/header.php";
	?>
<form method="post">
<div class="container">
	<div class="row">
        <div class="col-md-6">
            <div id="custom-search-input">
                <div class="input-group col-md-12">
                    <input type="text" id="search" name="search" class="form-control input" placeholder="Search Users" />
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info btn" name="send">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
	</div>
</div>
</form>
<?php 
	include "includes/footer.php";
	}
?>
