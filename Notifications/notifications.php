<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	function CheckForMessages()
	{
		if(isset($_SESSION['message']))
		{
			$message = $_SESSION['message'];
			echo "<script>";
				echo "alert('" . $message . "');";
			echo "</script>";
			$_SESSION['message'] = null;
		}
	}
?>