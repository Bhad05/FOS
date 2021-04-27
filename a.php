<?php 
	include 'connect.php';

	$hashedPwd = password_hash("chid", PASSWORD_DEFAULT);

	$sql = "INSERT INTO user(user_id,first_name,last_name,phone,email,password,user_status,dept_id) VALUES('Chid123','Benga','Chid',0657247301,'amukri@kpmg.co.tz','$hashedPwd',0,2)";

	$result = mysqli_query($conn,$sql);
	if ($result == true) {
		echo "OK";
	}
	else{
		echo "Error";
	}

 ?>