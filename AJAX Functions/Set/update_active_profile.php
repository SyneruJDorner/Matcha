<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	if(isset($_POST['action']) && !empty($_POST['action']))
	{
		$action = $_POST['action'];
		$args = isset($_POST['arguments']) ? $_POST['arguments'] : "";
		update_profile_image($args);
	}
	
	function update_profile_image($args)
	{
		include '../../Config/database.php';
		$username = $_SESSION['username'];
		
		$sql = "use matcha";
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		
		$args = str_replace("profile_picture_", "", $args);
		$sql = "UPDATE registered_users SET active_profile_pic=:args WHERE username=:username";
		$stmt = $connection->prepare($sql);
		$stmt->execute(array(':args' => $args, ':username' => $username));
		
		$sql = "SELECT * FROM registered_users WHERE username = :username";
		$stmt = $connection->prepare($sql);
        $stmt->execute(array(':username' => $username));
		
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
        if(!empty($result))
        {
			$active_profile_pic = $result['active_profile_pic'];
			$profile_pic = $result['profile_pic_' . $args];
			
			if ($profile_pic == null)
			{
				echo 'http://localhost/Matcha/UI/Default.png';
			}
			else
			{
				if(preg_match('#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si', $profile_pic) === false)
					echo 'data:image/jpg;';

				echo $profile_pic;
			}
		}
	}
?>