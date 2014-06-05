
var usersHtml = [];
var users = [];

$(document).ready(function()
{
	$.urlParam = function(name)
	{
		var results = new RegExp('[\?&amp;]' + name + '=([^&amp;#]*)').exec(window.location.href);
		return results[1] || 0;
	}

	$('#group-search').keyup(function()
	{
		var value = $( this ).val();
		$.get("/ajax/get_users_to_group/"+$.urlParam('project_id')+"/"+value+"/"+users, function (data)
		{
			$('#res').html(data);
		});
		$('#error').html("");
		if (value == 0)
			$('#res').html("");
	}).keyup();
});

function addUser(login)
{
	$('#error').html("");
	var user = document.getElementById(login).value;
	$.get("/ajax/get_project_grp_size/"+$.urlParam('project_id'), function (data)
	{
		grp_size = data.valueOf();
		if (users.length >= grp_size - 1)
			$('#ok').html("Votre groupe est complet !<INPUT id='validate' type='button' value='Valider' onclick='validate()'/>");
		else if (users.indexOf(login) != -1)
			$('#error').html("Cet utilisateur est deja dans votre group !");
		else
		{
			usersHtml.push('<INPUT id="'+'-'+user+'" onClick="delUser(\''+user+'\')" type="button" value="'+user+'"/><BR />');
			users.push(login);
			$('#group-member').html(usersHtml);
			if (users.length >= grp_size - 1)
				addUser(login);
		}
	});
}

function validate()
{
	group = '';
	for (user in users)
		group += users[user] + '#->';
	window.location="/module/validate/"+$.urlParam('project_id')+"/"+group;
}

function delUser(login)
{
	$('#error').html("");
	$('#ok').html("");
	for(var i = 0; i < users.length; i++)
	{
		if(users[i] === login)
		{
			usersHtml.splice(i, 1);
			users.splice(i, 1);
		}
	}
	$('#group-member').html(usersHtml);
}