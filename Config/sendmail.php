<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	echo "Here 0 <br/>";
	send_confirmation_mail();
	
    function send_confirmation_mail()
    {
		include 'database.php';
		
		$name = $_GET['name'];
		$username = $_GET['username'];

		$sql = "use matcha";
		$stmt = $connection->prepare($sql);
		$stmt->execute();

		$stmt = $connection->prepare("SELECT * FROM registered_users WHERE name=:name AND username=:username");
		$stmt->execute(array(':name' => $name, ':username' => $username));
		
		echo $name . "<br/>";
		$result = $stmt->fetchAll();

		print_r($result[0]);

		$ID 		= $result[0]['ID'];
		$surname 	= $result[0]['surname'];
		$email 		= $result[0]['email'];
		$code 		= $result[0]['confirmation_code'];
		$registered = $result[0]['registered_account'];

		echo $ID . "<br/>";
		echo $email  . "<br/>";
		echo $code . "<br/>";
		echo $registered . "<br/>";

		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		$to         = $email;
		$subject    = 'Confirmation for registration on Dating Site Online';
		$actual_link = strstr($actual_link, 'sendmail', true);
		
		$message = "";
		$message .= 'Dear: ' . $name . ' ' . $surname . '<br/>';
		$message .= 'Your account needs to be activated for Dating Site Online. Please click on "Confirm" below to confirm your account.';
		$message .= '<html><body>';
		$message .= '<a href="'.$actual_link.'verify.php?id='.$ID.'&code='.$code.'">Confrim Now</a><BR>';
		$message .= '</body></html>';

		$headers  = 'From: justicev18@gmail.com' . "\r\n" .
					'MIME-Version: 1.0' . "\r\n" .
					'Content-type: text/html; charset=utf-8';
		if(mail($to, $subject, $message, $headers))
		{
			$_SESSION['message'] = "An email has been sent to your email address, please click the confirm button to continue.";
			header("location: ../index.php");
		}
		else
		{
			echo "Email sending failed";
		}
    }
    return;
?>