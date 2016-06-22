

window.addEventListener('load', function(){
	brendUrl = document.getElementById('brendUrl').value;
	document.getElementById('brendOrderBy').addEventListener('change', function() {
		brendOrderType = this.value;
		ajax('/ajax/brend-products?brendUrl=' + brendUrl + '&brendOrderType=' + brendOrderType, function(data){
			showProducts(data, 'brend');
		});
	});





	document.getElementById('brend-reset').addEventListener('click', function(){
		attrs = document.getElementsByClassName('attr-checkbox');
		for (var i = attrs.length - 1; i >= 0; i--) {
			attrs[i].checked = false;
		}
		ajax('/ajax/brend-clear?brendUrl=' + brendUrl, function(data){
			showProducts(data, 'brend');
		});
	});


	document.getElementById('brendsShowCount').addEventListener('change', function(){
		brendsShowCount = this.value;
		ajax('/ajax/brend-products?brendUrl=' + brendUrl + '&brendsShowCount=' + brendsShowCount, function(data){
			showProducts(data, 'brend');
		});
	});

	document.getElementById('brendMinPrice').addEventListener('change', function(){
		brendMinPrice = this.value;
		ajax('/ajax/brend-products?brendUrl=' + brendUrl + '&brendMinPrice=' + brendMinPrice, function(data){
			showProducts(data, 'brend');
		});
	});

	document.getElementById('brendMaxPrice').addEventListener('change', function(){
		brendMaxPrice = this.value;
		ajax('/ajax/brend-products?brendUrl=' + brendUrl + '&brendMaxPrice=' + brendMaxPrice, function(data){
			showProducts(data, 'brend');
		});
	});

	document.getElementsByClassName('grid-button')[0].addEventListener('click', function(){
		if($_GET('page')) {
			page  = $_GET('page');
		} else {
			page = 1;
		}
	// alert(page);
	showType = 'table';
	changeViewButton(showType);
	ajax('/ajax/brend-products?brendUrl=' + brendUrl + '&brendsShowType=' + showType + '&page=' + page, function(data){
		showProducts(data, 'brend');
	});
});

	document.getElementsByClassName('line-button')[0].addEventListener('click', function(){
		if($_GET('page')) {
			page  = $_GET('page');
		} else {
			page = 1;
		}

		showType = 'list';
		changeViewButton(showType);
		ajax('/ajax/brend-products?brendUrl=' + brendUrl + '&brendsShowType=' + showType + '&page=' + page, function(data){
			showProducts(data, 'brend');
		});
	});

	attrs = document.getElementsByClassName('attr-checkbox');

	for (var i = 0; i < attrs.length; i++) {
		attrs[i].addEventListener('change', function(){
			attr = this.dataset.attr;
			value = this.dataset.value;


			if(this.checked) {
				ajax('/ajax/brend-checkbox-add?attr=' + attr + '&value=' + value + '&brendUrl=' + brendUrl, function(data){
					showProducts(data,'brend');
				},1);
			} else {
				ajax('/ajax/brend-checkbox-delete?attr=' + attr + '&value=' + value + '&brendUrl=' + brendUrl, function(data) {
					showProducts(data, 'brend');
				},1);
			}

		});
	};
});