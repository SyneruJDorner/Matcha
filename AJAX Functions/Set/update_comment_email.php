<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	if(isset($_POST['action']) && !empty($_POST['action']))
	{
		$action = $_POST['action'];
		$args = isset($_POST['arguments']) ? $_POST['arguments'] : "";
		update_gender($args);
	}
	
	function update_gender($args)
	{
		include '../../Config/database.php';
		
		$sql = "use matcha";
		$stmt = $connection->prepare($sql);
		$stmt->execute();

		$username = $_SESSION['username'];

		$sql = "UPDATE registered_users SET comment_email=:args WHERE username=:username";
		$stmt = $connection->prepare($sql);
		$stmt->execute(array(':args' => $args, ':username' => $username));
		$_SESSION['comment_email'] = $args;
	}
?>