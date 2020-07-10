<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	if(isset($_POST['action']) && !empty($_POST['action']))
	{
		$action = $_POST['action'];
		$args = isset($_POST['arguments']) ? $_POST['arguments'] : "";
		addNewHashtagToDatabase($args);
	}
	
	function addNewHashtagToDatabase($Hashtag)
	{
		include '../../Config/database.php';
		
		$sql = "use matcha";
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		
		if (strlen($Hashtag) < 1)
			return;
		
		$sql = "SELECT * FROM Hashtags WHERE Hashtag=:Hashtag";
		$stmt = $connection->prepare($sql);
		$stmt->execute(array(':Hashtag' => "#" . $Hashtag));
		
        if ($stmt->rowCount() >= 1)
			return;
		
		$sql = "INSERT IGNORE INTO Hashtags (Hashtag) VALUES (:Hashtag)";
		$stmt = $connection->prepare($sql);
		$stmt->execute(array(':Hashtag' => "#" . $Hashtag));
	}
?>