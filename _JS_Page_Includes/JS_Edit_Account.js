$(document).ready(function()
{
    var reply_click = function()
    {
        $objects_ID = this.id;
        var $text = $(this),
        $input = $('<input id=' + $text.id + "_change" + ' style="display: block;" type="text" />');

        $text.hide().after($input);

        $input.val($text.html()).show().focus().keypress(function(e)
        {
            var key = e.which
            if (key == 13) // enter key
            {
                $input.hide();
                /////
                var newVal = $input.val().replace(/</g, "&lt;").replace(/>/g, "&gt;");
                $text.html(newVal).show();
                
                
                
                
                
                var currentURL = 	($objects_ID == "name_field") 			? 'AJAX Functions/Set/update_fisrtname.php' 	: 
                                    ($objects_ID == "middlename_field") 	? 'AJAX Functions/Set/update_middlename.php'	:
                                    ($objects_ID == "surname_field") 		? 'AJAX Functions/Set/update_lastname.php'		:
                                    ($objects_ID == "email_field") 			? 'AJAX Functions/Set/update_email.php'			:
                                                                                'AJAX Functions/Set/update_bio.php';
                                    
                var args = $text.html();
                
                $.ajax(
                {
                    url: currentURL,
                        data:
                        {
                            action: 'UpdateItem',
                            arguments: args
                        },
                        type: 'post',
                        success: function(output)
                        {
                            //alert("edited");
                        }
                });
                
                
                
                
                return false;
            }
        }).
        focusout(function()
        {
            $input.hide();
            $text.show();
        })
    }
    
    document.getElementById('name_field').onclick = reply_click;
    document.getElementById('middlename_field').onclick = reply_click;
    document.getElementById('surname_field').onclick = reply_click;
    document.getElementById('email_field').onclick = reply_click;
    document.getElementById('bio_field').onclick = reply_click;
});




function Update_Password()
{
    var pass1 = document.getElementById("new_password").value;
    var pass2 = document.getElementById("new_renter_password").value;

    if (pass1.length < 8)
    {
        alert("The password entered is to short (must be at least 8 characters).");
        return;
    }

    if (pass1.match(/\d/g) == null)
    {
        alert("The password needs to have a number in it.");
        return;
    }

    if (pass1.match(/[a-z]/g) == null)
    {
        alert("The password need to have a lowercase letter in it.");
        return;
    }

    if (pass1.match(/[A-Z]/g) == null)
    {
        alert("The password need to have a uppercase letter in it.");
        return;
    }
    
    if (pass1 != pass2)
    {
        alert("The passwords entered do not match.");
        return;
    }

    $.ajax(
    {
        url: 'AJAX Functions/Set/update_password.php',
            data:
            {
                action: 'UpdatePassword',
                arguments: pass1
            },
            type: 'post',
            success: function(output)
            {
                document.getElementById('id02').style.display='none';
                document.getElementById("new_password").value = null;
                document.getElementById("new_renter_password").value = null;
                pass1 = null;
                pass2 = null;
                //alert(output);
                //$('#selection_image').attr('src', output);
            }
    });
}

setUpElement();

function setUpElement()
{
    var x, i, j, selElmnt, a, b, c;
    
    var doc = document;
    x = document.getElementsByClassName("custom-select");
    for (i = 0; i < x.length; i++)
    {
        var currentURL = 	(i == 0) ? 	'PHP Requests/request_current_gender.php' 		:
                            (i == 1) ? 	'PHP Requests/request_current_gender_pref.php' 	:
                            (i == 2) ?	'PHP Requests/request_current_ethnicity.php' 	:
                                        'PHP Requests/request_current_ethnicity_pref.php';
        
        var set_position = 0;
        $.ajax(
        {
            url: currentURL,
            data:
            {
                action: 'GetInfo',
                arguments: i
            },
            type: 'post',
            success: function(output)
            {
                set_dropdown_option(output);
            }
        });
    }
}

function set_dropdown_option(output)
{
    var array_items = output.split(", ");
    var itemName = array_items[0];
    var itemPosition = parseInt(array_items[1], 10);
    var currentSelection = 	(itemName == "male" || itemName == "american indian")	? 1 :
                            (itemName == "female" || itemName == "asian") 			? 2 :
                            (itemName == "black") 									? 3 :
                            (itemName == "indian") 									? 4 :
                            (itemName == "hispanic/latino") 						? 5 :
                            (itemName == "multiracial") 							? 6 :
                            (itemName == "native hawaiian") 						? 7 :
                            (itemName == "white") 									? 8 :
                                                                                        0;
    x = document.getElementsByClassName("custom-select");
    
    selElmnt = x[itemPosition].getElementsByTagName("select")[0];
    a = document.createElement("DIV");
    a.setAttribute("class", "select-selected");
    
    a.innerHTML = selElmnt.options[currentSelection].innerHTML;
    x[itemPosition].appendChild(a);
    b = document.createElement("DIV");
    b.setAttribute("class", "select-items select-hide");
    for (j = 0; j < selElmnt.length; j++)
    {
        c = document.createElement("DIV");
        c.innerHTML = selElmnt.options[j].innerHTML;
        c.addEventListener("click", function(e)
        {
            var y, i, k, s, h;
            s = this.parentNode.parentNode.getElementsByTagName("select")[0];
            h = this.parentNode.previousSibling;
            for (i = 0; i < s.length; i++)
            {
                if (s.options[i].innerHTML == this.innerHTML)
                {
                    s.selectedIndex = i;
                    h.innerHTML = this.innerHTML;
                    y = this.parentNode.getElementsByClassName("same-as-selected");
                    for (k = 0; k < y.length; k++)
                    {
                        y[k].removeAttribute("class");
                    }
                    this.setAttribute("class", "same-as-selected");
                    break;
                }
            }
            h.click();
        });
        b.appendChild(c);
    }
    x[itemPosition].appendChild(b);
    a.addEventListener("click", function(e)
    {
        e.stopPropagation();
        closeAllSelect(this);
        this.nextSibling.classList.toggle("select-hide");
        this.classList.toggle("select-arrow-active");
    });
}

function closeAllSelect(elmnt)
{
    var x, y, i, arrNo = [];
    x = document.getElementsByClassName("select-items");
    y = document.getElementsByClassName("select-selected");
    for (i = 0; i < y.length; i++)
    {
        if (elmnt == y[i])
        {
            arrNo.push(i);
            //alert(elmnt.parentElement.id);
            var currentURL = 	(elmnt.parentElement.id == "gender") ? 'AJAX Functions/Set/update_gender.php' :
                                (elmnt.parentElement.id == "sexual_pref") ? 'AJAX Functions/Set/update_gender_pref.php' :
                                (elmnt.parentElement.id == "ethnicity") ? 'AJAX Functions/Set/update_ethnicity.php' :
                                (elmnt.parentElement.id == "ethnicity_pref") ? 'AJAX Functions/Set/update_ethnicitypref.php' :
                                '';
            
            $.ajax(
            {
                url: currentURL,
                    data:
                    {
                        action: 'UpdateGender',
                        arguments: elmnt.innerHTML.toLowerCase()
                    },
                    type: 'post',
                    success: function(output)
                    {
                        //alert(elmnt.innerHTML);
                        //$('#selection_image').attr('src', output);
                    }
            });
        }
        else
            y[i].classList.remove("select-arrow-active");
    }
    
    for (i = 0; i < x.length; i++)
    {
        if (arrNo.indexOf(i))
            x[i].classList.add("select-hide");
    }
}

document.addEventListener("click", closeAllSelect);

function DisplayDropdown()
{
    document.getElementById("myDropdown").classList.toggle("show");
}

var modal_02 = document.getElementById('id02');

window.onclick = function(event)
{
    if (event.target == modal_02)
    {
        modal_02.style.display = "none";
    }

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






















var counter = 0;
var selected_hashtags = [];
autocomplete(document.getElementById("hashtags_input"), hashtags);

LoadUserHashTags();

function LoadUserHashTags()
{
    $.ajax(
    {
        url: 'PHP Requests/request_current_likes.php',
        data:
        {
            action: 'RequestUserLikes',
            arguments: null
        },
        type: 'post',
        success: function(output)
        {
            output = output.split(", ");

            for(var counter = 1; counter <= output.length; counter++)
            {
                var currentURI = window.document.location.href.toString().replace("edit_account.php", "http://localhost/Matcha/UI/X.png");
                var current_id = "hashtag_" + counter;
                var current_name = "hashtag_" + counter;
                var current_class = "hashtag_" + counter;
                var hashTagName = output[counter - 1];
                
                var newHtml = '<div class=' + current_class + ' id=' + current_id + ' name=' + current_name + '>';
                newHtml += '<img src="' + currentURI + '" width="15px" height="15px" onclick="removeElement(\'' + current_name.toString() + '\');"/>';
                newHtml += "   " + toTitleCase(hashTagName).replaceAll(" ", "") + "<br/>";
                newHtml += '</div>';
                
                document.getElementById('dynamic-hashtags').innerHTML += newHtml;
            }
        }
    });
}

function AddHashtag()
{
    if (document.getElementById('hashtags_input').value != null)
    {
        doc = document.getElementById("dynamic-hashtags");
        counter = doc.childNodes.length + 1;

        var currentURI = window.document.location.href.toString().replace("first_time_login.php", "http://localhost/Matcha/UI/X.png");
        var current_id = "hashtag_" + counter;
        var current_name = "hashtag_" + counter;
        var current_class = "hashtag_" + counter;
        var hashTagName = document.getElementById('hashtags_input').value.toLowerCase().replaceAll("#", "").toString();
        hashTagName = hashTagName.charAt(0).toUpperCase()  + hashTagName.substring(1);
        
        if (hashTagName.length <= 0)
        {
            alert("You cannot have an empty entry!");
            return;
        }

        if(selected_hashtags.includes("#"+hashTagName) == true)
        {
            alert("You have already listed this HashTag as something you like!");
            document.getElementById('hashtags_input').value = null;
            return;
        }
        
        var newHtml = '<div class=' + current_class + ' id=' + current_id + ' name=' + current_name + '>';
        newHtml += '<img src="' + currentURI.replace("edit_account.php", "http://localhost/Matcha/UI/X.png") + '" width="15px" height="15px" onclick="removeElement(\'' + current_name.toString() + '\');"/>';
        newHtml += "   " + "#" + toTitleCase(hashTagName).replaceAll(" ", "") + "<br/>";
        newHtml += '</div>';
        
        var taggedName = hashTagName;
        hashtags.push("#" + taggedName);
        selected_hashtags.push("#" + taggedName);
        autocomplete(document.getElementById("hashtags_input"), hashtags);
        
        document.getElementById('dynamic-hashtags').innerHTML += newHtml;
        document.getElementById('hashtags_input').value = null;
        
        $.ajax(
        {
            url: 'AJAX Functions/Set/add_new_hashtag.php',
                data:
                {
                    action: 'AddHashTag',
                    arguments: taggedName
                },
                type: 'post',
                success: function(output)
                {
                    //alert(output);

                    var hashtag_array = [];
                    //alert(doc.childNodes.length);
                    for (var i = 0; i < doc.childNodes.length; i++)
                    {
                        var newElement = document.getElementById("hashtag_" + (i + 1));
                        if (newElement != null)
                        {
                            var innerHTML = newElement.innerHTML;
                            var start_pos = innerHTML.indexOf('>') + 1;
                            var end_pos = innerHTML.indexOf('<', start_pos);
                            var text_to_get = innerHTML.substring(start_pos, end_pos);
                            hashtag_array.push(text_to_get.trim());
                        }							
                    }
                    
                    $.ajax(
                    {
                        url: 'AJAX Functions/Set/update_interests.php',
                            data:
                            {
                                action: 'UpdateInterests',
                                arguments: hashtag_array
                            },
                            type: 'post',
                            success: function(output)
                            {
                                //serverTasks++;
                                //changePage(serverTasks);
                                //alert(output);
                            }
                    });
                }
        });
    }
}

function toTitleCase(str)
{
    return str.replace(/\w\S*/g, function(txt){
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
}

String.prototype.replaceAll = function(str1, str2, ignore) 
{
    return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
}

function removeElement(elementId)
{
    doc = document.getElementById("dynamic-hashtags");
    var hashtag_array = [];
    var changeIDs = false;
    
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
    if (doc.childNodes.length != 0)
    {
        for (var i = 0; i < doc.childNodes.length + 1; i++)
        {
            if (elementId == "hashtag_" + (i + 1))
            {
                changeIDs = true;
            }
            else
            {
                if (changeIDs == false)
                {
                    var newElement = document.getElementById("hashtag_" + (i + 1));
                    if (newElement == null)
                        continue;
                    var innerHTML = newElement.innerHTML;
                    var start_pos = innerHTML.indexOf('>') + 1;
                    var end_pos = innerHTML.indexOf('<', start_pos);
                    var text_to_get = innerHTML.substring(start_pos, end_pos);
                    hashtag_array.push(text_to_get.trim());
                }
                else
                {
                    var newElement = document.getElementById("hashtag_" + (i + 1));
                    if (newElement == null)
                        continue;

                    newElement.id = "hashtag_" + i;
                    newElement.classList = "hashtag_" + i;
                    newElement.setAttribute("name", "hashtag_" + i);
                    newElement.childNodes[0].setAttribute("onclick", "removeElement('hashtag_" + i + "');");
                
                    var innerHTML = newElement.innerHTML;
                    var start_pos = innerHTML.indexOf('>') + 1;
                    var end_pos = innerHTML.indexOf('<', start_pos);
                    var text_to_get = innerHTML.substring(start_pos, end_pos);
                    hashtag_array.push(text_to_get.trim());
                }
            }			
        }
    }
    
    $.ajax(
    {
        url: 'AJAX Functions/Set/update_interests.php',
            data:
            {
                action: 'UpdateInterests',
                arguments: hashtag_array
            },
            type: 'post',
            success: function(output)
            {
                //serverTasks++;
                //changePage(serverTasks);
                //alert(output);
            }
    });
}

function autocomplete(inp, arr)
{
    var currentFocus;
    inp.addEventListener("input", function(e)
    {
        var a, b, i, val = this.value; 
        closeAllLists();
        if (!val)
            return false;
        currentFocus = -1;
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        this.parentNode.appendChild(a);
        for (i = 0; i < arr.length; i++)
        {
            if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase())
            {
                b = document.createElement("DIV");
                b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(val.length);
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                b.addEventListener("click", function(e)
                {
                    inp.value = this.getElementsByTagName("input")[0].value;
                    /////inp.value = inp.value .replace(/</g, "&lt;").replace(/>/g, "&gt;");
                    closeAllLists();
                });
                a.appendChild(b);
            }
        }
    });
    
    inp.addEventListener("keydown", function(e)
    {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40)
        {
            currentFocus++;
            addActive(x);
        }
        else if (e.keyCode == 38)
        {
            currentFocus--;
            addActive(x);
        }
        else if (e.keyCode == 13)
        {
            e.preventDefault();
            if (currentFocus > -1)
            {
                if (x)
                    x[currentFocus].click();
            }
        }
    });
    
    function addActive(x)
    {
        if (!x)
            return false;
        removeActive(x);
        if (currentFocus >= x.length)
            currentFocus = 0;
        if (currentFocus < 0)
            currentFocus = (x.length - 1);
        x[currentFocus].classList.add("autocomplete-active");
    }
    
    function removeActive(x)
    {
        for (var i = 0; i < x.length; i++)
        {
            x[i].classList.remove("autocomplete-active");
        }
    }
    
    function closeAllLists(elmnt)
    {
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++)
        {
            if (elmnt != x[i] && elmnt != inp)
                x[i].parentNode.removeChild(x[i]);
        }
    }
    
    document.addEventListener("click", function (e)
    {
        closeAllLists(e.target);
    });
}














function OpenImgUpload(image_number)
{
    var clickedElement = "";
    clickedElement = '#imgupload_' + image_number;
    $(clickedElement).trigger('click');
}

$(document).ready(function()
{
    function readURL(image_number, input)
    {
        var clickedElement = "";
        clickedElement = '#profile_image_' + image_number;
        
        if (input.files.length > 0)
        {
            var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();

            if (input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
            {
                var reader = new FileReader();

                reader.onload = function (e)
                {
                    $(clickedElement).attr('src', e.target.result);
                    
                    var profile_images = [];
                    profile_images.push(document.getElementById("profile_image_1").src);
                    profile_images.push(document.getElementById("profile_image_2").src);
                    profile_images.push(document.getElementById("profile_image_3").src);
                    profile_images.push(document.getElementById("profile_image_4").src);
                    profile_images.push(document.getElementById("profile_image_5").src);
                        
                    $.ajax(
                    {
                        url: 'AJAX Functions/Set/update_image_profiles.php',
                        data:
                        {
                            action: 'AddProfileImages',
                            arguments: profile_images
                        },
                        type: 'post',
                        success: function(output)
                        {
                            document.getElementById("profile_picture_1").src = document.getElementById("profile_image_1").src;
                            document.getElementById("profile_picture_2").src = document.getElementById("profile_image_2").src;
                            document.getElementById("profile_picture_3").src = document.getElementById("profile_image_3").src;
                            document.getElementById("profile_picture_4").src = document.getElementById("profile_image_4").src;
                            document.getElementById("profile_picture_5").src = document.getElementById("profile_image_5").src;
                        
                            $.ajax(
                            {
                                url: './PHP Requests/request_active_profile_image.php',
                                data:
                                {
                                    action: 'RequestActiveProfileImage',
                                    arguments: null
                                },
                                type: 'post',
                                success: function(output)
                                {
                                    document.getElementById("selection_image").src = output;
                                }
                            });
                        }
                    });
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        else
            $(clickedElement).attr('src', "http://localhost/Matcha/UI/Default.png");
    }
    
    $("#imgupload_1").on("change", function(){ readURL(1, document.getElementById("imgupload_1")); });
    $("#imgupload_2").on("change", function(){ readURL(2, document.getElementById("imgupload_2")); });
    $("#imgupload_3").on("change", function(){ readURL(3, document.getElementById("imgupload_3")); });
    $("#imgupload_4").on("change", function(){ readURL(4, document.getElementById("imgupload_4")); });
    $("#imgupload_5").on("change", function(){ readURL(5, document.getElementById("imgupload_5")); });
});