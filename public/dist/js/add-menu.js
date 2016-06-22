

$(document).ready(function(){
	$("#submit").click(function(){
		name = $("#name").val();
		link = $("#link").val();
		position = $("#position").val();
		$('table').append('<tr><td>' + name + '</td><td>' + link + '</td><td>' + position +'</td></tr>');
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		$.post(
			"/admin/insert-menu-item",
			{
				_token: CSRF_TOKEN,
				name: name,
				link: link,
				position: position
			},
			function(){ console.log('hello'); }
			);
	});
	
});