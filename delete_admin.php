<?php
	require_once 'connection.php';
	$link->query("DELETE FROM `admin` WHERE `admin_id` = '$_REQUEST[loggedin]'") or die(mysqli_error());
	header('location:process.php');