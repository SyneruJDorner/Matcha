<?php
	session_start();
	include 'Notifications/notifications.php';
	include 'Config/database.php';
	
	if (!isset($_SESSION['username']))
	{
		Header("Location: index.php");
		return;
	}
	
	include 'AJAX Functions/Get/include_all_gets.php';
	$phpArray = GetHashTagsFromDatabase();
	
	session_login($connection);
	
	function session_login($connection)
	{
		$username = $_SESSION['username'];
		
		$sql = "use matcha";
        $connection->exec($sql);
        
        $stmt = $connection->prepare("SELECT * FROM registered_users WHERE username = :username");
        $stmt->execute(array(':username' => $username));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty($result))
        {
			$_SESSION['name'] = $result['name'];
			$_SESSION['middle_name'] = $result['middle_name'];
			$_SESSION['surname'] = $result['surname'];
			$_SESSION['username'] = $result['username'];
			$_SESSION['email'] = $result['email'];
			$_SESSION['first_time_login'] = $result['first_time_login'];

			if (isset($_SESSION["first_time_login_completed"]))
				if ($_SESSION["first_time_login_completed"] == "1")
					$_SESSION['first_time_login'] = "0";
			if ($_SESSION['first_time_login'] == "1")
			{
				header("location: first_time_login.php");
				return;
			}
		}
	}

	CheckForMessages();
?>