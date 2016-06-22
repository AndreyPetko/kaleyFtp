$(document).ready(function(){
	var parts = window.location.search.substr(1).split("&");
	var $_GET = {};
	for (var i = 0; i < parts.length; i++) {
		var temp = parts[i].split("=");
		$_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
	}


	links = $('.pagination li a').each(function(){
		href = $(this).attr('href');

		var str = href.substring(href.indexOf('?'));
		var parts = str.substr(1).split("&");
		var temp = parts[0].split("=");
		page = temp[1];

		if($_GET['brendId'] === undefined) {
			newHref = "http://kaleydoskop.ap.org.ua/admin/products?page=" + page;
		} else {
			newHref = "http://kaleydoskop.ap.org.ua/admin/products?brendId=" + $_GET['brendId'] +  "&categoryId=" + $_GET['categoryId']
			+"&group=" + $_GET['group'] + "&search=" + $_GET['search'] + "&page=" + page;
		}

		$(this).attr('href', newHref);
	});


});