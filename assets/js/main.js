
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

    $("#img-search").click(function()
    {
        $("#search-background").css("display", "block");
        $("#search-background").animate({
            opacity: 0.33
        }, 300);
        $("#search-input").css("display", "block");
        $("#search-input").animate({
            opacity: 1
        }, 300);
    });

    $("#search-background").click(function()
    {
        $("#search-background").animate({
            opacity: 0
        }, 300, function() {
            $("#search-background").css("display", "none");
        });
        $("#search-input").animate({
            opacity: 0
        }, 300, function() {
            $("#search-input").css("display", "none");
        });
    });
});

//function search()
//{
//    var xmlhttp;
//    if (window.XMLHttpRequest)
//    {// code for IE7+, Firefox, Chrome, Opera, Safari
//        xmlhttp=new XMLHttpRequest();
//    }
//    else
//    {// code for IE6, IE5
//        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
//    }
//    xmlhttp.onreadystatechange=function()
//    {
//        if (xmlhttp.readyState==4 && xmlhttp.status==200)
//        {
//            document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
//        }
//    }
//    xmlhttp.open("GET","ajax_info.txt",true);
//    xmlhttp.send();
//}