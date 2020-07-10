function DisplayDropdown()
{
    document.getElementById("myDropdown").classList.toggle("show");
}

(function()
{
    window.onresize = displayWindowSize;
    window.onload = displayWindowSize;

    function displayWindowSize()
    {
        myWidth = window.innerWidth;
        myHeight = window.innerHeight;
        var newstartingPosForProfileInfo = myHeight - 52;
        var x = document.getElementById("container").style;
        x.marginTop  = newstartingPosForProfileInfo + "px";
    };
})();

window.onclick = function(event)
{
    if (!event.target.matches('.dropdown_menu_button') && 
        !event.target.matches('.dropdown_menu_imge_overlay'))
    {
        var dropdowns = document.getElementsByClassName("dropdown_menu_content");
        var i;
        for (i = 0; i < dropdowns.length; i++)
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

function Like_Unlike_User(profile_username)
{
    var like_unlike_btn = document.getElementById("like_unlike_btn");
    
    var likeNum = 0;

    alert(profile_username);

    if (like_unlike_btn.innerHTML.trim() == "Unlike")
    {
        likeNum = 1;
        like_unlike_btn.innerHTML = "Like";
        var chat_form = document.getElementById("chat_form");
        chat_form.action = null;
        chat_form.innerHTML = '';
    }
    else
    {
        likeNum = -1;
        like_unlike_btn.innerHTML = "Unlike";
        
        document.getElementById("chat_form").action = './Chatrooms/chatroom.php?user_chat=' + profile_username;
        
        var btn = document.createElement("BUTTON");
        btn.className = "profile_btn";
        var txt = document.createTextNode("Chat");
        btn.appendChild(txt);
        document.getElementById("chat_form").appendChild(btn);
    }
        
    $.ajax(
    {
        url: 'AJAX Functions/Set/update_like_profiles.php',
        data:
        {
            action: 'UpdateLikedProfiles',
            arguments: { username:profile_username, like:likeNum }
        },
        type: 'post',
        success: function(output)
        {
            alert (output);
        }
    });
}

function block_user(user_info, my_info)
{
    $.ajax(
    {
        url: 'AJAX Functions/Set/block_user.php',
        data:
        {
            action: 'BlockUser',
            arguments: { block_user_info:user_info, blocking_user_info:my_info }
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

function report_user(user_info, my_info)
{
    $.ajax(
    {
        url: 'AJAX Functions/Set/report_user.php',
        data:
        {
            action: 'ReportUser',
            arguments: { report_user:user_info, user_requesting:my_info }
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




















var modal = document.getElementById('myModal');
var modalImg = document.getElementById("img01");

for(var i = 0; i < 5; i++)
{
    var img = document.getElementById('profile_image_' + (i + 1));
    
    img.onclick = function()
    {
        modal.style.display = "block";
        modalImg.src = this.src;
        document.body.scroll = "no";
        document.body.style.overflow = "hidden";
    }

    var span = document.getElementsByClassName("close")[0];

    span.onclick = function()
    { 
        modal.style.display = "none";
        document.body.scroll = "yes";
        document.body.style.overflow = "auto";
    }
}


















$(window).on('beforeunload', function()
{
    $(window).scrollTop(0);
});