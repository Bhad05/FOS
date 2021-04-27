<?php 
	session_start();
	include '../connect.php';

	if (isset($_POST['submit'])) {
		
		$id = $_SESSION['user_id'];
		$pswd = $_POST['current_pswd'];
		$new_pswd = $_POST['confirm_pswd'];

		$sql = "SELECT * FROM user WHERE user_id = '$id';";
		$query = mysqli_query($conn,$sql);

		$count_rows = mysqli_num_rows($query);
		if ($count_rows < 1) { 
			header("Location: change-pswd.php?chng=error");
		}
		else {
			while ($row = mysqli_fetch_assoc($query)) {   
				if (password_verify($pswd, $row['password'])) {

					$hashed_pswd = password_hash($new_pswd, PASSWORD_DEFAULT);
					$sql1 = "UPDATE user SET password = '$hashed_pswd' WHERE user_id = '$id';";
					$run_query = mysqli_query($conn,$sql1);

					if ($run_query == true) { 
						header("Location: change-pswd.php?chng=ok");
					}
					else { 
						header("Location: change-pswd.php?chng=error"); 
					}
				}
				else{
					header("Location: change-pswd.php?chng=error");
				}
			}
		}
	}
	else {
		header("Location: change-pswd.php");
		exit();
	}
 ?>