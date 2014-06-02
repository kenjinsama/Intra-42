
$(document).ready(function()
{
    $(window).resize(function(){window_resize()});
    window_resize();

    function window_resize()
    {
        $(".module").css( "width", $(window).width() - 220);
        $(".arrow-module").css( "left", ( $(window).width() - 220 ) / 2 - 16);
    }

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
        $("#img-search").css("-webkit-transform", "rotate(360deg)");
        $("#search-background").css("display", "block");
        $("#search-background").animate({
            opacity: 0.33
        }, 300);
        $("#search-input").css("display", "block");
        $("#search-input").animate({
            opacity: 1
        }, 300);
    });

    $("#search-input").blur(function()
    {
        $("#search-background").animate({
            opacity: 0
        }, 300, function() {
            $("#search-background").css("display", "none");
            $("#img-search").css("-webkit-transform", "rotate(0deg)");
        });
        $("#search-input").animate({
            opacity: 0
        }, 300, function() {
            $("#search-input").css("display", "none");
        });
    });

    $(".arrow-module").click(function()
    {
        if ($(this).parent().height() != 60)
        {
            $(this).css("-webkit-transform", "rotate(-90deg)");
            $(this).parent().animate({height: 60}, 300);
        }
        else
        {
            $(this).css("-webkit-transform", "rotate(90deg)");
            $size = $(this).parent().children(".module-desc").height() + 100;
            console.log($size);
            $(this).parent().animate({height: $size}, 300);
        }
    });

    $("#img-nav").click(function()
    {
        if ($("NAV").position().left == 0)
        {
            $("NAV").animate({left: -175}, 300);
            $("SELECTION").animate({left: 25}, 300);
            $("FOOTER").animate({left: -175}, 300);
            $("#img-nav").css("-webkit-transform", "rotate(180deg)");
        }
        else
        {
            $("NAV").animate({left: 0}, 300)
            $("SELECTION").animate({left: 200}, 300);
            $("FOOTER").animate({left: 0}, 300)
            $("#img-nav").css("-webkit-transform", "rotate(0deg)");
        }
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
