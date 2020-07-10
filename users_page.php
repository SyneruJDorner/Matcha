<?php include '_PHP_Page_Includes/Include_Users_Page.php' ?>

<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" text="text/css" href="CSS/Users_Page_CSS.css">
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
						<img class="selection_image" id="selection_image" src="
						<?php
							include './PHP Requests/request_active_profile_image.php';
						?>"style="margin-top: 15px; margin-left: 15px;">
						
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
						<h1 style="padding-left:100px; color:white; margin: 0px; font-size: calc(14px + .5vw);">Welcome to:</h1>
						<h3 style="padding-left:110px; color:white; margin: 0px; font-size: calc(12px + .5vw);">
							<?php
								echo $user_profile_name . " ";
								if(isset($user_profile_middlename))
									echo $user_profile_middlename . " ";
								echo $user_profile_surname . "'s page!";
							?>
						</h3>
					</div>
				</div>
				
				<div>
					<button class="dropdown_menu_button dropdown_menu_button_roundness">
						<img class="dropdown_menu_imge_overlay" onclick="DisplayDropdown();" src="http://localhost/Matcha/UI/Dropdown_Menu.png" style="position:relative; height:75%; width:75%; top:1px;"></img>
						<button HIDDEN onclick="DisplayDropdown()" class="dropdown_menu_button dropdown_menu_button_roundness"></button>
						
						<div id="myDropdown" class="dropdown_menu_content">
							<?php
								if(isset($_SESSION['username']))
								{
									echo '<a href="./home.php?page=1">Home</a>';
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
		
		<div class="parallax" style="top:0px; background-image:url('<?php
			if (isset($_GET['username']))
			{
				echo $user_profile_active_pic;
				//$_GET['username']
			}
			else
				echo "http://localhost/Matcha/UI/Background.jpg";
		?>');"></div>
		
		<div>
			<div class="container" id="container" style="margin-top:460px; style="white-space:nowrap">
				<div id="image" style="display:inline;">
					<img src="http://cdn.onlinewebfonts.com/svg/img_138555.png" style="positon:relative; height:25px; width:25px;">
				</div>
			
				<hr style="height:0px; visibility:hidden;" />
					<h2>Biography:</h2><br/>
					<div style="position: relative; top: -35px; right: -20px;">
						<label><?php
							echo $user_profile_bio;
						?></b></label>
					</div>

					<h2>Username:</h2><br/>
					<div style="position: relative; top: -35px; right: -20px;">
						<label><?php
							echo $user_profile_username;
						?></b></label>
					</div>
					
					<h2>Gender/Gender Preference:</h2><br/>
					<div style="position: relative; top: -35px; right: -20px;">
						<label><?php

						if ($user_profile_gender == "male" || $user_profile_gender == "female")
						{
							echo "I'm a " . $user_profile_gender;

							if($user_profile_gender_pref != "male" && $user_profile_gender_pref != "female")
								echo " looking for either a female or male.";
							else
								echo " looking for a " . $user_profile_gender_pref . ".";
						}
						else
						{
							echo "Sorry, I haven't provided this info";
							
							if($user_profile_gender_pref != "male" && $user_profile_gender_pref != "female")
								echo " but I'm looking for either a female or male.";
							else
								echo " but I'm looking for a " . $user_profile_gender_pref . ".";
						}
						?></b></label>
					</div>
					
					<h2>Age/Age Preference:</h2><br/>
					<div style="position: relative; top: -35px; right: -20px;">
						<label><?php

						$age = date_diff(date_create($user_profile_age), date_create('now'))->y;

						echo "I'm " . $age . " years old ";
						if ($user_profile_age_pref != null)
						{
							echo " and looking for someone between the ages of " . $user_profile_age_pref ." and " . $user_profile_age_pref . ".";
						}
						else
						{
							echo "and not bothered about age.";
						}

						function validateAge($then, $min)
						{
							$then = strtotime($then);
							$min = strtotime('+18 years', $then);
							return ($min);
							//echo $min;
							//if(time() < $min)
								//die('Not 18');
						}
						?></b></label>
					</div>
					
					<h2>Ethnicity/Ethnicity Preference:</h2><br/>
					<div style="position: relative; top: -35px; right: -20px;">
						<label><?php
							echo "My Ethnicity is: " . $user_profile_ethnicity;
						?></label>
						<br/>
						<label><?php
							echo "I'm looking for someone of the following Ethnicity: " . $user_profile_ethnicity_pref;
						?></label>
					</div>
					
					<h2>My Likes:</h2><br/>
					<div style="position: relative; top: -35px; right: -20px;">
						<label><?php
							echo $user_profile_likes;
						?></b></label>
					</div>
					
					<h2>My Fame-Rating:</h2><br/>
					<div style="position: relative; top: -35px; right: -20px;">
						<label><?php echo $user_profile_fame_rating ?></b></label>
					</div>
					
					<h2>Gallery:</h2><br/>
					<div style="position: relative; top: -35px; right: -20px;">
						<hr style="height:0px; visibility:hidden;" />
						<div class="profile_image_row">
							<div class="profile_container">
								<input type="file" id="imgupload_1" style="display:none" accept="image/*"/>
								<img src="<?php
								if ($profile_pic_1 == null)
									echo "http://localhost/Matcha/UI/Default.png";
								else
									echo $profile_pic_1;
								?>" alt="Avatar" id="profile_image_1" class="profile_image">
								<div class="profile_middle">
									<div class="unselectable profile_text">👁</div>
								</div>
							</div>

							<div class="profile_container">
								<input type="file" id="imgupload_2" style="display:none" accept="image/*"/>
								<img src="<?php
								if ($profile_pic_2 == null)
									echo "http://localhost/Matcha/UI/Default.png";
								else
									echo $profile_pic_2;
								?>" alt="Avatar" id="profile_image_2" class="profile_image">
								<div class="profile_middle">
									<div class="unselectable profile_text">👁</div>
								</div>
							</div>
							
							<div class="profile_container">
								<input type="file" id="imgupload_3" style="display:none" accept="image/*"/>
								<img src="<?php
								if ($profile_pic_3 == null)
									echo "http://localhost/Matcha/UI/Default.png";
								else
									echo $profile_pic_3;
								?>" alt="Avatar" id="profile_image_3" class="profile_image">
								<div class="profile_middle">
									<div class="unselectable profile_text">👁</div>
								</div>
							</div>
							
							<div class="profile_container">
								<input type="file" id="imgupload_4" style="display:none" accept="image/*"/>
								<img src="<?php
								if ($profile_pic_4 == null)
									echo "http://localhost/Matcha/UI/Default.png";
								else
									echo $profile_pic_4;
								?>" alt="Avatar" id="profile_image_4" class="profile_image">
								<div class="profile_middle">
									<div class="unselectable profile_text">👁</div>
								</div>
							</div>
							
							<div class="profile_container">
								<input type="file" id="imgupload_5" style="display:none" accept="image/*"/>
								<img src="<?php
								if ($profile_pic_5 == null)
									echo "http://localhost/Matcha/UI/Default.png";
								else
									echo $profile_pic_5;
								?>" alt="Avatar" id="profile_image_5" class="profile_image">
								<div class="profile_middle">
									<div class="unselectable profile_text">👁</div>
								</div>
							</div>
						</div>
					</div>
					
					<div align="center" style="display:inline-block; width:100%;">
						
						<?php
						$sql = "use matcha";
						$connection->exec($sql);

						$stmt = $connection->prepare("SELECT * FROM registered_users WHERE username = :username");
						$stmt->execute(array(':username' => $_SESSION['username']));
						$result = $stmt->fetch(PDO::FETCH_ASSOC);
						
						if(!empty($result))
							$current_user_likes = $result['likes'];
						
						
						if (strpos($current_user_likes, $user_profile_username) !== false)
						{
							if (strpos($user_profile_user_likes, $_SESSION['username']) !== false)
							{
								echo '<form id="chat_form" action="./Chatrooms/chatroom.php?user_chat=' . $user_profile_username . '"method="post">';
									echo '<button class="profile_btn">';
										echo "Chat";
									echo '</button>';
								echo '</form>';
							}
						}
						else
						{
							echo '<form id="chat_form" action="" method="post"></form>';
						}
						?>
						
						<script type='text/javascript'>
						<?php
							echo "var current_username = '". $user_profile_username . "';\n";

							$php_user_array = array($user_profile_username, $user_profile_name, $user_profile_middlename, $user_profile_surname);
							$js_user_array = json_encode($php_user_array);
							echo "var javascript_user_array = ". $js_user_array . ";\n";


							$php_my_array = array($_SESSION['username'], $_SESSION['name'], $_SESSION['middle_name'], $_SESSION['surname']);
							$js_my_array = json_encode($php_my_array);
							echo "var javascript_my_array = ". $js_my_array . ";\n";
						?>
						function GetProfileUsername() 	{ return current_username; }
						function GetUserInfo() 			{ return javascript_user_array; }
						function GetMyInfo() 			{ return javascript_my_array; }
						</script>

						<button id="like_unlike_btn" onclick="Like_Unlike_User(GetProfileUsername());" class="profile_btn"> <?php
						if (strpos($current_user_likes, $user_profile_username) !== false)
							echo "Unlike";
						else
							echo "Like";
						?>

						<button onclick="report_user(GetUserInfo(), GetMyInfo());" class='profile_btn'>Report</button>
						<button onclick="block_user(GetUserInfo(), GetMyInfo());" class='profile_btn'>Block</button>

					</div>
					
					<!-- The Modal -->
					<div id="myModal" class="modal">
					<span class="close">&times;</span>
					<img class="modal-content" id="img01">
					<div id="caption"></div>
					</div>
				</html>
			</div>
		</div>
		
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
		<script type="text/javascript" src="_JS_Page_Includes/JS_Users_Profile.js"></script>
	</body>
</html>