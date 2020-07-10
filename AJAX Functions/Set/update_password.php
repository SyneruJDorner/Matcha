<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	if(isset($_POST['action']) && !empty($_POST['action']))
	{
		$action = $_POST['action'];
		$args = isset($_POST['arguments']) ? $_POST['arguments'] : "";
		update_password($args);
	}
	
	function update_password($args)
	{
		include '../../Config/database.php';
		
		$sql = "use matcha";
		$stmt = $connection->prepare($sql);
		$stmt->execute();

		$username = $_SESSION['username'];
		$database_pass = hash("sha512", $args);

		$sql = "UPDATE registered_users SET password=:args WHERE username=:username";
		$stmt = $connection->prepare($sql);
		$stmt->execute(array(':args' => $database_pass, ':username' => $username));
	}
?>