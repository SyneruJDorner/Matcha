<?php
	session_start();
	
	if(isset($_POST['action']) && !empty($_POST['action']))
	{
		$action = $_POST['action'];
		send_usermsg($_POST['arguments']['args']);



		//Notifiy User
		$user = $_POST['arguments']['chatting_to_user'];

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

		$sql = "use matcha";
		$stmt = $connection->prepare($sql);
		$stmt->execute();

		$stmt = $connection->prepare("SELECT * FROM registered_users WHERE username = :username");
		$stmt->execute(array(':username' => $user));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$user_notifications = $result["notifications"];

		$user_notifications_arr = explode(", ",  $user_notifications);
		$user_notifications_arr = array_filter($user_notifications_arr, function($value) { return $value !== ''; });
		$user_notifications_arr = array_filter($user_notifications_arr, function($value) { return $value !== null; });

		if (!in_array($_SESSION['username'] . " has messaged you.", $user_notifications_arr))
			array_push($user_notifications_arr, $_SESSION['username'] . " has messaged you.");
		$user_notifications = implode(", ", $user_notifications_arr);
		$stmt = $connection->prepare("UPDATE registered_users SET notifications=:notifications WHERE username=:username");
		$stmt->execute(array(':notifications' => $user_notifications, ':username' => $user));
	}
	
	function send_usermsg($args)
	{
		$items = explode(", ", $args);
		$user = $items[0];
		$text = $items[1];
		$file_path = $items[2];
		
		$fp = fopen($file_path, 'a');
		fwrite($fp, "ö~~$~~ö date=" . date("g:i A") . "$~~ö~~$ user=" . $user . "$~~ö~~$ text=".stripslashes(htmlspecialchars($text)) . ";" . "\r\n");
		fclose($fp);
	}
?>