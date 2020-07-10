<!DOCTYPE html>
<html><head>
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"><meta http-equiv="Pragma" content="no-cache"><meta http-equiv="Expires" content="0"><meta charset="utf-8">
	<title>Matcha - Forgot Info</title>
	<meta name="generator">
	<style type="text/css">
		html, body
		{
			width: 100%;
			height: 100%;
			margin: 0px;
		}

		body
		{
			background-color: transparent;
			transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
			-webkit-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
			-moz-transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
			perspective: 1400px;
			-webkit-perspective: 1400px;
			-moz-perspective: 1400px;
			transform-style: preserve-3d;
			-webkit-transform-style: preserve-3d;
			-moz-transform-style: preserve-3d;
		}

		.parallax
		{
			background-image: url("http://localhost/Matcha/UI/Background.jpg");
			height: 100%;
			background-attachment: fixed;
			background-position: center center;
			background-repeat: no-repeat;
			background-size: cover;
		}

		#header_bar
		{
			position: fixed;
			top: 0px;
			left: 0px;
			width: 100%;
			height: 60px;
			background-color: rgb(209, 52, 31);
		}

		#LogReg_Box
		{
			position: fixed;
			top: 0px;
			left: 0px;
			width: 250px;
			height: 120px;
			background-color: rgb(186, 9, 0);
		}

		#footer_bar
		{
			position: fixed;
			left: 0px;
			bottom: 0px;
			width: 100%;
			height: 60px;
			background-color: rgb(209, 52, 31);
		}

		input[type=text], input[type=email], input[type=password]
		{
			width: 100%;
			padding: 12px 20px;
			margin: 8px 0;
			display: inline-block;
			border: 1px solid #ccc;
			box-sizing: border-box;
		}

		button
		{
			background-color: red;
			color: white;
			padding: 0px;
			margin: 0px;
			border: none;
			cursor: pointer;
			width: 100%;
			height: 40px;
		}

		button:hover
		{
			opacity: 0.8;
		}

		.cancelbtn
		{
			width: auto;
			padding: 10px 18px;
			background-color: #f44336;
		}

		.imgcontainer
		{
			text-align: center;
			margin: 24px 0 12px 0;
			position: relative;
		}

		img.avatar
		{
			width: 40%;
			border-radius: 50%;
		}

		.container
		{
			padding: 16px;
		}

		span.psw
		{
			float: right;
			padding-top: 16px;
		}

		.modal
		{
			display: none;
			position: fixed;
			z-index: 1;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			overflow: auto;
			background-color: rgb(0, 0, 0);
			background-color: rgba(0, 0, 0, 0.4);
			padding-top: 60px;
		}

		.modal-content
		{
			background-color: #f0f0f0;
			margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
			border: 1px solid #888;
			width: 80%; /* Could be more or less, depending on screen size */
		}

		.close
		{
			position: absolute;
			right: 25px;
			top: 0;
			color: #000;
			font-size: 35px;
			font-weight: bold;
		}

		.close:hover,
		.close:focus
		{
			color: red;
			cursor: pointer;
		}

		.animate
		{
			-webkit-animation: animatezoom 0.6s;
			animation: animatezoom 0.6s
		}

		@-webkit-keyframes animatezoom
		{
			from {-webkit-transform: scale(0)} 
			to {-webkit-transform: scale(1)}
		}
			
		@keyframes animatezoom
		{
			from {transform: scale(0)} 
			to {transform: scale(1)}
		}

		@media screen and (max-width: 300px)
		{
			span.psw
			{
			   display: block;
			   float: none;
			}
			.cancelbtn
			{
			   width: 100%;
			}
		}
		
		.dropdown_menu_button
		{
			background-color: red;
			border: none;
			color: white;
			text-align: center;
			text-decoration: none;
			position: absolute;
			float: right;
			top: 8px;
			right: 8px;
			font-size: 16px;
			cursor: pointer;
			height: 40px;
			width: 40px;
		}

		.dropdown_menu_button_roundness
		{
			border-radius: 4px;
		}
		
		
		
		
		
		
		

		.dropdown-content
		{
			display: none;
			margin: 8px 8px auto;
			float:right;
			position: relative;
			background-color: #f1f1f1;
			min-width: 160px;
			overflow: auto;
			box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
			z-index: 1;
		}

		.dropdown-content a
		{
			color: black;
			padding: 12px 12px;
			text-decoration: none;
			display: block;
		}

		.dropdown-content a:hover
		{
			background-color: #ddd;
		}
		
		.show
		{
			display: block;
		}
	</style>
</head>

<body>
    <div id="header_bar">
		<span>
			<h1 style="padding-left:260px; color:white; margin: 0px; font-size: calc(14px + .5vw);">Forgot password or email?</h1>
			<h3 style="padding-left:260px; color:white; margin: 0px; font-size: calc(12px + .5vw);">Request a new one!</h3>
			
			<div>
				<button class="dropdown_menu_button dropdown_menu_button_roundness">
					<img class="dropdown_menu_imge_overlay" onclick="DisplayDropdown();" src="http://localhost/Matcha/http://localhost/Matcha/UI/Dropdown_Menu.png" style="position:relative; height:75%; width:75%; top:1px;"></img>
					<button HIDDEN onclick="DisplayDropdown()" class="dropdown_menu_button dropdown_menu_button_roundness"></button>
				</button>
				
				<div id="myDropdown" class="dropdown-content">
					<?php
						if(isset($_SESSION['username']))
						{
							echo '<a href="#home">Home</a>';
							echo '<a href="#edit_account">Edit Account</a>';
							echo '<a href="#logout">Logout</a>';
						}
						else
						{
							echo '<a href="../index.php">Login/Register</a>';
							echo '<a href="forgot_account.php">Forgot_Information</a>';
						}
					?>
				</div>
			</div>
			
        </span>
		<div id="LogReg_Box">
            <ul>
                <button name="forgot_password" onclick="document.getElementById('id02').style.display='block'">Forgot Password</button>
            </ul>
        </div>
    </div>
    
    <div class="parallax"></div>
    <div id="footer_bar" style="font-size: calc(25px + .5vw); color:white;">
        Footer info here
    </div>











	<div id="id02" class="modal">
        <form class="modal-content animate" action="./Forgot_Password.php">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                <img src="http://localhost/Matcha/UI/Default.png" alt="Avatar" class="avatar" style="max-width:128px; max-height:128px;">
            </div>

            <div class="container">
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="uname" required>

                <label for="uemail"><b>Email</b></label>
                <input type="email" placeholder="Enter Email" name="uemail" required>
                    
                <button type="submit">Send Email For Forgotten Password</button>
            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
            </div>
        </form>
    </div>







    <script type="text/javascript">
	var modal_02 = document.getElementById('id02');
	
	window.onclick = function(event)
	{
		if (event.target == modal_02)
		{
			modal_02.style.display = "none";
		}
	}


	/* When the user clicks on the button, 
	toggle between hiding and showing the dropdown content */
	function DisplayDropdown()
	{
		document.getElementById("myDropdown").classList.toggle("show");
	}

	// Close the dropdown if the user clicks outside of it
	window.onclick = function(event)
	{
		if (!event.target.matches('.dropdown_menu_button') && 
			!event.target.matches('.dropdown_menu_imge_overlay'))
		{
			var dropdowns = document.getElementsByClassName("dropdown-content");
			var i;
			for (i = 0; i < dropdowns.length; i++)
			{
				var openDropdown = dropdowns[i];
				if (openDropdown.classList.contains('show'))
					openDropdown.classList.remove('show');
			}
		}
	}
	</script>
	
	
	
</body>

</html>