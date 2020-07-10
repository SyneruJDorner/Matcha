<?php
        if (session_status() == PHP_SESSION_NONE)
                session_start();

        if(isset($_POST['action']) && !empty($_POST['action']))
        {
            $action = $_POST['action'];
            $lat = isset($_POST['arguments']['lat']) ? $_POST['arguments']['lat'] : "";
            $lon = isset($_POST['arguments']['long']) ? $_POST['arguments']['long'] : "";

            if ($action == "Use_GPS")
                Update_Info_GPS($lat, $lon);
            else
                Update_Info_GPS(null, null);
        }

        function Update_Info_GPS($lat, $long )
        {
            $arr_location = file_get_contents('http://ip-api.com/json/');
            $online_info = json_decode($arr_location);
            
            $_SESSION['IP'] = $online_info->query;
            $_SESSION['lat'] = ($lat != null)   ? $lat      : $online_info->lat;
            $_SESSION['lon'] = ($long  != null) ? $long     : $online_info->lon;
            $_SESSION['country'] = $online_info->country;
            $_SESSION['regionName'] = $online_info->regionName;
            $_SESSION['city'] = $online_info->city;
            
            
            



            //Save info
            $connection;
            $dbname = 'matcha';
            $username = 'Test';
            $password = "Password1234";
            
            $options = [
                        PDO::MYSQL_ATTR_FOUND_ROWS => true,
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                       ]; 
            $connection = new PDO("mysql:host=localhost", $username, $password, $options);//array(PDO::MYSQL_ATTR_FOUND_ROWS => true);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $stmt = $connection->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =:dbname");
            $stmt->execute(array(":dbname"=>$dbname));
            
            $username = $_SESSION['username'];
            $sql = "use matcha";
            $connection->exec($sql);

            $sql = "UPDATE registered_users SET user_ip=:user_ip, online_status=:online_status, latitude=:latitude, longitude=:longitude, country=:country, regionName=:regionName, city=:city WHERE username=:username";
            $stmt = $connection->prepare($sql);
            $stmt->execute(array(
                            ':user_ip' => $_SESSION['IP'],
                            ':online_status' => "true",
                            ':latitude' => $_SESSION['lat'],
                            ':longitude' => $_SESSION['lon'],
                            ':country'  => $_SESSION['country'],
                            ':regionName' => $_SESSION['regionName'],
                            ':city' => $_SESSION['city'],
                            ':username' => $username));
        }
?>