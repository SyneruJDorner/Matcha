<?php
    if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	if(isset($_POST['action']) && !empty($_POST['action']))
	{
		$action = $_POST['action'];
		$args = isset($_POST['arguments']) ? $_POST['arguments'] : "";
		request_personal_notifications($args);
	}
	
	function request_personal_notifications($args)
	{
        //get string of notifications.
        //split the by special characters ", "
        //Store the most recent one.
        //Add the remaining ones back to the database.
	}
?>