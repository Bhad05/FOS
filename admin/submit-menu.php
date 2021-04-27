<?php 
	session_start();
	include '../connect.php';

	$count_chakula = count($_POST['chakula']);
	$count_mboga = count($_POST['mboga']);
	$food_date = $_POST['food_date'];
	$user_id = $_SESSION['user_id'];

	//Coverting date
	$new_food_date = date("y-m-d", strtotime($food_date));

	if ($count_chakula > 0 && $count_mboga > 0 ) {

		for ($i=0; $i < $count_chakula ; $i++) { 

			// if (trim($_POST['chakula'][$i] =! "")) {
			// 	echo($_POST['chakula'][$i]);
			// }
			$menu_type_id = 1;
			$chakula = $_POST['chakula'][$i];

			$sql = "INSERT INTO menu(menu_name,menu_type_id,user_id,menu_date) VALUES('$chakula','$menu_type_id','$user_id','$new_food_date')";
			$query = mysqli_query($conn,$sql);
		}
		
		for ($i=0; $i < $count_mboga; $i++) {
			$menu_typeID = 2;
			$mboga = $_POST['mboga'][$i];

			$sql_mboga = "INSERT INTO menu(menu_name,menu_type_id,user_id,menu_date) VALUES('$mboga','$menu_typeID','$user_id','$new_food_date')";
			$query_mboga = mysqli_query($conn,$sql_mboga);
		}
		if ($query == true && $query_mboga == true) {
				header("Location: add-menu.php?menu_add=ok");
			}
			else {
				header("Location: add-menu.php?menu_add=error");
		}
	}
	else {

		echo "Enter food";		
	}
 ?>