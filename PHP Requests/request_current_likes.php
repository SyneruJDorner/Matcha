<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	if(isset($_POST['action']) && !empty($_POST['action']))
	{
		$action = $_POST['action'];
		$args = isset($_POST['arguments']) ? $_POST['arguments'] : "";
		request_current_likes($args);
	}
	
	function request_current_likes($args)
	{
		$connection;
		$dbname = 'matcha';
		$username = 'Test';
		$password = "Password1234";

		$options = [
					PDO::MYSQL_ATTR_FOUND_ROWS => true,
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
				   ]; 
		$connection = new PDO("mysql:host=localhost", $username, $password, $options);//array(PDO::MYSQL_ATTR_FOUND_ROWS => true);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		$stmt = $connection->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =:dbname");
		$stmt->execute(array(":dbname"=>$dbname));
		
		$username = $_SESSION['username'];
		
		$sql = "use matcha";
		$connection->exec($sql);
		
		$stmt = $connection->prepare("SELECT * FROM registered_users WHERE username = :username");
		$stmt->execute(array(':username' => $username));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if(!empty($result))
			echo $result['I_LIKE'];
	}
?>