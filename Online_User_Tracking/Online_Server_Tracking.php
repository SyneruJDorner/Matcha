<?php
    if (session_status() == PHP_SESSION_NONE)
        session_start();
        
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

    $currentTime = date('Y-m-d H:i:s');
    $username = $_SESSION['username'];

    $sql = "UPDATE registered_users SET online_status=:currentTime WHERE username=:username";
    $stmt = $connection->prepare($sql);
    $stmt->execute(array(':currentTime' => $currentTime, ':username' => $username));
?>