<?php include '_PHP_Page_Includes/Include_Home.php' ?>

<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" text="text/css" href="CSS/Home_CSS.css?v=1">
	</head>

	<body>
		<?php
			include 'Config/database.php';
			include "PHP Requests/request_profile_images_by_number.php";
		?>
		
		<div id="header_bar">
			<span>
				<div>
					<div HIDDEN class="selection_image_dropdown" style="float:left; z-index: 2;">
						<img class="selection_image" id="selection_image" src="<?php include './PHP Requests/request_active_profile_image.php';?>"style="margin-top: 15px; margin-left: 15px;">
						
						<div align="center" id="selection_image_dropdown-content" class="selection_image_dropdown-content">
							<img src=<?php get_image_at_position(1, $connection);
							?> class="selection_image_choice" id="profile_picture_1" width="60" height="60">
							<img src=<?php get_image_at_position(2, $connection);
							?> class="selection_image_choice" id="profile_picture_2" width="60" height="60">
							<img src=<?php get_image_at_position(3, $connection);
							?> class="selection_image_choice" id="profile_picture_3" width="60" height="60">
							<img src=<?php get_image_at_position(4, $connection);
							?> class="selection_image_choice" id="profile_picture_4" width="60" height="60">
							<img src=<?php get_image_at_position(5, $connection);
							?> class="selection_image_choice" id="profile_picture_5" width="60" height="60">					
						</div>
					</div>
					
					<div style="position: absolute; float:left;">
						<h1 style="padding-left:100px; color:white; margin: 0px; font-size: calc(14px + .5vw);">Welcome back:</h1>
						<h3 style="padding-left:110px; color:white; margin: 0px; font-size: calc(12px + .5vw);">
							<?php
								echo $_SESSION['name'] . " ";
								if(isset($_SESSION['middle_name']))
									echo $_SESSION['middle_name'] . " ";
								echo $_SESSION['surname'];
							?>
						</h3>
						
						<h5 style="padding-left:120px; color:white; margin: 0px; font-size: calc(10px + .5vw);">People of the same intrests will appear here! (A min of 3 intrests need to match)</h5>
					</div>
				</div>
				
				<div>
					<div class="dropdown_notifications" onmouseover="removeDatabaseNotifications()" style="position: relative; float:right; padding-left:75px;">
						<img class="dropimg" style="width:40px; margin-top:10px; margin-left:-100px;" src="http://localhost/Matcha/UI/Notification.png"/>
						<img class="dropimg" id="notification_img_icon"<?php
							include 'Config/database.php';

							$sql = "use matcha";
							$connection->exec($sql);
					
							$sql = "SELECT * FROM registered_users WHERE username=:username";
							$stmt = $connection->prepare($sql);
							$stmt->execute(array(':username' => $_SESSION['username']));

							while($row = $stmt->fetch())
							{
								$user_notifications = $row['notifications'];
								$notification_array = explode(", ", $user_notifications);
								$notification_array = array_filter($notification_array, function($value) { return $value !== ''; });
							}

							if (count($notification_array) <= 0)
								echo "HIDDEN ";
						?>
						style="position:absolute; width:25px; top: 8px; left: 0px;" id="Notify-Img" src="http://localhost/Matcha/UI/Notification-Icon.png"/>
						<div style="margin-left:-235px;" class="dropdown_notifications-content" id="dropdown_notifications-content">
						<?php
							include 'Config/database.php';

							$sql = "use matcha";
							$connection->exec($sql);
					
							$sql = "SELECT * FROM registered_users WHERE username=:username";
							$stmt = $connection->prepare($sql);
							$stmt->execute(array(':username' => $_SESSION['username']));

							while($row = $stmt->fetch())
							{
								$user_notifications = $row['notifications'];
								$notification_array = explode(", ", $user_notifications);
								$notification_array = array_filter($notification_array, function($value) { return $value !== ''; });
							}

							for($i = 0; $i < count($notification_array); $i++)
							{
								echo "<p class='paragraph-text notification-text'>" . $notification_array[$i] . "</p>\n";
							}
						?>
						</div>
					</div>

					<button class="dropdown_menu_button dropdown_menu_button_roundness">
						<img class="dropdown_menu_imge_overlay" onclick="DisplayDropdown();" src="http://localhost/Matcha/UI/Dropdown_Menu.png" style="position:relative; height:75%; width:75%; top:1px;"></img>
						<button HIDDEN onclick="DisplayDropdown()" class="dropdown_menu_button dropdown_menu_button_roundness"></button>
						
						<div id="myDropdown" class="dropdown_menu_content">
							<?php
								if(isset($_SESSION['username']))
								{
									echo '<a href="./fame_rating_users.php">Fame Rating</a>';
									echo '<a href="./block_list.php">View Block List</a>';
									echo '<a href="./edit_account.php">Edit Account</a>';
									echo '<a href="./Logout/logout.php">Logout</a>';
								}
								else
								{
									echo '<a href="index.php">Login/Register</a>';
									echo '<a href="Forgot Info/forgot_account.php">Forgot_Information</a>';
								}
							?>
						</div>
					</button>
				</div>
			</span>
		</div>
		
		<div id="snackbar">Some text some message..</div>

		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
		<script type="text/javascript" src="_JS_Page_Includes/JS_Home.js"></script>
	</body>
</html>