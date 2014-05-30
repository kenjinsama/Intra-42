$(document).ready(function()
{
	$("#categories").css('width', $(window).width());
	$("#tree").css('width', $(window).width());
	$("#d_toggle").click(function()
	{
		if ( $("#categories").css("display") != "none" )
		{
			$("#categories").slideUp();
		}
		else
		{
			$("#categories").slideDown();
		}
	});
	$("#new_subject").click(function()
	{
		if ( $(".f_form").css("display") != "none" )
		{
      		$(".f_form").animate(
			{
        		opacity: "0",
        		marginLeft: "0px",
        	}, 1500 );
        	$(".f_form").hide(0);
		}
		else
		{
      		$(".f_form").show(0);
			$(".f_form").animate(
			{ 
        		opacity: 1.0,
        		marginLeft: "42px",
      		}, 1500 );
		}
    });
});

$(window).resize(function()
{
	$("#categories").css('width', $(window).width());
	$("#tree").css('width', $(window).width());
});