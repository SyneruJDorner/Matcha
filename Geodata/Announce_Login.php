<?php
function Store_IP_Info($connection)
{
        if (session_status() == PHP_SESSION_NONE)
                session_start();

        echo '<script src="https://code.jquery.com/jquery-3.3.1.js"></script>';
        echo '<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>';
        echo '<script type="text/javascript">';
        echo   '
                if(navigator.geolocation)
                {
                        browserSupportFlag = true;
                        navigator.geolocation.getCurrentPosition(function(position)
                        {
                                var latitude = position.coords.latitude;
                                var longitude = position.coords.longitude;
                                
                                sessionStorage.Use_GPS = "true";
                                sessionStorage.setItem("Use_GPS", "true");
                                sessionStorage.setItem("lat", latitude);
                                sessionStorage.setItem("lon", longitude);
                                
                                $.ajax(
                                {
                                        url: "./Geodata/Set_Geo_Info.php",
                                        data:
					{
						action: "Use_GPS",
						arguments: { lat:latitude, long:longitude }
					},
                                        type: "post",
                                        success: function(output){}
                                });
                        },
                        function()
                        {
                                alert("Geolocation failed, you have not given rights to track you through gps.");
                                $.ajax(
                                        {
                                                url: "./Geodata/Set_Geo_Info.php",
                                                data:
                                                {
                                                        action: "Dont_Use_GPS",
                                                        arguments: "NULL"
                                                },
                                                type: "post",
                                                success: function(output){}
                                        });
                        });
                }';
        echo '</script>';
}
?>