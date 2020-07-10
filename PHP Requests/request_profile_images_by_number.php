<?php
	function get_image_at_position($image_pos)
	{
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
		
		if ($image_pos >= 1 && $image_pos <= 5)
		{
			$found_image = $row['profile_pic_' . $image_pos];

			if ($found_image == null)
			{
				echo '\''."http://localhost/Matcha/UI/Default.png".'\'';
			}
			else
			{
				$file_string = "";
				
				if(preg_match('#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si', $found_image) === false)
					$file_string = 'data:image/jpg;';
				
				echo '\'' . $file_string . $found_image . '\'';
			}
		}
		else
			echo '\''."http://localhost/Matcha/UI/Default.png".'\'';
	}
?>