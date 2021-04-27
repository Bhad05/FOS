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

	<title>Admin</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../datatables/datatables.min.css">
	<script src="../jquery-3.6.0.js"></script>
	<script src="../datatables/datatables.min.js"></script>
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
		input[type='checkbox']{
			font-size: 18px;
			margin-right: 10px;
		}	
		.checkbox label {
			padding-right: 20px;	
		}
		button:hover {
			box-shadow: 5px 5px 5px grey;
			transition: 0.6s;
		}
		ul li img{
			margin-top: -5px;
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
			<div class="col-xs-4 col-md-4 col-lg-3" id="nav_column">
			<nav class="navbar">
				<ul class="navbar-nav w-100" style="margin-top: 80px;">
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
		<div class="col-xs-8 col-md-8 col-lg-8 p-4">
			<form action="submit-order.php" method="POST">
			<div class="row">
				<div class="col-md-10 col-lg-10" style="margin-top: 60px; border-bottom: 1px solid gray; ">
					<h4><b>Order your lunch</b></h4>
				</div>

				<!-- Section to display success message -->
				<div class="col-md-11 col-lg-11" style="margin-top: 20px;">
					<?php 
						if (isset($_GET['order'])) {
							if ($_GET['order'] == "ok") {
								echo '<div class="alert alert-success col-lg-7" role="alert">
										  <strong>Your lunch order has been placed..! <button type="button" class="close" data-dismiss="alert">&times;</button></strong> 
										</div>';
							}
							elseif ($_GET['order'] == "error") {
								echo '<div class="alert alert-danger col-lg-7" role="alert">
										  <strong>Oopss..! Your lunch order was not placed <button type="button" class="close" data-dismiss="alert">&times;</button></strong> 
										</div>';
							}
						}
					 ?>
				</div>

				<!-- Get menu from DB -->
				<div class="col-md-5 col-lg-3" style="margin-top: 40px;">
				<?php 
						$today = date("Y-m-d");
						$sql = 'SELECT * FROM menu WHERE menu_type_id = 1 AND menu_date = "'.$today.'"';
						$result = mysqli_query($conn, $sql);
						
						while ($rows = mysqli_fetch_assoc($result)) {
						echo    '<div class="checkbox">
								<label><input type="checkbox" class="check1" name="chakula" value="'.$rows['menu_id'].'">'.$rows['menu_name'].'</label>
								</div>
								';
						}
					 ?>

					<!--  Select only one choice -->
					<script>
						$(document).ready(function () {
							$('.check1').on('change',function () {
								$('.check1').not(this).prop('checked',false);
							});
						});
					</script>
			    </div>
		    <div class="col-md-5 col-lg-3" style="margin-top: 40px;">
			<?php  
					$today = date("Y-m-d");
					$sql1 = 'SELECT * FROM menu WHERE menu_type_id = 2 AND menu_date = "'.$today.'"';
					$result1 = mysqli_query($conn, $sql1);
					
					while ($rows1 = mysqli_fetch_assoc($result1)) {
					
					echo    '<div class="checkbox">
							<label><input type="checkbox" name="mboga" class="check2" value="'.$rows1['menu_id'].'">'.$rows1['menu_name'].'</label>
							</div>
							';
					}
				 ?>
				</div>

				<script>
					$(document).ready(function () {
						$('.check2').on('change',function () {
							$('.check2').not(this).prop('checked',false);
						});
					});
				</script>
				<div class="col-lg-11" style="margin-top: 60px; ">
					<button class="btn btn-success" id="btn" type="submit" name="submit"> SUBMIT MY ORDER</button>
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
		var time = new Date();
		var hour = time.getHours(); 

		if (hour > 7) {	
			$('#btn').prop('disabled',true);
		}
	});
</script>