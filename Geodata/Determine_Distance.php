<?php
	if (session_status() == PHP_SESSION_NONE)
			session_start();

	function GetDistance($found_username)
	{
		//Save info
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
		$connection->exec($sql);

		$stmt = $connection->prepare("SELECT * FROM registered_users WHERE username = :username");
		$stmt->execute(array(':username' => $found_username));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		$found_user_lat = $result['latitude'];
		$found_user_long = $result['longitude'];

		$stmt = $connection->prepare("SELECT * FROM registered_users WHERE username = :username");
		$stmt->execute(array(':username' => $_SESSION['username']));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$_SESSION['lat'] = $result['latitude'];
		$_SESSION['lon'] = $result['longitude'];

		return distance($_SESSION['lat'], $_SESSION['lon'], $found_user_lat, $found_user_long);
	}

	function distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
	{
		$rad = M_PI / 180;
		//Calculate distance from latitude and longitude
		$theta = $longitudeFrom - $longitudeTo;
		$dist = sin($latitudeFrom * $rad) 
			* sin($latitudeTo * $rad) +  cos($latitudeFrom * $rad)
			* cos($latitudeTo * $rad) * cos($theta * $rad);

		return acos($dist) / $rad * 60 *  1.853;
	}
?>