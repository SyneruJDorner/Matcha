<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	if(isset($_POST['action']) && !empty($_POST['action']))
	{
		$action = $_POST['action'];
		$args = isset($_POST['arguments']) ? $_POST['arguments'] : "";
		upload_images($args);
	}
	
	function upload_images($args)
	{
		include '../../Config/database.php';
		
		$sql = "use matcha";
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		
		$profile_pic_1 = addslashes($args[0]);
		$profile_pic_2 = addslashes($args[1]);
		$profile_pic_3 = addslashes($args[2]);
		$profile_pic_4 = addslashes($args[3]);
		$profile_pic_5 = addslashes($args[4]);
		
		$sql = "UPDATE registered_users SET name=:name WHERE args=:args";
		
		insert_image_at_number(1, $profile_pic_1);
		insert_image_at_number(2, $profile_pic_2);
		insert_image_at_number(3, $profile_pic_3);
		insert_image_at_number(4, $profile_pic_4);
		insert_image_at_number(5, $profile_pic_5);
	}
	
	function insert_image_at_number($image_num, $set_variable)
	{
		include '../../Config/database.php';
		
		$sql = "use matcha";
		$stmt = $connection->prepare($sql);
		$stmt->execute();

		$username = $_SESSION['username'];
		$element = "profile_pic_" . $image_num;
		
		$sql = "UPDATE registered_users SET " . $element . "=:args WHERE username=:username";
		$stmt = $connection->prepare($sql);
		$stmt->execute(array(':args' => $set_variable, ':username' => $username));
	}
?>