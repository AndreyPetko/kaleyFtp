
function $_GET(key) {
  var s = window.location.search;
  s = s.match(new RegExp(key + '=([^&=]+)'));
  return s ? s[1] : false;
}

function magnifersEvent() {
  mags = document.getElementsByClassName('magnifier');
  for (var i = 0; i < mags.length; i++) {
    mags[i].addEventListener('click', function(){
      showImages(this);
    });
  };


  smags = document.getElementsByClassName('search-magnifier');
  for (var i = 0; i < smags.length; i++) {
    smags[i].addEventListener('click', function(){
      showImages(this);
    });
  };
  
}



function setAvailCheckbox(name) {
  document.querySelector('input[value="' + name  + '"]').disabled = false;
  document.querySelector('input[value="' + name + '"]').nextSibling.style.cssText = 'color: #464646 !important';
}

function setDisabledCheckboxes() {
  checkboxes = document.querySelectorAll('input[name="payment[]"]');
  for (var i = checkboxes.length - 1; i >= 0; i--) {
    checkboxes[i].disabled = true;
    checkboxes[i].checked = false;
    checkboxes[i].nextSibling.style.cssText = 'color: #C5C5C5 !important';
  }

}


function changeAvailableChexboxes(value) {

  delStr = document.getElementById('delStr');

  console.log(delStr);

  if(delStr) {
    delStr = delStr.value;
    delStr = JSON.parse(delStr);
  }



  setDisabledCheckboxes()

  setAvailCheckbox('privat');
  setAvailCheckbox('visa');


  if(value == 'sam') {
    setDeliveryCost(delStr.sam);
    setAvailCheckbox('nal');
  }

  if(value == 'kuryer') {
    setDeliveryCost(delStr.kuryer);
    setAvailCheckbox('nal');
  }


  if(value == 'ukr poshta') {
    setDeliveryCost(delStr.ukrposhta);
    setAvailCheckbox('nalog');
  }

  if(value == 'nova poshta') {
    setDeliveryCost(delStr.novaposhta);
    setAvailCheckbox('nalog');
  }

  if(value == 'autolux') {
    setDeliveryCost(delStr.ukrposhta);
    setAvailCheckbox('nalog');
  }

}


function setDeliveryCost(price) {
  delivey = document.getElementById('delivery');
  delivery.innerHTML = price + 'грн';
}




function heardsEvent() {
  hearts = document.getElementsByClassName('item-heart');

  for (var i = 0; i < hearts.length; i++) {
    hearts[i].addEventListener('click', function(){
      block = this;
      id = this.dataset.productid;
      ajax('/ajax/add-wish?productid=' + id, function(data){
        if(data == 1) {
          block.getElementsByTagName('img')[0].setAttribute('src', fullUrl +'/site/images/ixon-wishlist.png');
        } else {
          block.getElementsByTagName('img')[0].setAttribute('src',  fullUrl +'/site/images/ixon-wishlist-active.png');
        }
      });
    });
  };
}

function buyEvent() {
  itemsBuy = document.getElementsByClassName('item-buy');

  if(itemsBuy) {
    for (var i = itemsBuy.length - 1; i >= 0; i--) {
      itemsBuy[i].addEventListener('click', function(){
        id = this.dataset.productid;

        ajax('/ajax/add-to-cart?id=' + id, function(data){
          name = JSON.parse(data);
          document.getElementById('order-text').innerHTML  = "Товар " + name + " успешно добавлен в корзину";
          document.getElementById('sucess-cart-form').style.display = 'block';
        });
      });
    };
  }
}


function hideOtherFeedbackBlocks() {
  blocks = document.getElementsByClassName('feedback-block');
  for (var i = blocks.length - 1; i >= 0; i--) {
    blocks[i].style.display = 'none';
  };
}

function changeViewButton(showType) {
  if(showType == 'list') {
    document.getElementsByClassName('grid-button')[0].getElementsByTagName('img')[0].setAttribute('src', '/site/images/sort-tabl.png');
    document.getElementsByClassName('line-button')[0].getElementsByTagName('img')[0].setAttribute('src', '/site/images/sort-spisok-active.png');
  } else {
    document.getElementsByClassName('grid-button')[0].getElementsByTagName('img')[0].setAttribute('src', '/site/images/sort-tabl-active.png');
    document.getElementsByClassName('line-button')[0].getElementsByTagName('img')[0].setAttribute('src', '/site/images/sort-spisok.png');
  }
}


function changeTotal(price) {
  total = document.getElementsByClassName('change-color-total')[0].innerHTML;
  total = parseInt(total.substring(0, total.length - 3));
  newTotal = total - price;
  document.getElementsByClassName('change-color-total')[0].innerHTML = newTotal + 'грн';
}


function pageChangeTotal(price) {
  total = document.getElementById('total').innerHTML;
  total = parseInt(total.substring(0, total.length - 3));
  newTotal = total - price;
  document.getElementById('total').innerHTML = newTotal + ' грн';

  discount = document.getElementById('discount').innerHTML;
  discount = parseInt(discount.substring(0, discount.length - 1));

  document.getElementById('discount-total').innerHTML = newTotal - discount*newTotal/100 + ' грн';

}

function addCartItem(item) {
  itemStr = '<div class="block-list-item">' +
  '<div class="cart-list-item-image">' +
  '<a href="' + fullUrl + '/product/' + item.url + '" >';


  if(item.image) {
    itemStr += '<img src="../product_images/' + item.image + '" alt="">';
  } else {
    itemStr += '<img src="../../site/images/zaglushka.png" alt="">';
  }



  itemStr += '</a>' +
  '</div>' +
  '<div class="cart-list-item-text">' +
  '<a href="' + fullUrl + '/product/' + item.url + '" ><div>' + item.name + '</div></a> ' +
  '</div>' +
  '<div class="cart-list-item-count">' +
  '<div>x</div>' +
  '<div>' + item.count + '</div>' +
  '</div>' +
  '<div class="cart-list-item-lines">' +
  '<div class="cart-list-item-delete" data-productid="'+ item.id +'" data-totalprice="' + parseInt(item.count)*parseInt(item.price) + '" ">' +
  '<img src="/site/images/MergedLayers4.png" alt="">' +
  '</div>' +
  '<div class="cart-list-item-price">' +
  item.price + 'грн' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="cart-list-item-bottom-border"></div>';

  document.getElementsByClassName('cart-block-list')[0].innerHTML += itemStr;
}


function setActiveSubcat($subcatId) {
  subcats = document.getElementsByClassName('subcat-item');
  for (var i = subcats.length - 1; i >= 0; i--) {
    subcats[i].getElementsByClassName('subcat-text')[0].classList.remove("subcat-text-active");
    if(i != 0) {
      subcats[i].getElementsByTagName('img')[0].setAttribute('src', '/site/images/icon-catecory-list.png');
    }
  }

  subcat = document.getElementById($subcatId);
  subcat.getElementsByClassName('subcat-text')[0].classList.add("subcat-text-active");

  if($subcatId != 0) {
    subcat.getElementsByTagName('img')[0].setAttribute('src', '/site/images/icon-catecory-list-active.png');
  }

}

function showProducts(data, type) {

  if(type == null) {
    type = 'category';
  }

  threads = document.getElementById('threads');

  data = JSON.parse(data);
  products = data[0];
  pagination = data[1];
  showType = data[2];

  if(data[0] != '') {

    document.getElementsByClassName('category-list')[0].innerHTML = '';
    if(threads)  {
      products.forEach(function(item,i,products){
        addTheads(item);
      });
    } else {

      if(showType == 'table') {
        products.forEach(function(item,i,products){
          addCategoryItem(item);
        });

      } 

      if(showType == 'list') {
        products.forEach(function(item,i,products){
          addCategoryItemList(item);
        });
      }

      if(showType == 'mobile') {
        document.getElementsByClassName('mobile-list')[0].innerHTML = '';
        products.forEach(function(item,i,products){
          addMobileCateogoryItem(item);
        });
      }
    }


  } else {
    document.getElementsByClassName('category-list')[0].innerHTML = '<div class="no-products">Нет товаров</div>';
  }


  magnifersEvent();
  buyEvent();
  heardsEvent();

  document.getElementById('pagination').innerHTML = pagination;
  pagLinks = document.getElementById('pagination').getElementsByTagName('a');
  for (var i = pagLinks.length - 1; i >= 0; i--) {
    link = pagLinks[i].getAttribute('href');
    if(type == 'category') {
      link = link.replace(fullUrl + '/ajax/category-products', fullUrl + '/category/' + categoryUrl);
      link = link.replace(fullUrl + '/ajax/filter-checkbox-delete', fullUrl + '/category/' + categoryUrl);
      link = link.replace(fullUrl +'/ajax/filter-checkbox-add', fullUrl + '/category/' + categoryUrl);
      link = link.replace(fullUrl + '/ajax/filter-clear', fullUrl + '/category/' + categoryUrl);
    } else {
      brendUrl = document.getElementById('brendUrl').value;
      link = link.replace(fullUrl + '/ajax/brend-products', fullUrl + '/brend-products/' + brendUrl);
      link = link.replace(fullUrl + '/ajax/brend-checkbox-delete', fullUrl + '/brend-products/' + brendUrl);
      link = link.replace(fullUrl + '/ajax/brend-checkbox-add', fullUrl + '/brend-products/' + brendUrl);
      link = link.replace(fullUrl +'/ajax/brend-clear', fullUrl + '/brend-products/' + brendUrl);
    }


    pagLinks[i].setAttribute('href', link);
  };


}


function addMobileCategoryItem(item) {
  item = '<div class="mobile-product">' +
  '<div class="mobile-product-image">' +
  '<a href="/product/' + item.url + '">'
  '<img src="/product_images/' + item.image + ') }}">' +
  '</a>' +
  '<a href="/product/{{$product->url}}">' +
  '<img src="/site/images/zaglushka.png" alt="">' +
  '</a>' +
  '</div>' +
  '<a href="/product/' + item.url + '">' +
  '<div class="mobile-product-name">' +
  item.name
  '</div>' +
  '</a>' +
  '<div class="mobile-product-bottom-line">' +
  '<div class="mobile-product-price">' +
  item.price + 'грн' +
  '</div>' +
  '<div class="mobile-product-add-to-cart" data-productid="' + item.id + '">' +
  '<div class="mobile-add-button">' +
  '<div class="mobile-add-image">' +
  '<img src="/site/images/icon-cart-main.png" alt="">' +
  '</div>' +
  '<div class="mobile-add-text">' +
  'В корзину' +
  '</div>' +
  '</div>' +
  '<div class="mobile-add-bottom-line">' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>';


  document.getElementsByClassName('mobile-list')[0].innerHTML += item;

}



function addCategoryItem(item) {
  itemStr = '<div class="category-item fl">'

  if(item.new) {
    itemStr += '<div class="new-item-category"><img src="/site/images/new_item.png"></div>';
  }


  itemStr += '<div class="magnifier" data-productid="' +  item.id + '">' +
  '<img src="/site/images/icon-loop.png" alt="">' +
  '</div>';





  itemStr +=  '<div class="item-image">' +
  '<a href="/product/' + item.url + '">';

  if(item.image) {
    itemStr +=  '<img src="/product_images/' + item.image + '" alt="">';
  } else {
    itemStr +=  '<img src="' + fullUrl + '/site/images/zaglushka.png" alt="">';
  }




  itemStr += '</a></div>';



  if(item.quantity == 0) {
    itemStr += '<a href="/product/' + item.url + '"><div class="item-name"><div class="availability"><img src="/site/images/icon-disavailability.png" alt="">Нет в наличии</div>';
  }

  if(item.quantity == 1 || item.quantity == 2) {
    itemStr += '<a href="/product/' + item.url + '"><div class="item-name"><div class="availability"><img src="/site/images/icon-availability-attantion.png" alt="">Заканчивается</div>';
  }

  if(item.quantity > 2) {
    itemStr += '<a href="/product/' + item.url + '"><div class="item-name"><div class="availability"><img src="/site/images/add-cart-success.png" alt="">Есть в наличии</div>';
  }

  itemStr += item.name +
  '</div></a>' +
  '<div class="item-bottom-line">' +
  '<div class="item-price category">' +
  item.price + ' грн' +
  '</div>' +
  '<div class="item-heart fl" data-productid="' +  item.id + '" >';


  if(item.wish) {
    itemStr += '<img src="/site/images/ixon-wishlist-active.png" alt="">';
  } else {
    itemStr += '<img src="/site/images/ixon-wishlist.png" alt="">';
  }


  itemStr += '</div>' +
  '<div class="item-buy" data-productid="' +  item.id + '">' +
  '<div class="item-buy-image">' +
  '<img src="/site/images/icon-cart-main.png" alt="">' +
  '</div>' +
  '<div class="item-buy-text">' +
  'В корзину' +
  '</div>' +
  '<div class="item-buy-shadow"></div>' +
  '</div>' +
  '</div>' +
  '</div>';

  catList = document.getElementsByClassName('category-list')[0].innerHTML += itemStr;
}


function addCategoryItemList(item) {
  itemStr = '<div class="category-spisok-item">';

  if(item.new) {
    itemStr += '<div class="new-item-list"><img src="/site/images/new_item.png"></div>';
  }


  itemStr +=  '<div class="category-spisok-image fl">' +
  '<div class="search-magnifier" data-productid="' + item.id + '">'+
  '<img src="' + fullUrl + '/site/images/icon-loop.png" alt="">' +
  '</div>' +
  '<a href="/product/' + item.url + '">';

  if(item.image) {
    itemStr +=  '<img src="/product_images/' + item.image + '" alt="">';
  } else {
    itemStr +=  '<img src="' + fullUrl + '/site/images/zaglushka.png" alt="">';
  }

  itemStr += '</div>' +
  '<div class="category-spisok-info fl">' +
  '<a href="/product/' + item.url + '"><div class="category-spisok-title">' + item.name + '</div></a>';


  if(item.quantity == 0) {
    itemStr += '<div class="availability-spisok"><img src="/site/images/icon-disavailability.png" alt="">Нет в наличии</div>';
  }

  if(item.quantity == 1 || item.quantity == 2) {
    itemStr += '<div class="availability-spisok"><img src="/site/images/icon-availability-attantion.png" alt="">Заканчивается</div>';
  }

  if(item.quantity > 2) {
    itemStr += '<div class="availability-spisok"><img src="/site/images/add-cart-success.png" alt="">Есть в наличии</div>';
  }


  itemStr += '<div class="category-spisok-text">' +
  item.description +
  '</div>' +
  '</div>' +
  '<div class="category-spisok-other fr">' +
  '<div class="category-spisok-heard item-heart" data-productid="' +  item.id + '">';


  if(item.wish) {
    itemStr += '<img src="/site/images/ixon-wishlist-active.png" alt="">';
  } else {
    itemStr += '<img src="/site/images/ixon-wishlist.png" alt="">';
  }

  itemStr += '</div>' +
  '<div class="category-spisok-price">' + item.price + 'грн</div>' +
  '<div class="category-spisok-add-to-cart item-buy" data-productid="' + item.id + '">' +
  '<div class="item-buy-image">' +
  '<img src="/site/images/icon-cart-main.png" alt="">' +
  '</div>' +
  '<div class="item-buy-text">' +
  'В корзину' +
  '</div>' +
  '<div class="item-buy-shadow spisok-shadow"></div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="category-spisok-line"></div>';

  catList = document.getElementsByClassName('category-list')[0].innerHTML += itemStr;

}


function addTheads(item) {
  itemStr = '<div class="thread-item fl">';

  if(item.new) {
    itemStr += '<div class="new-item-threads"><img src="/site/images/new_item.png"></div>';
  }

  itemStr += '<a href="/product/' + item.url + '">';



  if(item.image) {
    itemStr += '<div class="thread-image" style="background-image:url(/product_images/'+ item.image +');"></div></a>';
  } else {
    itemStr += '<div class="thread-image" style="background-image:url(/site/images/main-logo.png); background-size: contain; background-repeat: no-repeat; background-position: center;"></div></a>';
  }

  

  itemStr += '<a href="/product/' + item.url + '"><div class="thread-item-name">' +
  item.name;


  if(item.quantity == 0) {
    itemStr += '<div class="availability-spisok"><img src="/site/images/icon-disavailability.png" alt="">Нет в наличии</div>';
  }

  if(item.quantity == 1 || item.quantity == 2) {
    itemStr += '<div class="availability-spisok"><img src="/site/images/icon-availability-attantion.png" alt="">Заканчивается</div>';
  }

  if(item.quantity > 2) {
    itemStr += '<div class="availability-spisok"><img src="/site/images/add-cart-success.png" alt="">Есть в наличии</div>';
  }


  itemStr += '</div></a>' +
  '<div class="thread-item-txt-left fl">' +
  '<p>Цена:</p>' +
  '<p>Кол-во:</p>' +
  '</div>' +
  '<div class="thread-item-txt-left fl">' +
  '<p>' + item.price + ' грн</p>' +
  '<input type="text">' +
  '</div>' +
  '<div class="thread-button fr"  data-productid="' + item.id +'">' +
  'В корзину' +
  '</div>' +
  '</div>';

  catList = document.getElementsByClassName('category-list')[0].innerHTML += itemStr;
}

function insertParam(key, value, categoryUrl) {
  key = escape(key); value = escape(value);

  var kvp = document.location.search.substr(1).split('&');
  if (kvp == '') {
            // document.location.search = '?' + key + '=' + value;
            history.pushState('null', null, categoryUrl + '?' + key + '=' + value);
          } else {

            var i = kvp.length; var x; while (i--) {
              x = kvp[i].split('=');

              if (x[0] == key) {
                x[1] = value;
                kvp[i] = x.join('=');
                break;
              }
            }

            if (i < 0) { kvp[kvp.length] = [key, value].join('='); }

            //this will reload the page, it's likely better to store this until finished
            // document.location.search = kvp.join('&');
            history.pushState(null, null, categoryUrl + '?' + kvp.join('&'));
          }
        }


        function ajax(url, callback, json) {
          var xhr = new XMLHttpRequest();
          xhr.open('GET', url);
          xhr.onreadystatechange = function(){
            if (this.readyState == 4) {
              if (this.status == 200)
                if(json === undefined) {
                  this.responseText = JSON.parse(this.responseText)
                }
                callback(this.responseText);
            // иначе сетевая ошибка
          }
        };
        xhr.send(null);
      }


      function scroll(y) {
  // window.scrollBy({ top: y, behavior: 'smooth' });
  $('html, body').animate({
    scrollTop: '+=' + y
  }, 500);
}



function remove(item) {
  item.parentNode.removeChild(item);
}


function showImages(thisItem){
  id = thisItem.dataset.productid;
  ajax('/ajax/product-images?id=' + id, function(data){
    data = JSON.parse(data);
    document.getElementsByClassName('show-images-main')[0].innerHTML = "<img src='/product_images/" + data[0][0].url + "'>";

    var i = 0;

    document.getElementsByClassName('show-images-right')[0].addEventListener('click', function(){
      if(i != data[0].length - 1) {
        i++;
      }

      document.getElementsByClassName('show-images-main')[0].innerHTML = "<img src='/product_images/" + data[0][i].url + "'>";
      document.getElementsByClassName('show-images-pages')[0].innerHTML = (i + 1) + ' из ' + data[0].length;
    });

    document.getElementsByClassName('show-images-left')[0].addEventListener('click', function(){
      if(i <= 0) {
        i = 0;
      } else {
        i--;
      }

      document.getElementsByClassName('show-images-main')[0].innerHTML = "<img src='/product_images/" + data[0][i].url + "'>";
      document.getElementsByClassName('show-images-pages')[0].innerHTML = (i + 1) + ' из ' + data[0].length;
    });



    if(data[0].length == 1 || data[0].length == 0) {
      document.getElementsByClassName('show-images-right')[0].style.opacity = '0';
      document.getElementsByClassName('show-images-left')[0].style.opacity = '0';
      document.getElementsByClassName('show-images-left')[0].style.cursor = 'default';
      document.getElementsByClassName('show-images-right')[0].style.cursor = 'default';
    } else {
      document.getElementsByClassName('show-images-right')[0].style.opacity = '1';
      document.getElementsByClassName('show-images-left')[0].style.opacity = '1';
      document.getElementsByClassName('show-images-left')[0].style.cursor = 'pointer';
      document.getElementsByClassName('show-images-right')[0].style.cursor = 'pointer';
    }

    document.getElementsByClassName('show-images-pages')[0].innerHTML = '1 из ' + data[0].length;
    document.getElementsByClassName('show-images-name')[0].innerHTML = data[1];

    document.getElementsByClassName('show-images')[0].style.display = 'block';
    document.getElementsByClassName('show-images-content')[0].style.display = 'block';
  });
}


// item - элемент, type: 0 - рекомендованые, 1 - новые
function addItem(item, type) {
  newItem = document.createElement("div");
  newItem.className += "main-item";

  aval = document.createElement('div');
  aval.className += "availability";

  if(item.new) {
    newItem.innerHTML = '<div class="new-item"><img src="/site/images/new_item.png"></div>';
  }


  if(item.quantity > 2) {
    aval.innerHTML = '<img src="/site/images/add-cart-success.png" alt="">Есть в наличии';
  }

  if(item.quantity == 1 || item.quantity == 2) {
    aval.innerHTML = '<img src="/site/images/icon-availability-attantion.png" alt="">Заканчивается';
  }

  if(item.quantity == 0) {
    aval.innerHTML = '<img src="/site/images/icon-disavailability.png" alt="">Нет в наличии';
  }


  magnifier = document.createElement('div');
  magnifier.className += 'magnifier';
  magnifier.dataset.productid = item.id
  magnifier.addEventListener('click', function(){
    showImages(this);
  });


  magnifier.innerHTML = '<img src="' + fullUrl + '/site/images/icon-loop.png">';

  link = document.createElement('a');
  link.setAttribute('href', '/product/' + item.url);

  itemImage = document.createElement("div");
  itemImage.className += "item-image";
  image = document.createElement('img');
  if(item.category_id == 39) {
    image.setAttribute('src',  fullUrl + '/site/images/IMG_9745-450x300.png');
  } else {
    if(item.image == null) {
      image.setAttribute('src',  fullUrl + '/site/images/zaglushka.png');
    } else {
      image.setAttribute('src', fullUrl + '/product_images/' + item.image);
    }
  }


  link1 = document.createElement('a');
  link1.setAttribute('href', '/product/' + item.url);
  itemName = document.createElement('div');
  itemName.className += "item-name";
  itemName.appendChild(aval);
  itemName.innerHTML += item.name;

  itemImage.appendChild(image);

  bottomLine = document.createElement('div');
  bottomLine.className += 'item-bottom-line';

  price = document.createElement('div');
  price.className += 'item-price';
  price.innerHTML = item.price + 'грн';

  buy = document.createElement('div');
  buy.className += 'item-buy';
  buy.dataset.productid = item.id;

  buy.addEventListener('click', function(){
    id = this.dataset.productid;

    ajax('/ajax/add-to-cart?id=' + id, function(data){
      name = JSON.parse(data);
      document.getElementById('order-text').innerHTML  = "Товар " + name + " успешно добавлен в корзину";
      document.getElementById('sucess-cart-form').style.display = 'block';
      setTimeout(function(){
        document.getElementById('sucess-cart-form').style.display = 'none';
      }, 1000);
    });
  });

  buyImage = document.createElement('div');
  buyImage.className += 'item-buy-image';

  buyImg = document.createElement('img');
  buyImg.setAttribute('src', fullUrl + '/site/images/icon-cart-main.png');

  buyImage.appendChild(buyImg);

  buyText = document.createElement('div');
  buyText.className += 'item-buy-text';
  buyText.innerHTML = 'В корзину';

  buyShadow = document.createElement('div');
  buyShadow.className = 'item-buy-shadow';

  buy.appendChild(buyImage);
  buy.appendChild(buyText);
  buy.appendChild(buyShadow);

  bottomLine.appendChild(price);
  bottomLine.appendChild(buy);

  newItem.appendChild(magnifier);
  newItem.appendChild(link);
  link.appendChild(itemImage);
  newItem.appendChild(link1);
  link1.appendChild(itemName);
  newItem.appendChild(bottomLine);

  document.getElementsByClassName('main-items-list')[type].appendChild(newItem);

}


//Изменение картинки активного поинта
function changePoint(current) {
  images = points.getElementsByTagName('img');
  for (var i = images.length - 1; i >= 0; i--) {
    images[i].setAttribute('src', '/site/images/slider-rond-active.png');
  };
  images[current - 1].setAttribute('src', '/site/images/slider-rond.png');
}

//Изменение картинки на слайдере
function changeMargin(index) {
  sliderImages = mainSlider.getElementsByClassName('slider-images')[0];
  sliderImages.style.marginLeft = '-' + index*1200 + 'px';
}


// Отображаем нужный текст
function showText(index) {
  texts = document.getElementsByClassName('slide-text-content')[0].getElementsByTagName('div');
  for (var i = texts.length - 1; i >= 0; i--) {
    texts[i].style.display = "none";
  };
  document.getElementsByClassName('slide-text-content')[0].getElementsByTagName('div')[index].style.display = 'table-cell';
}


function getFirstChild(el){
  var firstChild = el.firstChild;
  while(firstChild != null && firstChild.nodeType == 3){ // skip TextNodes
    firstChild = firstChild.nextSibling;
  }
  return firstChild;
}

function changeBrandsMargin(curImage) {
  document.getElementsByClassName('brands-images')[0].style.marginLeft = '-' + 200*(curImage - 1) + 'px';
}