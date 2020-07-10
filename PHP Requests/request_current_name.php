<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	function request_current_name()
	{
		include 'Config/database.php';
		$username = $_SESSION['username'];

		$sql = "use matcha";
		$connection->exec($sql);
		
		$stmt = $connection->prepare("SELECT * FROM registered_users WHERE username = :username");
		$stmt->execute(array(':username' => $username));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!empty($result))
			return $result['name'];
		return null;
	}
?>