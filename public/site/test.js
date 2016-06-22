
window.addEventListener("load", function(){ 

	function ajax(url, callback) {
		var xhr = new XMLHttpRequest();
		xhr.open('GET', url);
		xhr.onreadystatechange = function(){
			if (this.readyState == 4) {
				if (this.status == 200)
					this.responseText = JSON.parse(this.responseText);
				callback(this.responseText);
            // иначе сетевая ошибка
        }
    };
    xhr.send(null);
}


document.getElementById('click').addEventListener('click', function(){
	ajax('/ajax/category-products', function(data){
		data = JSON.parse(data);
		console.log(data);
	});
});


});