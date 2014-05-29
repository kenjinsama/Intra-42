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
});

$(window).resize(function()
{
	$("#categories").css('width', $(window).width());
	$("#tree").css('width', $(window).width());
});