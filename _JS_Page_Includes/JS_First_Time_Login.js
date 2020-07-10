//get list of # items

var hashtags = GetHashtags();
var selected_hashtags = [];
autocomplete(document.getElementById("hashtags_input"), hashtags);

function isEmptyOrSpaces(str)
{
    return str === null || str.match(/^ *$/) !== null;
}

function submit_page()
{
    if (isEmptyOrSpaces(document.getElementById("bio").value))
    {
        alert("You cannot have an empty Biography! Please tell people a little about yourself.");
        return;
    }
    
    doc = document.getElementById("dynamic-hashtags");
    if (doc.childNodes.length <= 0)
    {
        alert("You cannot have an empty interests! Please tell people a little about the things you like.");
        return;
    }
    
    var serverTasks = 0;
    sessionStorage.setItem("first_time_login_completed", "1");
    
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
                serverTasks++;
                changePage(serverTasks);
                //alert(output);
            }
    });

    //Set definitions here
    var doc = null;
    doc = document.getElementById("gender");
    for (var i = 0; i < doc.childNodes.length; i++)
    {
        if (doc.childNodes[i].className == "select-selected")
        {
            //alert(doc.childNodes[i].innerHTML);
            var newVal = doc.childNodes[i].innerHTML;
            document.getElementById("gender_selection").value = newVal;
            
            $.ajax(
            {
                url: 'AJAX Functions/Set/update_gender.php',
                    data:
                    {
                        action: 'UpdateGender',
                        arguments: newVal
                    },
                    type: 'post',
                    success: function(output)
                    {
                        serverTasks++;
                        changePage(serverTasks);
                        //alert(output);
                    }
            });
            break;
        }        
    }
    
    doc = document.getElementById("sexual_pref");
    for (var i = 0; i < doc.childNodes.length; i++)
    {
        if (doc.childNodes[i].className == "select-selected")
        {
            //alert(doc.childNodes[i].innerHTML);
            var newVal = doc.childNodes[i].innerHTML;
            document.getElementById("sexual_pref_selection").value = newVal;

            $.ajax(
            {
                url: 'AJAX Functions/Set/update_gender_pref.php',
                    data:
                    {
                        action: 'UpdateGenderPref',
                        arguments: newVal
                    },
                    type: 'post',
                    success: function(output)
                    {
                        serverTasks++;
                        changePage(serverTasks);
                        //alert(output);
                    }
            });
            break;
        }        
    }
    
    
    
    
    $.ajax(
    {
        url: 'AJAX Functions/Set/update_bio.php',
            data:
            {
                action: 'UpdateBio',
                arguments: document.getElementById("bio").value
            },
            type: 'post',
            success: function(output)
            {
                serverTasks++;
                changePage(serverTasks);
                //alert(output);
            }
    });
    
    //doc = document.getElementById("bio").value;
    //alert(doc.value);
    //document.getElementById("bio_selection").value = doc.innerHTML;
    
    doc = document.getElementById("ethnicity");
    for (var i = 0; i < doc.childNodes.length; i++)
    {
        if (doc.childNodes[i].className == "select-selected")
        {
            //alert(doc.childNodes[i].innerHTML);
            
            var newVal = doc.childNodes[i].innerHTML;
            document.getElementById("ethnicity_selection").value = newVal;

            $.ajax(
            {
                url: 'AJAX Functions/Set/update_ethnicity.php',
                    data:
                    {
                        action: 'UpdateEthnicity',
                        arguments: newVal
                    },
                    type: 'post',
                    success: function(output)
                    {
                        serverTasks++;
                        changePage(serverTasks);
                        //alert(output);
                    }
            });
            break;
        }        
    }
    
    doc = document.getElementById("ethnicity_pref");
    for (var i = 0; i < doc.childNodes.length; i++)
    {
        if (doc.childNodes[i].className == "select-selected")
        {
            //alert(doc.childNodes[i].innerHTML);
            
            var newVal = doc.childNodes[i].innerHTML;
            document.getElementById("ethnicity_pref_selection").value = newVal;

            $.ajax(
            {
                url: 'AJAX Functions/Set/update_ethnicitypref.php',
                    data:
                    {
                        action: 'UpdateEthnicityPref',
                        arguments: newVal
                    },
                    type: 'post',
                    success: function(output)
                    {
                        serverTasks++;
                        changePage(serverTasks);
                        //alert(output);
                    }
            });
            break;
        }        
    }
    
    doc = document.getElementById("dynamic-hashtags");
    var hashtag_array = [];
    for (var i = 0; i < doc.childNodes.length; i++)
    {
        var newElement = document.getElementById("hashtag_" + (i + 1));
        var innerHTML = newElement.innerHTML;
        var start_pos = innerHTML.indexOf('>') + 1;
        var end_pos = innerHTML.indexOf('<', start_pos);
        var text_to_get = innerHTML.substring(start_pos, end_pos);
        hashtag_array.push(text_to_get.trim());  
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
                serverTasks++;
                changePage(serverTasks);
                //alert(output);
            }
    });
    
    document.getElementById("hashtag_array_selection").value = hashtag_array;
    
    $.ajax(
    {
        url: 'AJAX Functions/Set/update_firsttimelogin.php',
            data:
            {
                action: 'UpdateFirstTimeLogin',
                arguments: 0
            },
            type: 'post',
            success: function(output)
            {
                serverTasks++;
                changePage(serverTasks);
                //alert(output);
            }
    });
    
    $.ajax(
    {
        url: 'AJAX Functions/Requests/request_page.php',
            data:
            {
                action: 'RequestPage',
                arguments: "HOME"
            },
            type: 'post',
            success: function(output)
            {
                serverTasks++;
                changePage(serverTasks);
            }
    });

    return;
}

function changePage(serverTasks)
{
    if (serverTasks >= 9)
    {
        completedLocation = window.location.pathname.toString().replace("first_time_login.php", "home.php");
        document.location.href = completedLocation;
    }
    return;
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

var x, i, j, selElmnt, a, b, c;

x = document.getElementsByClassName("custom-select");
for (i = 0; i < x.length; i++)
{
    selElmnt = x[i].getElementsByTagName("select")[0];
    a = document.createElement("DIV");
    a.setAttribute("class", "select-selected");
    a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
    x[i].appendChild(a);
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
    x[i].appendChild(b);
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
          arrNo.push(i)
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

window.onclick = function(event)
{
    if (!event.target.matches('.dropdown_menu_button') && 
        !event.target.matches('.dropdown_menu_imge_overlay'))
    {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++)
        {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show'))
                openDropdown.classList.remove('show');
        }
    }
}

























var counter = 0;

function AddHashtag()
{
    if (document.getElementById('hashtags_input').value != null)
    {
        var currentURI = window.document.location.href.toString().replace("first_time_login.php", "http://localhost/Matcha/UI/X.png");
        var current_id = "hashtag_" + (counter + 1);
        var current_name = "hashtag_" + (counter + 1);
        var current_class = "hashtag_" + (counter + 1);
        var hashTagName = document.getElementById('hashtags_input').value.toLowerCase().replaceAll("#", "").toString();
        hashTagName = hashTagName.charAt(0).toUpperCase()  + hashTagName.substring(1);
        
        if (hashTagName.length <= 0)
        {
            alert("You cannot have an empty entry!");
            return;
        }

        if(selected_hashtags.includes("#" + hashTagName) == true)
        {
            alert("You have already listed this HashTag as something you like!");
            document.getElementById('hashtags_input').value = null;
            return;
        }
        
        if (hashTagName.length > 0
         && selected_hashtags.includes("#" + hashTagName) == false)
        {
            counter++;
            var newHtml = '<div class=' + current_class + ' id=' + current_id + ' name=' + current_name + '>';
            newHtml += '<img src="' + currentURI + '" width="15px" height="15px" onclick="removeElement(\'' + current_name.toString() + '\');"/>';
            newHtml += "   " + "#" + toTitleCase(hashTagName).replaceAll(" ", "") + "<br/>";
            newHtml += '</div>';
            
            var taggedName = hashTagName;
            if (!hashtags.includes("#" + taggedName))
                hashtags.push("#" + taggedName);
            selected_hashtags.push("#" + taggedName);
            autocomplete(document.getElementById("hashtags_input"), hashtags);
            
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
                    }
            });

            document.getElementById('dynamic-hashtags').innerHTML += newHtml;
            document.getElementById('hashtags_input').value = null;
        }
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
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
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