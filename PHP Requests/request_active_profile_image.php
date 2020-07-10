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
	$stmt = $connection->prepare($sql);
	$stmt->execute();
	
	$username = $_SESSION['username'];
	$stmt = $connection->prepare("SELECT * FROM registered_users WHERE username=:username");
	$stmt->execute(array(':username' => $username));
	$row = $stmt->fetch();
	
	if ($row['active_profile_pic'] >= 1 && $row['active_profile_pic'] <= 5)
	{
		$file_string = "";
		
		if(preg_match('#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si', $row['profile_pic_' . $row['active_profile_pic']]) === false)
			$file_string = 'data:image/jpg;';
		
		if ($row['profile_pic_' . $row['active_profile_pic']] == null)
		{
			$_SESSION['active_profile_pic'] = "http://localhost/Matcha/UI/Default.png";
			$_SESSION['session_profile_image'] = "http://localhost/Matcha/UI/Default.png";
			echo "http://localhost/Matcha/UI/Default.png";
		}
		else
		{
			$ret_val = $file_string . $row['profile_pic_' . $row['active_profile_pic']];

			$_SESSION['active_profile_pic'] = $row['active_profile_pic'];
			$_SESSION['session_profile_image'] = $ret_val;
			echo $ret_val;
		}
	}
	else
		echo "http://localhost/Matcha/UI/Default.png";
?>