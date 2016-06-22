$(document).ready(function(){



	// $('#search-button').click(function(){
	// 	name = $('#search').val();
	// 	brendId = $('#brend').val();
	// 	categoryId = $('#category').val();
	// 	group = $('#group').val();

	// 	$.get(
	// 		"/admin/search-product",
	// 		{
	// 			name: name,
	// 			categoryId: categoryId,
	// 			brendId: brendId,
	// 			group: group
	// 		},
	// 		onAjaxSuccess
	// 		);

	// 	function onAjaxSuccess(data)
	// 	{
	// 		products = JSON.parse(data);
	// 		var html ='';
	// 		var token = $('#token').val();
	// 		products.forEach(function(item, i, arr) {
	// 			html += '<tr>' +
	// 			'<td><a href="/admin/product-update/' + item.id + '">'+ item.name + '</a></td>';

	// 			html += '<td>';

	// 			if(item.active) {
	// 				html += '<img src="/site/images/active.jpg">';
	// 			} else {
	// 				html += '<img src="/site/images/no-active.jpg">';
	// 			}

	// 			html += '</td>';

	// 			html += '<td>';

	// 			if(item.active_wholesale) {
	// 				html += '<img src="/site/images/active.jpg">';
	// 			} else {
	// 				html += '<img src="/site/images/no-active.jpg">';
	// 			}

	// 			html += '</td>';

	// 			html += '<td>';

	// 			if(item.description) {
	// 				html += '<img src="/site/images/active.jpg">';
	// 			} else {
	// 				html += '<img src="/site/images/no-active.jpg">';
	// 			}

	// 			html += '</td>';



	// 			if(item.category) {
	// 				html +=  '<td>' + item.category +'</td>';
	// 			} else {
	// 				html +=  '<td></td>';
	// 			}




	// 			html += '<td>';

	// 			if(item.hasImage) {
	// 				html += '<img src="/site/images/active.jpg">';
	// 			} else {
	// 				html += '<img src="/site/images/no-active.jpg">';
	// 			}

	// 			html += '</td>';

	// 			html += '<td><a href="/admin/product-search/' +  item.id + '">Поиск</a></td>';

	// 			html += '<td><a href="/admin/with-product/' +  item.id + '">Берут</a></td>' +
	// 			'<td>' +
	// 			'<form action="/admin/product-delete" method="POST" onsubmit="return confirm("Вы точно хотите удалить товар?")">' +
	// 			'<input type="hidden" name="_token" value="' + token + '">' +
	// 			'<input type="hidden" name="product_id" value="' + item.id + '">' +
	// 			'<button type="submit" class="btn btn-block btn-danger btn-flat">Удалить</button>' +
	// 			'</form>' +
	// 			'</td>' +
	// 			'</tr>';
	// 		});





	// 		$('#productList').html(html);

	// 		$('#paginator').hide();
	// 	}
	// });



	$('#changeCategory').change(function(){
		id = this.value;
		$.get("/admin/category-subcats", { id: id}, function(data){
			subcats = JSON.parse(data);
			$('#subcats').html('<ul>');
			subcats.forEach(function(item, i, arr) {
				$('#subcats').append('<li> <input type="checkbox"  value="'+ item.id +'" name="subcats[]">' + item.name + '</li>');
			});
			$('#subcats').append('</ul>');
		});

		$.get('/admin/category-attributes', { id : id }, function(data){
			attributes = JSON.parse(data);
			$('#attributes').html('');
			attributes.forEach(function(item, i, arr) {
				$('#attributes').append('<input class="form-control" placeholder="'+ item.name +'" name="attributes['+ item.id +']">');
			});
		});

	});

	$('#add-image').click(function(){
		$('#images-inputs-list').append('<input type="file" name="images[]">');
	});


	function showInfoBlock() {
		$.get('/ajax/new-events', function(data){
			show = 0;
			if(data[0] != 0 || data[1] != 0) {
				$('.info-block').find('.info-block-string a').first().text('Новые заказы: ' + data[1]);
				$('.info-block').find('.info-block-string a').eq(1).text('Новые обратные звонки: ' + data[0]);
				$('.info-block').show();
			}


		});
	}

	setInterval(showInfoBlock, 60000);


	$('.admin-product-images').mouseover(function(){
		deleteButton = $(this).children('img').prev();
		deleteButton.show();
	});

	$('.image-delete').click(function(){
		id = $(this).parent().attr('id');
		token = $("input[name='_token']" ).val();
		parent = $(this).parent();
		$.post('/admin/delete-image', { _token : token, id : id }, function(data){
			if(data == 1) {
				parent.hide();
			} else {
				alert('Ошибка при удалении картинки');
			}
		});
	});


	$('.admin-product-images').mouseout(function(){
		$(this).children('img').prev().hide();
	});

	$('#add-product-form').validate({
		rules: {
			name: {
				required: true,
			},
			article: {
				required: true
			},
			price: {
				required: true,
				digits: true,
			},
			url: {
				required: true,
			},
			description : {
				required: true
			}
		},
		messages: {
			name: {
				required: "Вы не указали название товара",
			},
			article: {
				required: "Вы не указали артикул товара"
			},
			price: {
				required: "Вы не указали цену товара",
				digits: "Цена должна быть числом"
			},
			url: {
				required: "Вы не указали url товара",
			},
			description: {
				required: "Вы не указали описание товара"
			}
		},
	});


	$("#product_price").keydown(function(event) {
		// Разрешаем: backspace, delete, tab и escape
		if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 ||
			// Разрешаем: Ctrl+A
			(event.keyCode == 65 && event.ctrlKey === true) ||
			// Разрешаем: home, end, влево, вправо
			(event.keyCode >= 35 && event.keyCode <= 39)) {
				// Ничего не делаем
			return;
		}
		else {

			// Убеждаемся, что это цифра, и останавливаем событие keypress
			if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
				event.preventDefault();
			}
		}
	});





	$( "#product_name" ).keyup(function() {
		val = $(this).val();
		val=val.replace(new RegExp(" ",'g'),'-');
		$("#product_url").val(transliterate(val));
	});

	$( "#category_name" ).keyup(function() {
		val = $(this).val();
		val=val.replace(new RegExp(" ",'g'),'-');
		$("#category_url").val(transliterate(val));
	});

	$('#subcategory_name').keyup(function(){
		val = $(this).val();
		val=val.replace(new RegExp(" ",'g'),'-');
		$("#subcategory_url").val(transliterate(val));
	});


	$( "#name" ).keyup(function() {
		val = $(this).val();
		val=val.replace(new RegExp(" ",'g'),'-');
		$("#url").val(transliterate(val));
	});



	$('.show-attribute-name').click(function(){
		name = $(this).html();
		$('#attr_name').val(name);
		$('input[name=attribute_id]').val($(this).data('attrid'));
		$('.change-attr').show();
	});


	$('#info-close').click(function(){
		$('.info-block').hide();
	});


	$('.close-attr').click(function(){
		$('.change-attr').hide();
	});

	$('.change-subcat').click(function(){
		subcatid = $(this).data('subcatid');
		$('input[name=subcategory_id]').val($(this).data('subcatid'));
		$.get('/admin/ajax-subcategory-by-id-and-catlist', { subcatid: subcatid }, function(data){
			$('#subcat-name').val(data.name);
			option = $('select[name=category_id] option[value="' + data.category_id + '"]');
			option.attr('selected','selected');
			$('.change-attr').show();
		});
	});

	$('.refresh').click(function(){
		location.reload();
	});


		//Если с английского на русский, то передаём вторым параметром true.
		transliterate = (
			function() {
				var
				rus = "щ   ш  ч  ц  ю  я  ё  ж  ъ  ы  э  а б в г д е з и й к л м н о п р с т у ф х ь /".split(/ +/g),
				eng = "shh sh ch cz yu ya yo zh b y e a b v g d e z i j k l m n o p r s t u f x b -".split(/ +/g)
				;
				return function(text, engToRus) {
					var x;
					for(x = 0; x < rus.length; x++) {
						text = text.split(engToRus ? eng[x] : rus[x]).join(engToRus ? rus[x] : eng[x]);
						text = text.split(engToRus ? eng[x].toUpperCase() : rus[x].toUpperCase()).join(engToRus ? rus[x].toUpperCase() : eng[x].toUpperCase()); 
					}
					return text;
				}
			}
			)();



		});
