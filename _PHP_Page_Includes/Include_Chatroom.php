<?php
	session_start();
	include '../Online_User_Tracking/Online_User_Tracking.php';

	if(!isset($_GET['user_chat']))
	{
		Header("location: ../home.php?page=1");
		return;
	}

	if (!isset($_SESSION['username']))
	{
		Header("Location: ../index.php");
		return;
	}
	
	$user_chat = $_GET['user_chat'];
	$current_user = $_SESSION['username'];
?>