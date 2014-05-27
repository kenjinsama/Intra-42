
$(document).ready(function()
{
    $("#img-profile").click(function()
    {
        if ( $("#option").css("display") != "none" )
        {
            $("#option").css("display", "none");
            $("#option").css("opacity", "0");
        }
        else
        {
            $("#option").css("display", "block");
            $("#option").animate({
                opacity: 1
            }, 300);
        }
    });
});

