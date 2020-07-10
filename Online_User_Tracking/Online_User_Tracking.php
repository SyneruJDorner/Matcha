<!DOCTYPE html>
<html>
<head></head>

<body>
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
        <script type="text/javascript">
            setInterval (NotifyServerStillOnline, 1000);	//Reload file every 0.5 seconds

            function NotifyServerStillOnline()
            {
                var currentPath = window.location.host + window.location.pathname;
                var res = currentPath.split("/");
                var backCount = res.length - 3;
                var rightPath = "";
                for(var i = 0; i < backCount; i++)
                {
                    rightPath += "../";
                }
                rightPath += "Online_User_Tracking/Online_Server_Tracking.php";
                
                $.ajax(
                {
                    url: rightPath,
                    data:
                    {
                        action: 'UpdateOnlineStatus',
                        arguments: null
                    },
                    type: 'post',
                    success: function(output)
                    {
                        //alert(output);
                    }
                });
            }
        </script>
</body>
</html>