<?php include '_PHP_Page_Includes/Include_Index.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"><meta http-equiv="Pragma" content="no-cache"><meta http-equiv="Expires" content="0"><meta charset="utf-8">
        <title>Matcha</title>
        <meta name="generator" content="Google Web Designer 4.2.0.0802">
        <link rel="stylesheet" text="text/css" href="CSS/Index_CSS.css">
    </head>

    <body class="htmlNoPages">
        <div id="header_bar">
            <span>
                <h1 style="padding-left:260px; color:white; margin: 0px; font-size: calc(14px + .5vw);">
                <?php
                    echo "Welcome! ";
                    
                    if (isset($_SESSION['username']))
                        echo $_SESSION['name'] . " " . $_SESSION['middle_name'] . " " . $_SESSION['surname'];
                ?>
                </h1>
                <h3 style="padding-left:260px; color:white; margin: 0px; font-size: calc(12px + .5vw);">
                <?php
                    if (!isset($_SESSION['username']))
                        echo "You will need to signup or register an account before you can proceed any further!";
                    else
                        echo "You appear to be long in, simply click the options tab and home to continue.";
                ?>
                </h3>
                
                <div>
                    <button class="dropdown_menu_button dropdown_menu_button_roundness">
                        <img class="dropdown_menu_imge_overlay" onclick="DisplayDropdown();" src="http://localhost/Matcha/UI/Dropdown_Menu.png" style="position:relative; height:75%; width:75%; top:1px;"></img>
                        <button HIDDEN onclick="DisplayDropdown()" class="dropdown_menu_button dropdown_menu_button_roundness"></button>
                    </button>
                    
                    <div id="myDropdown" class="dropdown-content">
                        <?php
                            if(isset($_SESSION['username']))
                            {
                                echo '<a href="./home.php?page=1">Home</a>';
                                echo '<a href="./edit_account.php">Edit Account</a>';
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
                </div>
            </span>
            
            <div id="LogReg_Box">
                <ul>
                    <button name="login_button" onclick="document.getElementById('id01').style.display='block'">Login</button>
                    
                    <form action="Register/register.php" method="post">
                        <button>Register</button>
                    </form>
                    
                    <a href="Forgot Info/forgot_account.php" id="forgot_account">Forgot Account</a>
                </ul>
            </div>
        </div>
        
        <div class="parallax"></div>
        <div style="height: 400px; background-color: #d1341f; font-size: 36px;">
            Disply some people here.
        </div>
        <div style="height: 400px; background-color: white; font-size: 36px;">
            Talk about features of this dating site
        </div>
        <div style="height: 400px; background-color: #ff5656; font-size: 36px;">
            basic search to show some people
        </div>
        <div id="footer_bar" style="font-size: calc(25px + .5vw); color:white;">
            Footer info here
        </div>

        <div id="id01" class="modal">
            <form class="modal-content animate" method="post" action="Login/login.php">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                    <img src="http://localhost/Matcha/UI/Default.png" alt="Avatar" class="avatar" style="max-width:128px; max-height:128px;">
                </div>

                <div class="container">
                    <label for="uname"><b>Username</b></label>
                    <input type="text" placeholder="Enter Username" name="uname" required>

                    <label for="psw"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="psw" required>
                        
                    <button type="submit">Login</button>
                    <label>
                        <input type="checkbox" checked="checked" name="remember"> Remember me
                    </label>
                </div>

                <div class="container" style="background-color:#f1f1f1">
                    <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                    <span class="psw">Forgot <a href="#">password?</a></span>
                </div>
            </form>
        </div>

        <script type="text/javascript" src="_JS_Page_Includes/JS_Index.js"></script>
    </body>
</html>