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
		input[type='checkbox']{
			font-size: 18px;
			margin-right: 10px;
		}	
		.checkbox label {
			padding-right: 20px;	
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
		<div class="col-md-8 col-lg-8 p-4">
			<div class="row">
				<div class="col-md-9 col-lg-10" style="margin-top: 60px; border-bottom: 1px solid gray; ">
					<h4><b>Your today's lunch</b></h4>
				</div>
				<div class="col-lg-11" style="margin-top: 60px;">
					<?php  
						$id = $_SESSION['user_id'];
						$today = date('Y-m-d');
						$sql = "SELECT orders.*,user.user_id,user.first_name,user.last_name FROM orders INNER JOIN user ON orders.user_id = user.user_id WHERE DATE(order_date) = '$today' AND user.user_id = '$id' LIMIT 1;";
						$res = mysqli_query($conn, $sql);
									
						$sql2 = "SELECT * FROM menu WHERE menu_date = '$today';"; 
						$response = mysqli_query($conn,$sql2);

						while ($rows = mysqli_fetch_assoc($res)) {
								echo "<label style='height: 100px; width: 300px; padding: 40px; box-shadow: 5px 3px 5px 4px grey;'>".$rows['chakula']." ".$rows['mboga']."</label><br><br>";
								echo "<button class='btn btn-success' data-toggle='modal' data-target='#edit_modal' type='button' id='btn'>ANY CHANGES ?</button>";
							}

						?>
				</div>
		    </div>	
		</div>
	</div>


	<div id="edit_modal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-body">
	        <p>
	        	
	        </p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">&times;</button>
	      </div>
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
