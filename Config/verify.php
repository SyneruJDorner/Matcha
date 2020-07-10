<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
    include 'database.php';
    $id;
    $code;

    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        if ($id == null)
        {
            $_SESSION['message'] = "Account confirmation error!";
            header('location: error.php');
            return;
        }
    }

    if(isset($_GET['code']))
    {
        $code = $_GET['code'];
        if ($code == null)
        {
            $_SESSION['message'] = "Account confirmation error!";
            header('location: error.php');
            return;
        }
    }

	$sql = "use matcha";
	$stmt = $connection->prepare($sql);
	$stmt->execute();

    $stmt = $connection->prepare("SELECT * FROM registered_users WHERE ID=:ID");
    $stmt->execute(array(':ID' => $id));

    while($row = $stmt->fetch())
    {
        if ($row['registered_account'] == 1)
        {
            $_SESSION['message'] = "Account confirmation error!";
            header('location: ../Notifications/error.php');
            return;
        }
    }
	
	echo "Here 0 <br/>";
	
    $sql = ("UPDATE registered_users SET registered_account=1 WHERE ID=:ID AND confirmation_code=:code");
    $stmt = $connection->prepare($sql);
	$stmt->execute(array(':ID' => $id, ':code' => $code));
	$_SESSION['message'] = "Your account has been confirmed, you may now log in!";
    header("location: ../index.php");
?>