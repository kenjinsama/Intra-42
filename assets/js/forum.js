$(document).ready(function()
{
	$("#categories").css('width', $(window).width());
	$("#tree").css('width', $(window).width());
    $(".link").css('width', $(window).width());
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
    $(".link").css('width', $(window).width());
});

function tag(startTag, endTag, textareaId)
{
        var field  = document.getElementById(textareaId); 
        var scroll = field.scrollTop;
        field.focus();
        
        if (window.ActiveXObject) {
                var textRange = document.selection.createRange();            
                var currentSelection = textRange.text;
        }
        else 
        {
                var startSelection   = field.value.substring(0, field.selectionStart);
                var currentSelection = field.value.substring(field.selectionStart, field.selectionEnd);
                var endSelection     = field.value.substring(field.selectionEnd);               
        }
        
        if (window.ActiveXObject)
        {
                textRange.text = startTag + currentSelection + endTag;
                textRange.moveStart("character", -endTag.length - currentSelection.length);
                textRange.moveEnd("character", -endTag.length);
                textRange.select();     
        }
        else 
        {
                field.value = startSelection + startTag + currentSelection + endTag + endSelection;
                field.focus();
                field.setSelectionRange(startSelection.length + startTag.length, startSelection.length + startTag.length + currentSelection.length);
        } 

        field.scrollTop = scroll;     
}