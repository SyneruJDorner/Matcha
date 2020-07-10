<?php
    session_start();

    if(isset($_GET['uname']) && isset($_GET['uemail']))
    {
        include '../config/database.php';
        
        $name = $_GET['uname'];
        $email = $_GET['uemail'];

        $newPassword = randomPassword();
        $databasePassword = hash("sha512", $newPassword);

        $sql = "use matcha";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        
        $stmt = $connection->prepare("UPDATE registered_users SET password=:databasePassword WHERE username=:name");
        $result = $stmt->execute(array(':databasePassword' => $databasePassword, ':name' => $name));

        if ($result)
            echo "<script>alert(\"Reset password.\")</script>";
        else
            echo "<script>alert(\"Failed to reset password.\")</script>";

        $to = $email;
        $subject = "Reset password";
        $message = "Dear " . $name . "\n";
        $message .= "Your password has been reset, please use the following password:\n";
        $message .= $newPassword . "\n";
        $message .= "\n";
        $message .= "You can edit the password under 'edit' once you log in" . "\n";
        $headers  = 'From: justicev18@gmail.com' . "\r\n" .
                    'MIME-Version: 1.0' . "\r\n" .
                    'Content-type: text/html; charset=utf-8';
        mail($to, $subject, $message, $headers);
        //$_SESSION["Reset_Password"] = true;
        header("Location: ../index.php");
    }

    function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
?>