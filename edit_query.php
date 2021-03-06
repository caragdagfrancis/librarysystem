<?php
	require_once 'connection.php';
	$username = $_POST['username'];
	$password = $_POST['password'];
	$firstname = $_POST['firstname'];
	$middlename = $_POST['middlename'];
	$lastname = $_POST['lastname'];
	$q_checkadmin = $link->query("SELECT * FROM `admin` WHERE `username` = '$username'") or die(mysqli_error());
		$v_checkadmin = $q_checkadmin->num_rows;
		if($v_checkadmin == 1){
			echo '
				<script type = "text/javascript">
					alert("Username already taken");
					window.location = "process.php";
				</script>
			';
		}else{
			$link->query("UPDATE `admin` SET `username` = '$username', `password` = '$password', `firstname` = '$firstname', `middlename` = '$middlename', `lastname` = '$lastname' WHERE `admin_id` = '$_REQUEST[loggedin]'") or die(mysqli_error());
			echo '
				<script type = "text/javascript">
					alert("Successfully Edited");
					window.location = "process.php";
				</script>
			';
		}	