<?php
	session_start();
	include 'Notifications/notifications.php';
	include 'Config/database.php';
	
	if (!isset($_SESSION['username']))
	{
		Header("Location: index.php");
		return;
	}
	
	if(!isset($_GET['username']))
	{
		Header("Location: home.php?page=1");
		return;
	}
	
	$profile_username = $_GET['username'];
	
	$sql = "use matcha";
	$connection->exec($sql);
	
	$stmt = $connection->prepare("SELECT * FROM registered_users WHERE username = :username");
	$stmt->execute(array(':username' => $profile_username));
	$result = $stmt->fetch(PDO::FETCH_ASSOC);

	if(!empty($result))
	{
		$user_profile_name = $result['name'];
		$user_profile_middlename = $result['middle_name'];
		$user_profile_surname = $result['surname'];
		$user_profile_username = $result['username'];
		$user_profile_gender = $result['gender'];
		$user_profile_gender_pref = $result['LOOKIN_AT_GENDER'];
		$user_profile_age = $result['age'];
		$user_profile_age_pref = $result['LOOKIN_AT_AGES'];
		$user_profile_ethnicity = $result['ethnicity'];
		$user_profile_ethnicity_pref = $result['LOOKIN_AT_ETHNICITY'];
		$user_profile_email = $result['email'];
		$user_profile_bio = $result['biography'];
		$user_profile_likes = $result['I_LIKE'];
		$user_profile_user_likes = $result['likes'];
		$user_profile_fame_rating = $result['fame_rating'];
		$user_profile_active_pic_number = $result['active_profile_pic'];
		$user_profile_active_pic = $result['profile_pic_' . $result['active_profile_pic']];
		$profile_pic_1 = $result['profile_pic_1'];
		$profile_pic_2 = $result['profile_pic_2'];
		$profile_pic_3 = $result['profile_pic_3'];
		$profile_pic_4 = $result['profile_pic_4'];
		$profile_pic_5 = $result['profile_pic_5'];
	}
	
	CheckForMessages();
?>