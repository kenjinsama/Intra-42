$(document).ready(function()
{
	$sort = 0;
    $('#name-order').click(function()
    {
	    if ($sort == 0)
	    {
		    $.get("/ajax/get_users_order/0", function (users)
		    {
			    $('.yearbook').html(users);
		    });
	    }
	    else
	    {
		    $.get("/ajax/get_users_order/1", function (users)
		    {
			    $('.yearbook').html(users);
		    });
	    }
	    $sort = !$sort;
    });

	$('#name-search').keyup(function()
	{
		var value = $( this ).val();
		$.get("/ajax/get_uid/"+value, function (data)
		{
			$('.yearbook').html(data);
		});
	}).keyup();
});