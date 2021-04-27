<?php
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header("Location: ../index.php");
	}
	include '../connect.php';
?>
<!DOCTYPE html>
<html>
<head>

	<title>User</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<script src="../jquery-3.6.0.js"></script>
	<script src="../js/bootstrap.min.js"></script>

	<style>
		.navbar ul li a {
			color: black;
			font-size: 15px;
			padding: 8px;
		}
		.navbar ul li a:hover {
			color: white;
			margin-left: 20px;
			transition: 0.5s;	
		}
		.navbar ul li:hover{
			background-color: #001a33;
			color: white;
			transition: 0.5s;
		}
		.navbar ul li {
			margin-top: 10px;
		}
		#nav_column {
			height: 100vh;
			margin-left: 15px;

		}
		input[type='password']{
			width: 35%;
		}	

		button:hover {
			box-shadow: 5px 5px 5px grey;
			transition: 0.6s;
		}
		.form-group label {
			text-align: right;
		}
		body {
			font-family: 'Trebuchet MS', Helvetica, sans-serif;
			background-color: #F5F5F5;
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<ul class="nav" style="height: 100px; background-color: #001a33;">
			<li class="nav-item col-md-9 col-lg-10" style="margin-top: 45px;">
				
				<h4 style="font-weight: bolder; font-family: 'Trebuchet MS', Helvetica, sans-serif";><a href="index.php" style="color: white;" class="nav-link"><img src="../imgs/burger.png" style="margin-top: -10px;"> What are you eating today ?</a></h4>
			</li>
			<li class="nav-item col-md-2 col-lg-2" style="margin-top: 60px;">  
				<img src="../imgs/user.png" style="margin-top: -5px;">
				<label style="color: white; font-size: 13px; margin-left: 5px;">
					<?php 
						$user_id = $_SESSION['user_id']; 
						$sql_query = "SELECT * FROM user WHERE user_id = '$user_id';";
						$query_exec = mysqli_query($conn, $sql_query); 
						while ($rows_query = mysqli_fetch_assoc($query_exec)) {
							echo($rows_query['first_name'])." ".$rows_query['last_name'];
						}
					 ?>
				</label>
			</li>
		</ul>
		<div class="row">
			<div class="col-md-4 col-lg-3" id="nav_column">
			<nav class="navbar" style="margin-top: 80px;">
				<ul class="navbar-nav w-100">
					<li class="nav-item"> 
						<a href="index.php" class="nav-link"><img src="../imgs/order.png"> LUNCH MENU </a>
					</li>
					<li class="nav-item">
						<a href="add-menu.php" class="nav-link"><img src="../imgs/add_menu.png"> ADD MENU</a>
					</li>
					<li class="nav-item">
						<a href="orders.php" class="nav-link"><img src="../imgs/orders.png"> LUNCH ORDERS</a>
					</li>
					<li class="nav-item">
						<a href="my-orders.php" class="nav-link"><img src="../imgs/lunch.png"> MY ORDER</a>
					</li>
					<li class="nav-item">
						<a href="change-pswd.php" class="nav-link"><img src="../imgs/setup.png"> CHANGE PASSWORD</a>
					</li>
					<li class="nav-item">
						<a href="../logout.php" class="nav-link"><img src="../imgs/exit.png"> LOGOUT</a>
					</li>
				</ul>				
			</nav>
		</div>
		<div class="col-md-7 col-lg-8">
			<form action="submit-change-pswd.php" method="POST">
			<div class="row p-4">
				<div class="col-md-11 col-lg-11" style="margin-top: 40px; border-bottom: 1px solid gray; ">
					<h4><b>Set new password</b></h4>
				</div>

				<!-- Section to display success message -->
				<div class="col-lg-11" style="margin-top: 20px;">
					<?php 
						if (isset($_GET['chng'])) {
							if ($_GET['chng'] == "ok") {
								echo '<div class="alert alert-success col-lg-7" role="alert">
										  <strong>Your password has been changed..! <button type="button" class="close" data-dismiss="alert">&times;</button></strong> 
										</div>';
							}
							elseif ($_GET['chng'] == "error") {
								echo '<div class="alert alert-danger col-lg-7" role="alert">
										  <strong>Incorrect password..! <button type="button" class="close" data-dismiss="alert">&times;</button></strong> 
										</div>';
							}
						}
					 ?>
				</div>

		<div class="col justify-content-center" style="margin-top: 20px;">
			  <div class="form-group">
			    <label>Current password</label><br>
			    <input type="password" name="current_pswd" id="current_pswd" required>
			  </div>
			  <div class="form-group">
			    <label> New password</label><br>
			    <input type="password" name="new_pswd" id="new_pswd" required>
			  </div>
			  <div class="form-group">
			    <label>Confirm password</label><br>
			    <input type="password" name="confirm_pswd" id="confirm_pswd" required>
			    <label id="pswd_error" style="color: red; font-size: 14px; display: none;">Password does not match..!</label>
			  </div>
			<button class="btn btn-info" id="btn" type="submit" name="submit" style="margin-top: 20px; width: 37%;">Change password</button>
		</div>
		    </div>
			</form>
		</div>	
		</div>
	</div>
</body>
</html>

<script>
	$(document).ready(function () {

		$('#confirm_pswd').keyup(function () {
			var newPswd = $('#new_pswd').val(); 
			var confirmPswd = $('#confirm_pswd').val(); 

			if (newPswd != confirmPswd) {
				$('#btn').prop('disabled',true);
				$('#pswd_error').css('display','inline');
			}
			else if(newPswd == confirmPswd){
				$('#btn').prop('disabled',false);
				$('#pswd_error').css('display','none');
			}
			// else if ((newPswd = "") || (confirmPswd = "")) {
			// 	$('#btn').prop('disabled',true);
			// 	$('#pswd_error').css('display','none');
			// }
		});
	});
</script>
