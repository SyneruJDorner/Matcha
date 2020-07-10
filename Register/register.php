<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	include '../Notifications/notifications.php';
	CheckForMessages();

	if(isset($_GET['name']) &&
		isset($_GET['middle_name']) &&
		isset($_GET['surname']) &&
		isset($_GET['username']) &&
		isset($_GET['age']) &&
		isset($_GET['email']) &&
		isset($_GET['psw']) &&
		isset($_GET['psw-repeat']))
	{
		register_new_user();
	}
	
	function register_new_user()
	{
		include '../Config/setup.php';
		confirm_duplicate_accounts($connection);
		echo "You have been registered!";
	}
	
	function confirm_duplicate_accounts($connection)
    {
		$name = 		htmlspecialchars($_GET['name'], ENT_QUOTES, 'UTF-8');
		$middle_name = 	htmlspecialchars($_GET['middle_name'], ENT_QUOTES, 'UTF-8');
		$surname = 		htmlspecialchars($_GET['surname'], ENT_QUOTES, 'UTF-8');
		$username = 	htmlspecialchars($_GET['username'], ENT_QUOTES, 'UTF-8');
		$age = 			htmlspecialchars($_GET['age'], ENT_QUOTES, 'UTF-8');
		$email = 		htmlspecialchars($_GET['email'], ENT_QUOTES, 'UTF-8');
		$pass = 		htmlspecialchars($_GET['psw'], ENT_QUOTES, 'UTF-8');
		$confirm_pass = htmlspecialchars($_GET['psw-repeat'], ENT_QUOTES, 'UTF-8');
		
		echo $pass . "<br/>";
		echo $confirm_pass . "<br/>";
		
		if (!preg_match('/^[\p{L}]+$/u', $name))
		{
            $_SESSION['message'] = "Please enter your valid name.";
			header("location: register.php");
			return;
		}

		if (!ctype_alpha($middle_name) && $middle_name != null)
		{
            $_SESSION['message'] = "Please enter your valid middle name.";
			header("location: register.php");
			return;
		}

		if (!preg_match('/^[\p{L}]+$/u', $surname))
		{
            $_SESSION['message'] = "Please enter your valid surname.";
			header("location: register.php");
			return;
		}

		if (contains("&amp;lt;", $username) == true || contains("&lt;script&gt;", $username) ||
			contains("&lt;/script&gt;", $username) || contains("<script>", $username) ||
			contains("</script>", $username))
		{
			$_SESSION['message'] = "Name containing XSS injects are prohibited!";
			header("location: register.php");
			return;
		}
		
		if (!ctype_alnum($username))
		{
			$_SESSION['message'] = "Your usename may only contain Letters and numbers, no special characters!";
			header("location: register.php");
			return;
		}
		
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$_SESSION['message'] = "Invalid email format.";
			header("location: register.php");
			return;
		}

		if(time() < validateAge($age, 18))
		{
			$_SESSION['message'] = "Your age needs to be 18 or above to join!";
			header("location: register.php");
			return;
		}
		
		if (strlen($pass) < 8)
		{
			$_SESSION['message'] = "The password entered is too short, please ensure it\'s 8 characters or longer.";
			header("location: register.php");
			return;
		}

		if (!preg_match('/\d/', $pass))
		{
            $_SESSION['message'] = "The password needs to have a number in it.";
			header("location: register.php");
			return;
		}

		if (!preg_match('/[a-z]/', $pass))
		{
            $_SESSION['message'] = "The password need to have a lowercase letter in it.";
			header("location: register.php");
			return;
		}

		if (!preg_match('/[A-Z]/', $pass))
		{
            $_SESSION['message'] = "The password need to have a uppercase letter in it.";
			header("location: register.php");
			return;
		}
		
        if ($pass != $confirm_pass)
        {
            $_SESSION['message'] = "The passwords entered do not match.";
			header("location: register.php");
			return;
		}

		$sql = "use matcha";
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		
		$sql = "SELECT * FROM registered_users WHERE username=:username";
		$stmt = $connection->prepare($sql);
		$stmt->execute(array(':username' => $username));
		
        if ($stmt->rowCount() >= 1)
        {
            $_SESSION['message'] = "The username you have selected is already taken!";
            header('location: register.php');
            return;
        }
		
		$sql = "SELECT * FROM registered_users WHERE name=:name AND middle_name=:middle_name AND surname=:surname AND age=:age";
		$stmt = $connection->prepare($sql);
		$stmt->execute(array(':name' => $name, ':middle_name' => $middle_name, ':surname' => $surname, ':age' => $age));
		
        if ($stmt->rowCount() >= 1)
        {
            $_SESSION['message'] = "The person " . $name . " " . $middle_name . " " . $surname . " is already registered! Prehaps you forgot your password?";
            header('location: register.php');
            return;
        }
		
		insert_info($connection);
		header("location: ../Config/sendmail.php?username=" . $username . "&name=" . $name);
		return;
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

	function contains($needle, $haystack)
	{
    	return strpos($haystack, $needle) !== false;
	}
	
	function insert_info($connection)
    {
		$name 			= $_GET['name'];
		$middle_name 	= $_GET['middle_name'];
		$surname 		= $_GET['surname'];
		$username 		= $_GET['username'];
		$age 			= $_GET['age'];
		$email 			= $_GET['email'];
		$pass 			= hash("sha512", $_GET['psw']);
        $code     		= generate_pin(4);


        $sql = "INSERT INTO registered_users (name, middle_name, surname, username, age, email, password, confirmation_code, registered_account, comment_email, chat_email , like_email, first_time_login, biography, active_profile_pic)
            VALUES ('$name', '$middle_name', '$surname', '$username', '$age', '$email', '$pass', '$code', 0, 1, 1, 1, 1, '', 1)";

        if ($connection->query($sql) === FALSE)
            //debug_to_console("Error: " . $sql . "<br>" . $connection->error);
        return;
    }

    function generate_pin($digits = 4)
    {
        $i = 0;
        $pin = "";
        while($i < $digits)
        {
            $pin .= mt_rand(0, 9);
            $i++;
        }
        return $pin;
    }
	
    function debug_to_console($data)
    {
        $output = $data;
        if (is_array( $output))
            $output = implode( ',', $output);
    
        echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
    }
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body
{
    font-family: Arial, Helvetica, sans-serif;
    background-color: "#E6E6FA";
	background-repeat: no-repeat;
    background-image: url("http://localhost/Matcha/UI/Background.jpg");
	background-size:cover;
	background-position: center;
}

*
{
    box-sizing: border-box;
}

.container
{
    padding: 16px;
    background-color: #f0f0f0;
	margin-left:auto;
	margin-right:auto;
	width: 80%;
}

input[type=text], input[type=password], input[type=date]
{
    width: 100%;
    padding: 15px;
    margin: 5px 0 22px 0;
    display: inline-block;
    border: none;
    background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus, input[type=date]:focus
{
    background-color: #ddd;
    outline: none;
}

hr
{
    border: 1px solid #f1f1f1;
    margin-bottom: 25px;
}

.registerbtn
{
    background-color: red;
    color: white;
    padding: 16px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

.registerbtn:hover
{
    opacity: 0.8;
}

a
{
    color: dodgerblue;
}

.signin
{
    background-color: #f1f1f1;
    text-align: center;
}







.custom-select
{
  position: relative;
  font-family: Arial;
}

.custom-select select
{
  display: none;
}

.select-selected
{
  background-color: rgb(229, 55, 55);
}

.select-selected:after
{
  position: absolute;
  content: "";
  top: 14px;
  right: 10px;
  width: 0;
  height: 0;
  border: 6px solid transparent;
  border-color: #fff transparent transparent transparent;
}

.select-selected.select-arrow-active:after
{
  border-color: transparent transparent #fff transparent;
  top: 7px;
}

.select-items div,.select-selected
{
  color: #ffffff;
  padding: 8px 16px;
  border: 1px solid transparent;
  border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent;
  cursor: pointer;
  user-select: none;
}

.select-items
{
  position: absolute;
  background-color: rgb(229, 55, 55);
  top: 100%;
  left: 0;
  right: 0;
}

.select-hide
{
  display: none;
}

.select-items div:hover, .same-as-selected
{
  background-color: rgba(0, 0, 0, 0.1);
}





#header_bar
{
	position: fixed;
	top: 0px;
	left: 0px;
	width: 100%;
	height: 60px;
	background-color: rgb(209, 52, 31);
	z-index: 1;
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
			<h1 style="padding-left:25px; color:white; margin: 0px; font-size: calc(14px + .5vw);">Registeration Page</h1>
			<h3 style="padding-left:25px; color:white; margin: 0px; font-size: calc(12px + .5vw);">Please fill in this form to create an account.</h3>
			
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
							echo '<a href="../Forgot Info/forgot_account.php">Forgot_Information</a>';
						}
					?>
				</div>
			</div>
		</span>
	</div>

	<form action="register.php">
		<div class="container">
			<hr style="height:0px; visibility:hidden;" />
			<hr style="height:0px; visibility:hidden;" />
				<label for="name"><b>Name</b></label>
				<input type="text" placeholder="Enter Name" name="name" required>
		
				<label for="middle_name"><b>Middle Name</b></label>
				<input type="text" placeholder="Enter Middle Name" name="middle_name">
		
				<label for="surname"><b>Surname</b></label>
				<input type="text" placeholder="Enter Surname" name="surname" required>
		
				<label for="username"><b>Username</b></label>
				<input type="text" placeholder="Enter Username" name="username" required>
		
			<label for="age"><b>Age</b></label>
			<br/>
			<input type="date" placeholder="Enter Age" name="age" required>

			<label for="email"><b>Email</b></label>
			<input type="text" placeholder="Enter Email" name="email" required>

			<label for="psw"><b>Password</b></label>
			<input type="password" placeholder="Enter Password" name="psw" required>

			<label for="psw-repeat"><b>Repeat Password</b></label>
			<input type="password" placeholder="Repeat Password" name="psw-repeat" required>
		
			<hr>
			<button type="submit" class="registerbtn">Register</button>
		</div>
	  
		<div class="container signin">
			<p>Already have an account? <a href="../index.php">Sign in</a>.</p>
		</div>
	</form>









	<script>
		var x, i, j, selElmnt, a, b, c;

		x = document.getElementsByClassName("custom-select");
		for (i = 0; i < x.length; i++)
		{
			selElmnt = x[i].getElementsByTagName("select")[0];
			a = document.createElement("DIV");
			a.setAttribute("class", "select-selected");
			a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
			x[i].appendChild(a);
			b = document.createElement("DIV");
			b.setAttribute("class", "select-items select-hide");
			for (j = 0; j < selElmnt.length; j++)
			{
				c = document.createElement("DIV");
				c.innerHTML = selElmnt.options[j].innerHTML;
				c.addEventListener("click", function(e)
				{
					var y, i, k, s, h;
					s = this.parentNode.parentNode.getElementsByTagName("select")[0];
					h = this.parentNode.previousSibling;
					for (i = 0; i < s.length; i++)
					{
						if (s.options[i].innerHTML == this.innerHTML)
						{
							s.selectedIndex = i;
							h.innerHTML = this.innerHTML;
							y = this.parentNode.getElementsByClassName("same-as-selected");
							for (k = 0; k < y.length; k++)
							{
								y[k].removeAttribute("class");
							}
							this.setAttribute("class", "same-as-selected");
							break;
						}
					}
					h.click();
				});
				b.appendChild(c);
			}
			x[i].appendChild(b);
			a.addEventListener("click", function(e)
			{
				e.stopPropagation();
				closeAllSelect(this);
				this.nextSibling.classList.toggle("select-hide");
				this.classList.toggle("select-arrow-active");
			});
		}
		
		function closeAllSelect(elmnt)
		{
			var x, y, i, arrNo = [];
			x = document.getElementsByClassName("select-items");
			y = document.getElementsByClassName("select-selected");
			for (i = 0; i < y.length; i++)
			{
				if (elmnt == y[i])
				  arrNo.push(i)
				else
				  y[i].classList.remove("select-arrow-active");
			}
			
			for (i = 0; i < x.length; i++)
			{
				if (arrNo.indexOf(i))
					x[i].classList.add("select-hide");
			}
		}

		document.addEventListener("click", closeAllSelect);
		
		
		
		
		
		
		
		

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