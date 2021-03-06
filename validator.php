<?php
	session_start();
	if(!ISSET($_SESSION['admin_id'])){
		header('location: login.php');
	}