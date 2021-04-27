<?php 
	session_start();
	include '../connect.php';

	$user_id = $_SESSION['user_id']; 
	
	//print_r($order_items);
	if (isset($_POST['submit'])) {

		if ($_POST['chakula'] =="" || $_POST['mboga'] =="") {
			header("Location: today-menu.php?order=error");
		}
		else{

			$chakula_id = $_POST['chakula'];
			$mboga_id = $_POST['mboga'];

			$get_chakula = "SELECT menu_name FROM menu where menu_id = '$chakula_id';";
			$sql_chakula = mysqli_query($conn,$get_chakula);
			
			while ($rows_chakula = mysqli_fetch_assoc($sql_chakula)) {
				$chakula = $rows_chakula['menu_name'];
			}

			$get_mboga = "SELECT menu_name FROM menu where menu_id = '$mboga_id';";
			$sql_mboga = mysqli_query($conn,$get_mboga);
			
			while ($rows_mboga = mysqli_fetch_assoc($sql_mboga)) {
				$mboga = $rows_mboga['menu_name'];
			}

			$sql = "INSERT INTO orders(user_id,chakula,mboga) VALUES('$user_id','$chakula','$mboga')";

			$query = mysqli_query($conn, $sql);

			if ($query == true) {
				header("Location: today-menu.php?order=ok");
			}
			else{
				header("Location: today-menu.php?order=error");
			}
		}
	}
	else {
		echo "Data is not received";
	}
 ?>