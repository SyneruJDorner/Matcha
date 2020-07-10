<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	include '../Notifications/notifications.php';
	CheckForMessages();
	
	include '../Config/database.php';
	
	if($stmt->rowCount() < 1)
	{
		$_SESSION['message'] = "Login failed! Please register and account or enter the valid info to login!";
		header("location: ../index.php");
		return;
	}

	confirm_login_exists($connection);
	
	function confirm_login_exists($connection)
    {
        $username = $_POST['uname'];
        $pass = $_POST['psw'];
		
        $sql = "use matcha";
        $connection->exec($sql);
        
        $stmt = $connection->prepare("SELECT * FROM registered_users WHERE username = :username");
        $stmt->execute(array(':username' => $username));

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty($result))
        {
            if ($result['registered_account'] == 0)
            {
                $_SESSION['message'] = 'Your account has not been verified.';
                header("location: ../index.php");
				return;
            }

            $pass = stripslashes($pass);
            $pass = hash("sha512", $pass);

            if ($pass == $result['password'])
            {
				$_SESSION['username'] = $result['username'];
				header("location: ../home.php?page=1");
				return;
            }
            else
            {
                $_SESSION['message'] = 'Invalid password.';
                header("location: ../index.php");
				return;
            }
        }
        else
        {
            $_SESSION['message'] = "Login failed!";
            header("location: ../index.php");
            return;
        }
    }
?>