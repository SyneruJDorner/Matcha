<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	if(isset($_POST['action']) && !empty($_POST['action']))
	{
		$action = $_POST['action'];
        $args = isset($_POST['arguments']) ? $_POST['arguments'] : "";

        echo $args['like'];
        echo $args['username'];

        if ($args['like'] == -1)
            update_like_username($args['username']);
        else if ($args['like'] == 1)
            update_unlike_username($args['username']);
	}
    
    function update_like_username($args)
	{
        include '../../Config/database.php';
        $username = $_SESSION['username'];
        
		$sql = "use matcha";
		$stmt = $connection->prepare($sql);
		$stmt->execute();

        $stmt = $connection->prepare("SELECT * FROM registered_users WHERE username = :username");
        $stmt->execute(array(':username' => $_SESSION['username']));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(!empty($result))
            $user_profile_likes = $result['likes'];

        $user_likes_array = explode(", ", $user_profile_likes);

        if (in_array($args, $user_likes_array) == false)
        {
            array_push($user_likes_array, $args);
        }

        $trimmedArray = array_filter($user_likes_array);
        $newUserLikeString = implode(", ", $trimmedArray);

		$sql = "UPDATE registered_users SET likes=:args WHERE username=:username";
		$stmt = $connection->prepare($sql);
        $stmt->execute(array(':args' => $newUserLikeString, ':username' => $username));
        



        //Fame Rating
        $stmt = $connection->prepare("SELECT * FROM registered_users WHERE username=:username");
        $stmt->execute(array(':username' => $args));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $fame_rating = $result["fame_rating"];
        if ($fame_rating == null)
            $fame_rating = 0;

        $fame_rating += 1;
        $stmt = $connection->prepare("UPDATE registered_users SET fame_rating=:fame_rating WHERE username=:username");
        $stmt->execute(array(':fame_rating' => $fame_rating, ':username' => $args));



        //Notifiy User
        $stmt = $connection->prepare("SELECT * FROM registered_users WHERE username = :username");
        $stmt->execute(array(':username' => $args));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_notifications = $result["notifications"];

        $user_notifications_arr = explode(", ",  $user_notifications);
        $user_notifications_arr = array_filter($user_notifications_arr, function($value) { return $value !== ''; });
        $user_notifications_arr = array_filter($user_notifications_arr, function($value) { return $value !== null; });
        if (!in_array($username . " has liked you.", $user_notifications_arr))
            array_push($user_notifications_arr, $username . " has liked you.");
        $user_notifications = implode(", ", $user_notifications_arr);
        $stmt = $connection->prepare("UPDATE registered_users SET notifications=:notifications WHERE username=:username");
        $stmt->execute(array(':notifications' => $user_notifications, ':username' => $args));
	}
    
	function update_unlike_username($args)
	{
		include '../../Config/database.php';
        $username = $_SESSION['username'];
        
		$sql = "use matcha";
		$stmt = $connection->prepare($sql);
		$stmt->execute();

        $stmt = $connection->prepare("SELECT * FROM registered_users WHERE username = :username");
        $stmt->execute(array(':username' => $_SESSION['username']));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(!empty($result))
            $user_profile_likes = $result['likes'];

        $user_likes_array = explode(", ", $user_profile_likes);
        $index = array_search($args, $user_likes_array);
        if($index !== FALSE)
            unset($user_likes_array[$index]);

        $trimmedArray = array_filter($user_likes_array);
        $newUserLikeString = implode(", ", $trimmedArray);

		$sql = "UPDATE registered_users SET likes=:args WHERE username=:username";
		$stmt = $connection->prepare($sql);
        $stmt->execute(array(':args' => $newUserLikeString, ':username' => $username));
        
        //Fame Rating
        $stmt = $connection->prepare("SELECT * FROM registered_users WHERE username=:username");
        $stmt->execute(array(':username' => $args));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $fame_rating = $result["fame_rating"];
        if ($fame_rating == null)
            $fame_rating = 0;

        $fame_rating -= 1;
        $stmt = $connection->prepare("UPDATE registered_users SET fame_rating=:fame_rating WHERE username=:username");
        $stmt->execute(array(':fame_rating' => $fame_rating, ':username' => $args));
        

        //Notifiy User
        $stmt = $connection->prepare("SELECT * FROM registered_users WHERE username = :username");
        $stmt->execute(array(':username' => $args));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_notifications = $result["notifications"];

        $user_notifications_arr = explode(", ",  $user_notifications);
        $user_notifications_arr = array_filter($user_notifications_arr, function($value) { return $value !== ''; });
        $user_notifications_arr = array_filter($user_notifications_arr, function($value) { return $value !== null; });

        if (!in_array($username . " has unliked you.", $user_notifications_arr))
            array_push($user_notifications_arr, $username . " has unliked you.");
        $user_notifications = implode(", ", $user_notifications_arr);
        $stmt = $connection->prepare("UPDATE registered_users SET notifications=:notifications WHERE username=:username");
        $stmt->execute(array(':notifications' => $user_notifications, ':username' => $args));
	}
?>