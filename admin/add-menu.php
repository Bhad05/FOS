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
	<link rel="stylesheet" type="text/css" href="../jquery-ui.css">
	<script src="../jquery-3.6.0.js"></script>
	<script src="../jquery-ui.js"></script>
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
		button:hover {
			box-shadow: 5px 5px 5px grey;
			transition: 0.6s;
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
		<div class="col-md-8 col-lg-8 p-4">
			<form action="submit-menu.php" method="POST">
			<div class="row">
				<div class="col-lg-11" style="margin-top: 60px; border-bottom: 1px solid gray; ">
					<h4><b>Add today's menu</b></h4>
				</div>
				<div class="col-md-10 col-lg-10" style="margin-top: 30px;">
					<div class="form-group">
						<p>
							<strong>Pick date</strong><br>
							<input type="text" name="food_date" id="datepick" required style="margin-top: 10px;"> 
						</p>

						<script>
							$(function () {
								$('#datepick').datepicker();
							});
						</script>
					</div>
			    </div>
		    <div class="col-md-5 col-lg-5" style="margin-top: 20px;">
				<div class="form-group" id="chakula_field">
					<label for="Chakula"><strong>Chakula</strong></label><br>
					<input type="text" name="chakula[]" id="chkl" required>
					<button type="button" name="add" id="add" class="btn"><img src="../imgs/add.png"></button>
				</div>
			</div>
			<div class="col-md-5 col-lg-5" style="margin-top: 20px;">
				<div class="form-group" id="mboga_field">
					<label for="Mboga"><strong>Mboga</strong></label><br>
					<input type="text" name="mboga[]" id="mboga" required>
					<button type="button" name="add_mboga" id="add_mboga" class="btn"><img src="../imgs/add.png"></button>
				</div>
			</div>
			<div class="col-lg-11" style="margin-top: 30px;">
				<button class="btn btn-info" type="submit" name="submit" style="width: 200px;">Submit Menu</button>
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
		var j = 1;

		//Adding button
		$('#add').click(function () {
		j++;
		var chakula = document.getElementById('chkl').value
		$('#chakula_field').append('<div class="col-lg-12" id="row'+j+'" style="margin-top: 15px; margin-left: -15px;"><input type="text" name="chakula[]" required> <button type="button" name="remove" id="'+j+'" class="btn btn_remove"><img src="../imgs/cancel.png"></button></div>'); 
			});

			//Removing button
		$(document).on('click', '.btn_remove', function () {
				var div_id = $(this).attr('id'); //console.log(div_id);
				$("#row"+div_id+"").remove();
		  });

			//Adding mboga
		var i = 10;
			
		$('#add_mboga').click(function () {
			i++;
		$('#mboga_field').append('<div class="col-lg-12" id="row_mboga'+i+'" style="margin-top: 15px; margin-left: -15px;"><input type="text" name="mboga[]" required> <button type="button" name="remove_mboga" id="'+i+'" class="btn btn_remove"><img src="../imgs/cancel.png"></button></div>');
			});

			$(document).on('click', '.btn_remove', function () {
				var div_id = $(this).attr('id'); //console.log(div_id);
				$("#row_mboga"+div_id+"").remove();
		  });
		});
</script>