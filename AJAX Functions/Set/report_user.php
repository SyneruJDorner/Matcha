<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	if(isset($_POST['action']) && !empty($_POST['action']))
	{
		$action = $_POST['action'];
        $args = isset($_POST['arguments']) ? $_POST['arguments'] : "";
        $reported_user = $args['report_user'];
        $user_requesting = $args['user_requesting'];
		send_confirmation_mail($reported_user, $user_requesting);
	}

    function send_confirmation_mail($reported_user, $user_requesting)
    {
        if (session_status() == PHP_SESSION_NONE)
        session_start();
        
		$to         = "justicev18@gmail.com";
		$subject    = 'Reporting User';
		
		$message = "";
		$message .= 'Dear: Admin<br/>';
        $message .= 'The following user: Username=' . $reported_user[0] . "; Name=". $reported_user[1] . "; Middle name = " . $reported_user[2] . "; Surname = " . $reported_user[3] . "<br/>";// USERNAME, NAME, MIDDLE NAME, AND SURNAME;
        $message .= 'is being reported by user: Username=' . $user_requesting[0] . "; Name=". $user_requesting[1] . "; Middle name = " . $user_requesting[2] . "; Surname = " . $user_requesting[3] . "<br/>"; //+ USERNAME, NAME, MIDDLE NAME, AND SURNAME;
        $message .= 'as a fake account.'; //+ USERNAME, NAME, MIDDLE NAME, AND SURNAME;

		$headers  = 'From: justicev18@gmail.com' . "\r\n" .
					'MIME-Version: 1.0' . "\r\n" .
                    'Content-type: text/html; charset=utf-8';
        
		if(mail($to, $subject, $message, $headers))
		{
			$_SESSION['message'] = "You have successfully reported the user, an email has been send to the admins.";
            //header("location: ../home.php");
            echo "Return Home";
		}
		else
		{
			echo "reporting user has failed.";
        }
    }
    return;
?>