var modal = document.getElementById('id01');

window.onclick = function(event)
{
    if (event.target == modal)
    {
        modal.style.display = "none";
    }
}




/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function DisplayDropdown()
{
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
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