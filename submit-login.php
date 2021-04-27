<?php
	session_start(); 
	include 'connect.php';

	if (isset($_POST['submit'])) {
		
		$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
		$pswd = mysqli_real_escape_string($conn, $_POST['pswd']);

		$sql = "SELECT * FROM user WHERE user_id = '$user_id'";
		$response = mysqli_query($conn, $sql);
		$checkRows = mysqli_num_rows($response);

		if ($checkRows < 1) {
			header("Location: index.php?login=error");
		}
		else{
			while ($rows = mysqli_fetch_assoc($response)) {
				
				if (password_verify($pswd, $rows['password'])) {
					
					if ($rows['user_status'] == 0) {
						$_SESSION['user_id'] = $rows['user_id'];
						header("Location: user/today-menu.php");
					}
					elseif ($rows['user_status'] == 1) {
						
						$_SESSION['user_id'] = $rows['user_id'];
						header("Location: admin/index.php");
					}
				}
				else{
					header("Location: index.php?login=error");
				}
			}
		}

	}
	else{
		header("Location: index.php");
	}

 ?>