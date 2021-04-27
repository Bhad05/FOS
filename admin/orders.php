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

	<title>Orders</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../datatables/datatables.min.css">
	<link rel="stylesheet" type="text/css" href="../datatables/buttons/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="../jquery-ui.css">
	<script src="../jquery-3.6.0.js"></script>
	<script src="../jquery-ui.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../datatables/jquery.dataTables.min.js"></script>
	<script src="../datatables/buttons/js/dataTables.buttons.min.js"></script>
	<script src="../datatables/buttons/js/buttons.html5.min.js"></script>
	<script src="../datatables/buttons/js/buttons.print.min.js"></script>
	<script src="../datatables/jszip.min.js"></script>
	<script src="../datatables/pdfmake.min.js"></script>
	<!-- <script src="../datatables/pdfmake.min.js.map"></script> -->
	<script src="../datatables/vfs_fonts.js"></script>
<!-- 	<script src="../datatables/datatables.min.js"></script> -->
	
	
	

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
		table {
			font-size: 14px;
			line-height: 12px;
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
			<div class="col-md-3 col-lg-3" id="nav_column">
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
		<div class="col-md-9 col-lg-8">
			<form action="submit-menu.php" method="POST">
			<div class="row">
				<div class="col-md-9 col-lg-8" style="margin-top: 60px; border-bottom: 1px solid gray; ">
					<h4><b>Lunch orders</b></h4>
				</div>
				<div class="col-md-3 col-lg-2" style="margin-top: 60px;">
					<button type="button" class="btn btn-info" id="print_btn" onclick="print_orders();">Print Orders</button>
				</div>
				<div class="col-lg-10" style="margin-top: 40px;" id="orders_div">
					<table class="table table-striped" id="orders_table">
						<thead>
							<tr><th>NO</th>
							<th>NAME</th>
							<th>FOOD</th></tr>
						</thead>
						<tbody>
							<?php  
								$no = 1;
								$today = date('Y-m-d');
								$sql = "SELECT orders.*,user.user_id,user.first_name,user.last_name FROM orders INNER JOIN user ON orders.user_id = user.user_id WHERE DATE(order_date) = '$today';";
								$res = mysqli_query($conn, $sql);
								
								$sql2 = "SELECT * FROM menu WHERE menu_date = '$today';"; 
								$response = mysqli_query($conn,$sql2);
								//print_r($response);

								while ($rows = mysqli_fetch_assoc($res)) {
									echo "<tr>
											<td>".$no."</td>
											<td>".$rows['first_name']." ".$rows['last_name']."</td>
											<td>".$rows['chakula']." ".$rows['mboga']."</td>
										  </tr>";
									$no++;
								}
							 ?>
						</tbody>
					</table>
			    </div>
		    </div>
			</form>
		</div>	
		</div>
	</div>
</body>
</html>

<script>
	//Printing f(x)
	// function print_orders() {
	// 	var div_to_print = document.getElementById('orders_div');
	// 	var new_window = window.open('','print-window');

	// 	new_window.document.open();
	// 	new_window.document.write('<html><body onload = "window.print()">' + div_to_print.innerHTML + '</body></html>');
	// 	new_window.document.close();

	// 	setTimeout(function () {
	// 		new_window.close();
	// 	},10);
	// }

	//creating data table buttons
	// $('#orders_table').DataTable({
	// 	buttons: ['copy','excel','pdf']
	// });
	//dis[laying buttons
	$(document).ready(function () {
		var table = $('#orders_table').DataTable({
					dom: 'Bfrtip',
					buttons: ['excel','pdf']
					//You can also add copy and print buttons
				});

	table.buttons()
	.container().appendTo($('col-sm-6:eq(0)',table.table().container()));
	})
</script>

