<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();

	function GetHashTagsFromDatabase()
	{
		include 'Config/database.php';
		
		$sql = "use matcha";
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		
		$sql = "SELECT * FROM Hashtags";
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		
		$result = $stmt->fetchAll();
		$phpArray = array();
		
		for($i = 0; $i < count($result); $i++)
		{
			$ID 		= $result[$i]['ID'];
			$Hashtag 	= $result[$i]['Hashtag'];
			array_push($phpArray, $Hashtag);
		}
		
		return ($phpArray);
	}
?>