<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	include 'Notifications/notifications.php';
	include 'Config/database.php';
	include 'Online_User_Tracking/Online_User_Tracking.php';

	require_once('Geodata/Announce_Login.php');
	
	if (!isset($_SESSION['username']))
	{
		Header("Location: index.php");
		return;
	}
	
	session_login($connection);
	Store_IP_Info($connection);
	$current_username = null;

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
			$current_username = $result['name'];
			$_SESSION['name'] = $result['name'];
			$_SESSION['middle_name'] = $result['middle_name'];
			$_SESSION['surname'] = $result['surname'];
			$_SESSION['username'] = $result['username'];
			$_SESSION['email'] = $result['email'];
			$_SESSION['first_time_login'] = $result['first_time_login'];
			$_SESSION['block_list'] = $result['block_list'];
			$_SESSION['personal_notifications'] = $result['notifications'];

			if (isset($_SESSION["first_time_login_completed"]))
				if ($_SESSION["first_time_login_completed"] == "1")
					$_SESSION['first_time_login'] = "0";
			if ($_SESSION['first_time_login'] == "1")
			{
				header("location: first_time_login.php");
				return;
			}

			//Store_IP_Info();
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	display_users();
	
	function display_users()
	{
		include 'Config/database.php';
		include 'Geodata/Determine_Distance.php';

		$sql = "use matcha";
        $connection->exec($sql);

		$sql = "SELECT * FROM registered_users WHERE username=:username";
		$stmt = $connection->prepare($sql);
		$stmt->execute(array(':username' => $_SESSION['username']));
		
		$gender;
		$gender_pref;
		$likes;
		$fame_rating;
		$pics = array();
	
		while($row = $stmt->fetch())
		{
			$gender = $row['gender'];
			$gender_pref = $row['LOOKIN_AT_GENDER'];
			$likes = $row['I_LIKE'];
			$fame_rating = $row['fame_rating'];
			array_push($pics, $row['profile_pic_1']);
			array_push($pics, $row['profile_pic_2']);
			array_push($pics, $row['profile_pic_3']);
			array_push($pics, $row['profile_pic_4']);
			array_push($pics, $row['profile_pic_5']);
		}
		
		$sql = "SELECT * FROM registered_users WHERE registered_account=1 AND first_time_login=0";
		$stmt = $connection->prepare($sql);
		$stmt->execute(array());
		
		
		echo '<div class="row">' . "\n";
		$onlineStatusPos = 0;

		while($row = $stmt->fetch())
		{
			$contains_own_image = false;
			
			if (strpos($_SESSION['block_list'], $row['username']) !== false ||
				strpos($row['block_list'], $_SESSION['username']) !== false)
				continue;

			if ($row['username'] == $_SESSION['username'] ||
				InterestCount($likes, $row['I_LIKE']) < 3 ||
				($fame_rating - $row['fame_rating']) < -20 ||
				($fame_rating - $row['fame_rating']) > 20)
				continue;


			if ($gender_pref == "unspecified")
			{
				if ($gender != $row['LOOKIN_AT_GENDER'])
					continue;
			}
			else if ($gender_pref == "male" || $gender_pref == "female")
			{
				if ($gender != $row['LOOKIN_AT_GENDER'] ||
					$row['gender'] != $gender_pref)
					continue;
			}

			for($i = 0; $i < count($pics); $i++)
			{
				if ($pics[$i] != "http://localhost/Matcha/UI/Default.png")
				{
					$contains_own_image = true;
					break;
				}
			}

			$db_image = $row['profile_pic_' . $row['active_profile_pic']];

			if ($db_image == null)
				$db_image = "http://localhost/Matcha/UI/Default.png";

			echo '<div class="polaroid" id="founduser_' . $row['username'] . '">' . "\n";
				echo '<img src="' . $db_image . ' " style="width:100%"> ' . "\n";

				echo '<div class="container">' . "\n";
					echo '<img src="';

					$dtime = DateTime::createFromFormat("Y-m-d H:i:s", $row['online_status']);
					$timestamp = $dtime->getTimestamp();
					$currentTime = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
					$current_timestamp = $currentTime->getTimestamp();

					if($current_timestamp - $timestamp > 1)
						echo 'http://localhost/Matcha/UI/Offline.png" title="Offline"';
					else
						echo 'http://localhost/Matcha/UI/Online.png" title="Online"';
					echo 'id="Online_Status_' . $onlineStatusPos . '" style="float:left; margin-top: 27px; width:5%;">' . "\n";
					$onlineStatusPos++;

					//Their name
					$found_user_full_name = '<h3 style="margin-bottom:-15px;">' . $row['name'];
					if ($row['middle_name'] != null)
						$found_user_full_name .= " " . $row['middle_name'];
					$found_user_full_name .= " " . $row['surname'] . '</h3>' . "\n";
					echo trim($found_user_full_name);

					//Their username
					$found_username = trim($row['username']);
					echo "<h3 style='word-break: break-word;'>(" . $found_username . ")";
					echo "</h3>";
					echo "<hr border-left: thick solid #ff0000;>";

					//General info about them
					if ($row['gender'] != "Unspecified")
					{
						echo "<div style='width:100%; margin:0px; padding:0px; line-height: 20px; text-align: left;'>";
							$found_user_gender = '<h4 style="display: inline; word-break: break-word;">';
							$found_user_gender .= "Gender: ";
							if ($row['gender'] == "male")
								$found_user_gender .= '<img class="gender_image_overlay" title="Male" src="http://localhost/Matcha/UI/male-128.png"/>';
							else if ($row['gender'] == "female")
								$found_user_gender .= '<img class="gender_image_overlay" title="Female" src="http://localhost/Matcha/UI/female-128.png"/>';
							$found_user_gender .= '</h4>' . "\n";
							
							echo trim($found_user_gender);
						echo "</div>";
					}
					echo "<br/>";

					echo "<div style='width:100%; margin:0px; padding:0px; line-height: 20px; text-align: left;'>";
						$found_user_distance = '<h4 style="display: inline; word-break: break-word;">';
						$found_user_distance .= "Distance From You: ";
						$found_user_distance .= '</h4>' . "\n";
						echo trim($found_user_distance);
						$distance_to_user = GetDistance($found_username);
						echo "<span style='width:100%; word-break: break-word;'>" . $distance_to_user . "km</span>";
					echo "</div>";
					
					echo "<br/>";
					echo "<div style='width:100%; margin:0px; padding:0px; line-height: 20px; text-align: left;'>";
						$found_user_likes = '<h4 style="display: inline; word-break: break-word;">';
						$found_user_likes .= "Things they like: ";
						$found_user_likes .= '</h4>' . "\n";
						
						echo trim($found_user_likes);
						echo "<br/>";
						echo "<span style='width:100%; word-break: break-word;'>" . str_replace(", ", "<br/>", $row['I_LIKE']) . "</span>";
					echo "</div>" . "\n";
				echo '</div>' . "\n";
				echo "<button onclick=\"GoToUserPage(" . "'" . trim($row['username']) . "'" . ");\" class='profile_btn' style='float:right; margin-bottom:5px; margin-right:5px;'>View User ></button>" . "\n";
			echo '</div>' . "\n";
		}
		echo '</div>' . "\n";
	}
	
	function InterestCount($current_user_intrests, $found_user_intrests)
	{
		$found_user_intrests_array = explode(", ", $found_user_intrests);
		$current_user_intrests_array = explode(", ", $current_user_intrests);
		
		$count = count(array_intersect($found_user_intrests_array, $current_user_intrests_array));
		return $count;
	}

	CheckForMessages();
?>