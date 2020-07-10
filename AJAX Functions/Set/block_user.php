<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	if(isset($_POST['action']) && !empty($_POST['action']))
	{
		$action = $_POST['action'];
        $args = isset($_POST['arguments']) ? $_POST['arguments'] : "";
        $block_user_info = $args['block_user_info'];
        //print_r($reported_user);
        $blocking_user_info = $args['blocking_user_info'];
        //print_r($user_requesting);
		block_user($block_user_info, $blocking_user_info);
	}

    function block_user($block_user_info, $blocking_user_info)
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

        $stmt = $connection->prepare("SELECT * FROM registered_users WHERE username=:username");
		$stmt->execute(array(':username' => $blocking_user_info[0]));
		$result = $stmt->fetchAll();
        
        $blocked_str		= $result[0]['block_list'];
        $blocked_list       = explode(", ", $blocked_str);
        array_push($blocked_list, $block_user_info[0]);
        $result = array_filter($blocked_list);  
        $blocked_str        = implode(", ", $result);

		$stmt = $connection->prepare("UPDATE registered_users SET block_list=:blocked_users WHERE username=:username");
		$stmt->execute(array(':blocked_users' => $blocked_str, ':username' => $blocking_user_info[0]));



        //Fame Rating
        $stmt = $connection->prepare("SELECT * FROM registered_users WHERE username = :username");
        $stmt->execute(array(':username' => $block_user_info[0]));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $fame_rating = $result["fame_rating"];
        if ($fame_rating == null)
            $fame_rating = 0;

        $fame_rating -= 1;
        $stmt = $connection->prepare("UPDATE registered_users SET fame_rating=:fame_rating WHERE username=:username");
        $stmt->execute(array(':fame_rating' => $fame_rating, ':username' => $block_user_info[0]));


        //Notifiy User
        $stmt = $connection->prepare("SELECT * FROM registered_users WHERE username = :username");
        $stmt->execute(array(':username' => $block_user_info[0]));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_notifications = $result["notifications"];

        $user_notifications_arr = explode(", ",  $user_notifications);
        $user_notifications_arr = array_filter($user_notifications_arr, function($value) { return $value !== ''; });
        $user_notifications_arr = array_filter($user_notifications_arr, function($value) { return $value !== null; });

        if (!in_array($blocking_user_info[0] . " has blocked you.", $user_notifications_arr))
            array_push($user_notifications_arr, $blocking_user_info[0] . " has blocked you.");
        $user_notifications = implode(", ", $user_notifications_arr);
        $stmt = $connection->prepare("UPDATE registered_users SET notifications=:notifications WHERE username=:username");
        $stmt->execute(array(':notifications' => $user_notifications, ':username' => $block_user_info[0]));

        echo "Return Home";
    }
    return;
?>