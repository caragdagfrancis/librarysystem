<?php
	require_once 'connection.php';
	$q_adminname = $link->query("SELECT * FROM `admin` WHERE `admin_id` = '$_SESSION[loggedin]'") or die(mysqli_error());
	$f_adminname = $q_adminname->fetch_array();
	$admin_name = $f_adminname['firstname']." ".$f_adminname['lastname'];