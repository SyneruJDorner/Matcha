<?php include '_PHP_Page_Includes/Include_First_Time_Login.php' ?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" text="text/css" href="CSS/First_Time_Login_CSS.css">

<body>
	<div id="header_bar">
		<span>
			<h1 style="padding-left:25px; color:white; margin: 0px; font-size: calc(14px + .5vw);">Setup Who You Are</h1>
			<h3 style="padding-left:25px; color:white; margin: 0px; font-size: calc(12px + .5vw);">Please fill in this form to help people find you.</h3>
			
			<div>
				<button class="dropdown_menu_button dropdown_menu_button_roundness">
					<img class="dropdown_menu_imge_overlay" onclick="DisplayDropdown();" src="http://localhost/Matcha/UI/Dropdown_Menu.png" style="position:relative; height:75%; width:75%; top:1px;"></img>
					<button HIDDEN onclick="DisplayDropdown()" class="dropdown_menu_button dropdown_menu_button_roundness"></button>
				</button>
				
				<div id="myDropdown" class="dropdown-content">
					<?php
						if(isset($_SESSION['username']))
							echo '<a href="./Logout/logout.php">Logout</a>';
						else
						{
							echo '<a href="index.php">Login/Register</a>';
							echo '<a href="Forgot Info/forgot_account.php">Forgot_Information</a>';
						}
					?>
				</div>
			</div>
		</span>
	</div>

	<div class="container">
		<hr style="height:0px; visibility:hidden;" />
		<hr style="height:0px; visibility:hidden;" />
			<label>Gender</b></label>
			<input type="hidden" id="gender_selection" name="gender_selection">
			<div class="custom-select" id="gender" name="gender" style="width:200px;">
				<select>
					<option value="0">Unspecified</option>
					<option value="1">Male</option>
					<option value="2">Female</option>
				</select>
			</div>
			
		<hr style="height:0px; visibility:hidden;" />
			<label><b>Sexual Preference</b></label>
			<input type="hidden" id="sexual_pref_selection" name="sexual_pref_selection">
			<div class="custom-select" style="width:200px;" id="sexual_pref" name="sexual_pref">
				<select>
					<option value="0">Unspecified</option>
					<option value="1">Male</option>
					<option value="2">Female</option>
				</select>
			</div>
			
		<hr style="height:0px; visibility:hidden;" />
			<label><b>Biography</b></label><br/>
			<textarea rows="4" style="resize: none; width:100%;" placeholder="Enter a biography" cols="50" id="bio" name="bio" required></textarea>
		
		<hr style="height:0px; visibility:hidden;" />
			<label><b>Ethnicity</b></label>
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
		
		<hr style="height:0px; visibility:hidden;" />
			<label><b>Ethnicity Preference</b></label>
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
			
		<hr style="height:0px; visibility:hidden;" />
			<label><b>Interests</b></label>
			<br/>
			<div class="autocomplete" style="width:300px;">
				<input style="float:right;" id="hashtags_input" placeholder="#pizza" type="text" placeholder="Hashtag"/>
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
					<img onclick="OpenImgUpload(1);" src="http://localhost/Matcha/UI/Default.png" alt="Avatar" id="profile_image_1" class="profile_image">
					<div class="profile_middle">
						<div class="unselectable profile_text">+</div>
					</div>
				</div>

				<div class="profile_container">
					<input type="file" id="imgupload_2" style="display:none" accept="image/*"/>
					<img onclick="OpenImgUpload(2);" src="http://localhost/Matcha/UI/Default.png" alt="Avatar" id="profile_image_2" class="profile_image">
					<div class="profile_middle">
						<div class="unselectable profile_text">+</div>
					</div>
				</div>
				
				<div class="profile_container">
					<input type="file" id="imgupload_3" style="display:none" accept="image/*"/>
					<img onclick="OpenImgUpload(3);" src="http://localhost/Matcha/UI/Default.png" alt="Avatar" id="profile_image_3" class="profile_image">
					<div class="profile_middle">
						<div class="unselectable profile_text">+</div>
					</div>
				</div>
				
				<div class="profile_container">
					<input type="file" id="imgupload_4" style="display:none" accept="image/*"/>
					<img onclick="OpenImgUpload(4);" src="http://localhost/Matcha/UI/Default.png" alt="Avatar" id="profile_image_4" class="profile_image">
					<div class="profile_middle">
						<div class="unselectable profile_text">+</div>
					</div>
				</div>
				
				<div class="profile_container">
					<input type="file" id="imgupload_5" style="display:none" accept="image/*"/>
					<img onclick="OpenImgUpload(5);" src="http://localhost/Matcha/UI/Default.png" alt="Avatar" id="profile_image_5" class="profile_image">
					<div class="profile_middle">
						<div class="unselectable profile_text">+</div>
					</div>
				</div>
			</div>
		
		<hr style="border-width: 1px; border-color:red;">
			<button type="button" value="Send" onclick="submit_page();" class="set_account_btn">Confirm Dating Preference</button>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
	<script type="text/javascript">
	var hashtags = <?php echo json_encode($phpArray); ?>;
	function GetHashtags() { return hashtags; }
	</script>
	<script type="text/javascript" src="_JS_Page_Includes/JS_First_Time_Login.js"></script>
</body>
</html>