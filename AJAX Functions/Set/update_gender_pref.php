<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	if(isset($_POST['action']) && !empty($_POST['action']))
	{
		$action = $_POST['action'];
		$args = isset($_POST['arguments']) ? $_POST['arguments'] : "";
		update_gender_pref($args);
	}
	
	function update_gender_pref($args)
	{
		include '../../Config/database.php';
		
		$sql = "use matcha";
		$stmt = $connection->prepare($sql);
		$stmt->execute();

		$username = $_SESSION['username'];
		$args = strtolower($args);
		
		$sql = "UPDATE registered_users SET LOOKIN_AT_GENDER=:args WHERE username=:username";
		$stmt = $connection->prepare($sql);
		$stmt->execute(array(':args' => $args, ':username' => $username));
		$_SESSION['LOOKIN_AT_GENDER'] = $args;
	}
?>