
$(document).ready(function(){
	$('#addToCart').click(function(){
		token = $('input[name=_token]').val();
		product_id = $('input[name=product_id]').val();

		$.post('/add-to-cart', { '_token': token, 'product_id' : product_id }, function(success){
			if(success) {
				alert('Товар успешно добавлен в корзину');
			} else {
				alert('Неудалось добавить товар в корзину');
			}
		});

});
});