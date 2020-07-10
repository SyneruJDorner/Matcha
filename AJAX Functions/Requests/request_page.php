<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	if(isset($_POST['action']) && !empty($_POST['action']))
	{
		$action = $_POST['action'];
		$args = isset($_POST['arguments']) ? $_POST['arguments'] : "";
		headToPage($args);
	}
	
	function headToPage($args)
	{
		if ($args == "HOME")
		{
			header("location: ../../home.php");
		}
	}
?>