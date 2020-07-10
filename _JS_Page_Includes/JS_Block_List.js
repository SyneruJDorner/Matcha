window.start = function()
{
    var url = "localhost/matcha";
    if ("onhashchange" in window)
    {
        alert("The browser supports the hashchange event!");
    }

    function locationHashChanged()
    {
        if (location.hash != url)
        {
            alert('change url');
        }
    }

    window.onhashchange = locationHashChanged;
}

function unblock_user(user_to_unblock, my_info)
{
    var blocked_user_info = new Array();
    blocked_user_info[0] = user_to_unblock;

    var blocking_user_info = new Array();
    blocking_user_info[0] = my_info;

    $.ajax(
    {
        url: 'AJAX Functions/Set/unblock_user.php',
        data:
        {
            action: 'UnblockUser',
            arguments: { blocked_user_info:blocked_user_info, blocking_user_info:blocking_user_info }
        },
        type: 'post',
        success: function(output)
        {
            if (output == "Return Home")
            {
                window.location.href = "./home.php?page=0";
                return;
            }
        }
    });
}


setInterval (UpdateUsersOnlineOffline, 500);	//Reload file every 0.5 seconds
function UpdateUsersOnlineOffline()
{
    $.ajax(
    {
        url: 'AJAX Functions/Get/online_user_list.php',
        data:
        {
            action: 'GetOnlineUserStatus',
            arguments: null
        },
        type: 'post',
        success: function(output)
        {
            var infoArray = output.split(", ");
            var fullArray = infoArray.filter(function(v){return v!==''});
            var newarr = [];

            for(var i = 0; i < fullArray.length; i++)
            {
                var splitUserTimeInfo = fullArray[i].split("@-@");
                var userArray = splitUserTimeInfo[0];
                var timeArray = splitUserTimeInfo[1];
                
                var searchAllowedUser = document.getElementById("founduser_" + userArray);
                
                if (searchAllowedUser == null)
                    continue;
                newarr.push(userArray + "@-@" + timeArray);
            }

            for(var i = 0; i < newarr.length; i++)
            {
                var splitUserTimeInfo = newarr[i].split("@-@");
                var userArray = splitUserTimeInfo[0];
                var timeArray = splitUserTimeInfo[1];

                var d1 = new Date();
                d1.toUTCString();
                var currentTimeStamp = Math.floor(d1.getTime() / 1000);
                var lastOnlineTimeStamp = Math.round(Date.parse(timeArray) / 1000);
                var userTimeElement = document.getElementById("Online_Status_" + i);
                
                if (userTimeElement != null)
                {
                    if (currentTimeStamp - lastOnlineTimeStamp > 1)
                    {
                        userTimeElement.src="http://localhost/Matchattp://localhost/Matcha/UI/Offline.png";
                        userTimeElement.title = "Offline";
                    }
                    else
                    {
                        userTimeElement.src="http://localhost/Matchattp://localhost/Matcha/UI/Online.png";
                        userTimeElement.title = "Online";
                    }
                }
            }
        }
    });
}

function GoToUserPage(username_page)
{
    window.location.href = "./users_page.php?username=" + username_page;
}

function DisplayDropdown()
{
    document.getElementById("myDropdown").classList.toggle("show");
}

window.onclick = function(event)
{
    if (!event.target.matches('.dropdown_menu_button') && 
        !event.target.matches('.dropdown_menu_imge_overlay'))
    {
        var dropdowns = document.getElementsByClassName("dropdown_menu_content");
        for (var i = 0; i < dropdowns.length; i++)
        {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show'))
                openDropdown.classList.remove('show');
        }
    }
    
    if (event.target.matches('.selection_image_choice'))
    {
        var clickedItem = event.target.getAttribute('id');
        clicked_selected_image(clickedItem);
    }
}

function clicked_selected_image(alt_name)
{
    if (alt_name == "profile_picture_1" ||
        alt_name == "profile_picture_2" ||
        alt_name == "profile_picture_3" ||
        alt_name == "profile_picture_4" ||
        alt_name == "profile_picture_5")
    {
        $.ajax(
        {
            url: 'AJAX Functions/Set/update_active_profile.php',
                data:
                {
                    action: 'UpdateActiveProfile',
                    arguments: alt_name
                },
                type: 'post',
                success: function(output)
                {
                    $('#selection_image').attr('src', output);
                }
        });
    }
}