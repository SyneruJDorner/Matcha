<?php include '../_PHP_Page_Includes/Include_Chatroom.php' ?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" text="text/css" href="../CSS/Chatroom_CSS.css">
</head>

<body>
	<?php
		include '../Config/database.php';
		include "../PHP Requests/request_profile_images_by_number.php";
		
		//First load existing chat info
		$first_user = "";
		$second_user = "";
		$fullPath = "";
		
		if (strcasecmp($_SESSION['username'], $user_chat) < 0)
		{
			$first_user = $_SESSION['username'];
			$second_user =  $user_chat;
		}
		else
		{
			$second_user = $_SESSION['username'];
			$first_user =  $user_chat;
		}
		
		if (!file_exists("./chats"))
			mkdir("./chats", 0777);
		
		$fullPath = "./chats/" . $first_user . "_and_" . $second_user . "_personal_chat.html";
				
		if (!file_exists($fullPath))
			fopen($fullPath, "w");
	?>
	
	<div id="header_bar">
		<span>
			<div>
				<div HIDDEN class="selection_image_dropdown" style="float:left; z-index: 2;">
					<img class="selection_image" id="selection_image" src="
					<?php
						include '../PHP Requests/request_active_profile_image.php';
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
					<h1 style="padding-left:100px; color:white; margin: 0px; font-size: calc(14px + .5vw);">Chat to:</h1>
					<h3 style="padding-left:110px; color:white; margin: 0px; font-size: calc(12px + .5vw);">
						<?php
							echo $user_chat . " ";
						?>
					</h3>
				</div>
			</div>
			
			<div>
				<button class="dropdown_menu_button dropdown_menu_button_roundness">
					<img class="dropdown_menu_imge_overlay" onclick="DisplayDropdown();" src="http://localhost/Matcha/http://localhost/Matcha/UI/Dropdown_Menu.png" style="position:relative; height:75%; width:75%; top:1px;"></img>
					<button HIDDEN onclick="DisplayDropdown()" class="dropdown_menu_button dropdown_menu_button_roundness"></button>
					
					<div id="myDropdown" class="dropdown_menu_content">
						<?php
							if(isset($_SESSION['username']))
							{
								echo '<a href="../users_page.php?username=' . $user_chat . '">Back to ' . $user_chat . '\'s profile</a>';
								echo '<a href="../home.php?page=1">Home</a>';
								echo '<a href="../fame_rating_users.php">Fame Rating</a>';
								echo '<a href="../block_list.php">View Block List</a>';
								echo '<a href="../edit_account.php">Edit Account</a>';
								echo '<a href="../Logout/logout.php">Logout</a>';
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

	<div class="parallax" id="parallax" style="top:0px; background-image:url('<?php
		if ($user_chat != null)
		{
			$sql = "use matcha";
			$connection->exec($sql);

			$sql = "SELECT * FROM registered_users WHERE username=:username";
			$stmt = $connection->prepare($sql);
			$stmt->execute(array(':username' => $user_chat));
			$row = $stmt->fetch();
			$user_chat_profile = $row['profile_pic_' . $row['active_profile_pic']];
			echo $user_chat_profile;
		}
		else
			echo "http://localhost/Matcha/UI/Background.jpg";
	?>');"></div>

	<div align="center" id="wrapper">
		<div class="chat_content" style="padding-top: 100px;">
			<div class="chat_objects" id="chat_objects"></div>
			<input name="usermsg" type="text" autocomplete="off" id="usermsg" size="63" />
			<input name="submitmsg" type="button" id="submitmsg" value="Send" />
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
	<script type="text/javascript">
	function DisplayDropdown()
	{
		document.getElementById("myDropdown").classList.toggle("show");
	}
	
	window.onclick = function(event)
	{
		if (!event.target.matches('.dropdown_menu_button') && 
			!event.target.matches('.dropdown_menu_imge_overlay'))
		{
			var dropdowns = document.getElementsByClassName("dropdown_menu_content");
			var i;
			for (i = 0; i < dropdowns.length; i++)
			{
				var openDropdown = dropdowns[i];
				if (openDropdown.classList.contains('show'))
					openDropdown.classList.remove('show');
			}
		}
		
		if (event.target.matches('.selection_image_choice'))
		{
			var clickedItem = event.target.getAttribute('id');
			clicked_selected_image(clickedItem);
		}
	}
	
	function clicked_selected_image(alt_name)
	{
		if (alt_name == "profile_picture_1" ||
			alt_name == "profile_picture_2" ||
			alt_name == "profile_picture_3" ||
			alt_name == "profile_picture_4" ||
			alt_name == "profile_picture_5")
		{
			$.ajax(
			{
				url: '../AJAX Functions/Set/update_active_profile.php',
					data:
					{
						action: 'UpdateActiveProfile',
						arguments: alt_name
					},
					type: 'post',
					success: function(output)
					{
						$('#selection_image').attr('src', output);
					}
			});
		}
	}
	
	//General chatting here
	$(document).ready(function()
	{
		//If we press enter on the input box -> send message
		document.getElementById('usermsg').onkeydown = function(event)
		{
			if (event.keyCode == 13)
				sendmsg();
		}
		
		//If we press enter on the submit bbutton -> send message
		document.getElementById('submitmsg').onkeydown = function(event)
		{
			if (event.keyCode == 13)
				sendmsg();
		}

		//If user submits the form
		$("#submitmsg").click(function()
		{
			sendmsg();
		});
		
		var submited = true;

		function sendmsg()
		{
			var args = "";
			args += '<?php echo $current_user ?>';
			args += ", ";
			args += $('#usermsg').val();
			args += ", ";
			args += '<?php echo $fullPath; ?>';
			var chatting_to_user = "<?php echo $user_chat; ?>";

			$('#usermsg').val(null);
			$.ajax(
			{
				url: "post_message.php",
				cache: false,
				data:
				{
					action: 'UpdateItem',
					arguments: { args: args, chatting_to_user:chatting_to_user }
				},
				type: 'post',
				success: function(output)
				{
					submited = true;
				}
			});
		}
		
		//Load the file containing the chat log
		loadLog();
		setInterval (loadLog, 1000);	//Reload file every 0.5 seconds
		
		function loadLog()
		{
			
			$.ajax(
			{
				url: "<?php echo $fullPath; ?>",
				cache: false,
				success: function(output)
				{
					sort_message_data(output);

					if (submited == true)
					{
						window.scrollTo(0,document.body.scrollHeight);
						submited = false;
					}
				},
			});
		}
		
		function sort_message_data(output)
		{
			var seperatedBlocks = output.split("ö~~$~~ö");
			
			var parenNode = document.getElementById("chat_objects");
			parenNode.innerHTML = '';
			
			var messageNode = document.createElement("div");
			parenNode.appendChild(messageNode);
			messageNode.classList.add("container");
			messageNode.setAttribute("style", "margin-top: 0px!important; margin-bottom: 5px!important; padding-bottom: 0px!important; padding-top: 0px!important; padding-right: 10px!important; margin-left:10px!important; margin-right:10px!important;");
			
			var messageTextNode = document.createElement("p");
			messageNode.appendChild(messageTextNode);
			messageTextNode.setAttribute("style", "margin-top: 8px!important; margin-bottom: 8px!important;");
			var fianlMessage = "This is the start of you conversation with <?php echo $user_chat; ?>...";
			messageTextNode.innerHTML = fianlMessage;

			for(var i = 0; i < seperatedBlocks.length; i++)
			{
				var seperatedItems = seperatedBlocks[i].split("$~~ö~~$");

				if (seperatedItems.length == 3)
				{
					var got_time = seperatedItems[0].replace(" date=", "");
					var got_username = seperatedItems[1].replace(" user=", "");
					var got_message = seperatedItems[2].replace(" text=", "");
					var current_user = "<?php echo $_SESSION['username']; ?>";
					
					if (got_username == current_user)
						my_message_placement(got_time, got_username, got_message);
					else
						their_message_placement(got_time, got_username, got_message);
				}
			}
		}
		
		function their_message_placement($got_time, $got_username, $got_message)
		{
			var parenNode = document.getElementById("chat_objects");
			
			var messageNode = document.createElement("div");
			parenNode.appendChild(messageNode);
			messageNode.classList.add("container");
			messageNode.classList.add("darker");
			messageNode.setAttribute("style", "margin-left:30px!important; margin-right:10px!important;");
		
			var messageImageNode = document.createElement("img");
			messageNode.appendChild(messageImageNode);

			var imageInfo = "<?php
				if ($user_chat != null)
				{
					$sql = "use matcha";
					$connection->exec($sql);

					$sql = "SELECT * FROM registered_users WHERE username=:username";
					$stmt = $connection->prepare($sql);
					$stmt->execute(array(':username' => $user_chat));
					$row = $stmt->fetch();
					$user_chat_profile = $row['profile_pic_' . $row['active_profile_pic']];
					
					if ($user_chat_profile == null)
						echo "http://localhost/Matcha/UI/Default.png";
					else
						echo $user_chat_profile;
				}
				else
					echo "http://localhost/Matcha/UI/Background.jpg";
			?>";

			messageImageNode.src = imageInfo;
			messageImageNode.alt = "Avatar";
			messageImageNode.classList.add("right");
			messageImageNode.setAttribute("style", "width:60px; height:60px;");
			
			
			var messageTextNode = document.createElement("p");
			messageNode.appendChild(messageTextNode);
			var fianlMessage = $got_message.slice(0, $got_message.lastIndexOf(";"));
			messageTextNode.innerHTML = fianlMessage;
			
			
			var messageTimeNode = document.createElement("span");
			messageNode.appendChild(messageTimeNode);
			messageTimeNode.classList.add("time-left");
			messageTimeNode.innerHTML = UpdatedTimeToTomezone($got_time);;
		}
		
		function my_message_placement($got_time, $got_username, $got_message)
		{
			var parenNode = document.getElementById("chat_objects");
			
			var messageNode = document.createElement("div");
			parenNode.appendChild(messageNode);
			messageNode.classList.add("container");
			messageNode.setAttribute("style", "margin-left:10px!important; margin-right:30px!important;");
			
			
			var messageImageNode = document.createElement("img");
			messageNode.appendChild(messageImageNode);
			var imageInfo = "<?php
						include '../PHP Requests/request_active_profile_image.php';
					?>";

			messageImageNode.src = imageInfo
			messageImageNode.alt = "Avatar";
			messageImageNode.setAttribute("style", "width:60px; height:60px;");
			
			
			var messageTextNode = document.createElement("p");
			messageNode.appendChild(messageTextNode);
			var fianlMessage = $got_message.slice(0, $got_message.lastIndexOf(";"));
			messageTextNode.innerHTML = fianlMessage;
			
			
			var messageTimeNode = document.createElement("span");
			messageNode.appendChild(messageTimeNode);
			messageTimeNode.classList.add("time-right");
			messageTimeNode.innerHTML = UpdatedTimeToTomezone($got_time);
		}
		
		function UpdatedTimeToTomezone($time)
		{
			var timeArray = $time.split(':');
			var visitortime = new Date();
			var visitortimezone = -visitortime.getTimezoneOffset() / 60;
			
			var newhour = parseInt(timeArray[0]) + visitortimezone;
			return (newhour + ":" + timeArray[1]);
		}
	});
	</script>
</body>
</html>