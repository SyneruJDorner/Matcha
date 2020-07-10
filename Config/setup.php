<?php
	include 'database.php';
	
    if($stmt->rowCount() < 1)
        create_database($connection);

	#region functions
    function create_database($connection)
    {
		//include 'database.php';
		
        $sql = "CREATE DATABASE IF NOT EXISTS matcha";
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		
		$sql = "use matcha";
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		
		// Create table for matcha
        $sql = "CREATE TABLE registered_users (
            ID                  int(11) AUTO_INCREMENT PRIMARY KEY,
			name            	varchar(255) NOT NULL,
			middle_name         varchar(255) NOT NULL,
			surname            	varchar(255) NOT NULL,
            username            varchar(255) NOT NULL,
			gender            	varchar(255),
            age					DATETIME NOT NULL,
			ethnicity			varchar(255),
			email               varchar(255) NOT NULL,
            password            varchar(255) NOT NULL,
            confirmation_code   int(11),
            registered_account  int(11),
			first_time_login    int(11),
			biography           varchar(255),
			
			notifications       varchar(255),
            comment_email       int(11),
			chat_email       	int(11),
			like_email       	int(11),
			
			I_LIKE            	varchar(255),
			
			LOOKIN_AT_AGES      varchar(255),
			LOOKIN_AT_GENDER    varchar(255),
			LOOKIN_AT_ETHNICITY varchar(255),
			
			user_ip		 		varchar(255),
			online_status		varchar(255),
			latitude			float,
			longitude			float,
			country				varchar(255),
			regionName			varchar(255),
			city				varchar(255),

			fame_rating		 	int(11),
			likes				varchar(255),
			block_list			varchar(255),
			active_profile_pic  varchar(255),
            profile_pic_1       longblob,
			profile_pic_2       longblob,
			profile_pic_3       longblob,
			profile_pic_4       longblob,
			profile_pic_5       longblob)";
		
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		
		$sql = "CREATE TABLE Hashtags (
            ID                  int(11) AUTO_INCREMENT PRIMARY KEY,
			Hashtag             varchar(255) NOT NULL)";
			
		$stmt = $connection->prepare($sql);
		$stmt->execute();
    }
?>