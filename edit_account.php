<?php include '_PHP_Page_Includes/Include_Edit_Account.php' ?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" text="text/css" href="CSS/Edit_Account_CSS.css">

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
						<img src=<?php get_image_at_position(1);?>
						class="selection_image_choice" id="profile_picture_1" width="60" height="60">
						<img src=<?php get_image_at_position(2);?>
						class="selection_image_choice" id="profile_picture_2" width="60" height="60">
						<img src=<?php get_image_at_position(3);?>
						class="selection_image_choice" id="profile_picture_3" width="60" height="60">
						<img src=<?php get_image_at_position(4);?>
						class="selection_image_choice" id="profile_picture_4" width="60" height="60">
						<img src=<?php get_image_at_position(5);?>
						class="selection_image_choice" id="profile_picture_5" width="60" height="60">					
					</div>
				</div>
				
				<div style="position: absolute; float:left;">
					<h1 style="padding-left:100px; color:white; margin: 0px; font-size: calc(14px + .5vw);">Edit Account</h1>
					<h3 style="padding-left:110px; color:white; margin: 0px; font-size: calc(12px + .5vw);">From here you may edit you personal settings and preference.</h3>
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
								echo '<a href="home.php?page=1">Home</a>';
								echo '<a href="./fame_rating_users.php">Fame Rating</a>';
								echo '<a href="./block_list.php">View Block List</a>';
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
	
	<div class="container">
		<hr style="height:50px; visibility:hidden;"/>
		<div style="display: block; top:260px; left:50px;">
			<span>
				<h3 class="noselect" style="position:relative; display:inline;">First Name: </h3>
				<span id="name_field" class="edit-on-click" style="display: block;"><?php include 'PHP Requests/request_current_name.php'; echo trim(request_current_name());?></span>
			</span><br/>
			
			<span>
				<h3 class="noselect" style="position:relative; display:inline;">Middle Name: </h3>
				<span id="middlename_field" class="edit-on-click" style="display: block;"><?php include 'PHP Requests/request_current_middlename.php'; echo trim(request_current_middlename());?></span>
			</span><br/>

			<span>
				<h3 class="noselect" style="position:relative; display:inline;">Last Name: </h3>
				<span id="surname_field" class="edit-on-click" style="display: block;"><?php include 'PHP Requests/request_current_surname.php'; echo trim(request_current_surname());?></span>
			</span><br/>
			
			<span>
				<h3 class="noselect" style="position:relative; display:inline;">Email: </h3>
				<span id="email_field" class="edit-on-click" style="display: block;"><?php include 'PHP Requests/request_current_email.php'; echo trim(request_current_email());?></span>
			</span><br/>
			
			<span>
				<h3 class="noselect" style="position:relative; display:inline;">Change Password: </h3>
				<button name="update_password" class="simple_btn" onclick="document.getElementById('id02').style.display='block'">Change Password</button>
			</span><br/>
			
			<div id="id02" class="modal">
					<div class="imgcontainer">
						<span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
					</div>

					<div class="container">
						<label for="Passowrd"><b>Passowrd</b></label>
						<input type="password" id="new_password" placeholder="Enter Passowrd" name="Passowrd" required>

						<label for="RePassowrd"><b>Renter Passowrd</b></label>
						<input type="password" id="new_renter_password" placeholder="Renter RePassowrd" name="RePassowrd" required>
							
						<button type="submit" onclick="Update_Password()">Change Password</button>
					</div>

					<div class="container" style="background-color:#f1f1f1">
						<button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
					</div>
			</div><br/>
				
			<span>
				<h3 class="noselect" style="position:relative; display:inline;">Bio: </h3>
				<span id="bio_field" class="edit-on-click" style="display: block;"><?php include 'PHP Requests/request_current_bio.php'; echo trim(request_current_bio());?></span>
			</span><br/>
			
			<span>
				<h3 class="noselect" style="position:relative; display:inline;">Gender: </h3>
				<input type="hidden" id="gender_selection" name="gender_selection">
				<div class="custom-select" style="width:200px;" id="gender" name="gender">
					<select>
						<option value="0">Unspecified</option>
						<option value="1">Male</option>
						<option value="2">Female</option>
					</select>
				</div>
				<hr style="height:0px; visibility:hidden;" />
			</span>
			
			<span>
				<h3 class="noselect" style="position:relative; display:inline;">Gender Pref: </h3>
					<input type="hidden" id="sexual_pref_selection" name="sexual_pref_selection">
					<div class="custom-select" style="width:200px;" id="sexual_pref" name="sexual_pref">
						<select>
							<option value="0">Unspecified</option>
							<option value="1">Male</option>
							<option value="2">Female</option>
						</select>
					</div>
					<hr style="height:0px; visibility:hidden;" />
			</span>

			<span>
				<h3 class="noselect" style="position:relative; display:inline;">Ethnicity: </h3>
				<input type="hidden" id="ethnicity_selection" name="ethnicity_selection">
				<div class="custom-select" style="width:200px;" name="ethnicity" id="ethnicity">
					<select>
						<option value="0">Unspecified</option>
						<option value="1">American Indian</option>
						<option value="2">Asian</option>
						<option value="3">Black</option>
						<option value="4">Indian</option>
						<option value="5">Hispanic/Latino</option>
						<option value="6">Multiracial</option>
						<option value="7">Native Hawaiian</option>
						<option value="8">White</option>
					</select>
				</div>
			</span><br/>
			
			<span>
				<h3 class="noselect" style="position:relative; display:inline;">Ethnicity Preference: </h3>
				<input type="hidden" id="ethnicity_pref_selection" name="ethnicity_pref_selection">
				<div class="custom-select" style="width:200px;" name="ethnicity_pref" id="ethnicity_pref">
					<select>
						<option value="0">Unspecified</option>
						<option value="1">American Indian</option>
						<option value="2">Asian</option>
						<option value="3">Black</option>
						<option value="4">Indian</option>
						<option value="5">Hispanic/Latino</option>
						<option value="6">Multiracial</option>
						<option value="7">Native Hawaiian</option>
						<option value="8">White</option>
					</select>
				</div>
			</span><br/>
			
			<h3 class="noselect" style="position:relative; display:inline;">Interests: </h3>
			<br/>
			<div class="autocomplete" style="width:300px;">
				<input style="float:right;" id="hashtags_input" placeholder="#pizza" type="text"/>
			</div>
			
			<div style="position: relative; bottom:10px; float:right;">
				<input type="hidden" id="hashtag_array_selection" name="hashtag_array_selection">
				<button type="button" onclick="AddHashtag();" class="hashtag_btn" style="width:80%; background-color:rgb(229, 55, 55);">Add Hashtag</button>
			</div>
			<p id="dynamic-hashtags"></p>
			
			<hr style="border-width: 1px; border-color:red;">
				<label><b>Profile Image(s)</b></label>
			<hr style="height:0px; visibility:hidden;" />
				<div class="profile_image_row">
					<div class="profile_container">
						<input type="file" id="imgupload_1" style="display:none" accept="image/*"/>
						<img onclick="OpenImgUpload(1);" src=<?php get_image_at_position(1);?> alt="Avatar" id="profile_image_1" class="profile_image">
						<div class="profile_middle">
							<div class="unselectable profile_text">+</div>
						</div>
					</div>

					<div class="profile_container">
						<input type="file" id="imgupload_2" style="display:none" accept="image/*"/>
						<img onclick="OpenImgUpload(2);" src=<?php get_image_at_position(2);?> alt="Avatar" id="profile_image_2" class="profile_image">
						<div class="profile_middle">
							<div class="unselectable profile_text">+</div>
						</div>
					</div>
					
					<div class="profile_container">
						<input type="file" id="imgupload_3" style="display:none" accept="image/*"/>
						<img onclick="OpenImgUpload(3);" src=<?php get_image_at_position(3);?> alt="Avatar" id="profile_image_3" class="profile_image">
						<div class="profile_middle">
							<div class="unselectable profile_text">+</div>
						</div>
					</div>
					
					<div class="profile_container">
						<input type="file" id="imgupload_4" style="display:none" accept="image/*"/>
						<img onclick="OpenImgUpload(4);" src=<?php get_image_at_position(4);?> alt="Avatar" id="profile_image_4" class="profile_image">
						<div class="profile_middle">
							<div class="unselectable profile_text">+</div>
						</div>
					</div>
					
					<div class="profile_container">
						<input type="file" id="imgupload_5" style="display:none" accept="image/*"/>
						<img onclick="OpenImgUpload(5);" src=<?php get_image_at_position(5);?> alt="Avatar" id="profile_image_5" class="profile_image">
						<div class="profile_middle">
							<div class="unselectable profile_text">+</div>
						</div>
					</div>
				</div>
				<br/>
				<br/>
		</div>
	</div>
	
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
	<script type="text/javascript">
	var hashtags = <?php echo json_encode($phpArray); ?>;
	</script>
	<script type="text/javascript" src="_JS_Page_Includes/JS_Edit_Account.js"></script>
</body>