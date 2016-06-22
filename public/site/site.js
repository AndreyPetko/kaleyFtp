window.addEventListener("load", function(){ 


  itemComp = document.getElementsByClassName('item-comp')


  if(itemComp[0]) {
    for (var i = 0; i < itemComp.length; i++) {
      itemComp[i].addEventListener('click', function(){
        productid = this.dataset.productid;
        item = this;
        ajax('/ajax/change-comparison?productid=' + productid, function(data){
          if(data == 1) {
            item.getElementsByTagName('img')[0].setAttribute('src', '../site/images/icon-compare-grey.png');
          }

          if(data == 2) {
            item.getElementsByTagName('img')[0].setAttribute('src', '../site/images/icon-compare.png');
          }

          if(data == 3) {
            var fullCampareForm = document.getElementById('full-compare-form');
            fullCampareForm.style.display = "block";

            var sucessClose = document.getElementsByClassName('success-close');
            for(i=0; i < sucessClose.length; i++){
              sucessClose[i].addEventListener('click', function(){
                fullCampareForm.style.display = "none";
              });

            }
          }

        });
      });
    };

  }






  threadBt = document.getElementsByClassName('thread-button');

  if(threadBt[0]) {
    for (var i = 0; i < threadBt.length; i++) {
      threadBt[i].addEventListener('click', function(){
        id = this.dataset.productid;
        count = this.previousSibling.previousSibling.getElementsByTagName('input')[0].value;
        if(!count) {
          count = 1;
        }
        ajax('/ajax/add-to-cart?count=' + count + '&id=' + id, function(data) {
          name = JSON.parse(data);
          document.getElementById('order-text').innerHTML  = "Товар " + name + " успешно добавлен в корзину";
          document.getElementById('sucess-cart-form').style.display = 'block';
          setTimeout(function(){
            document.getElementById('sucess-cart-form').style.display = 'none';
          }, 1000);
        });
      });
    };
  }


  aval = document.getElementById('availability');

  if(aval) {
    aval.addEventListener('click', function(){
      categoryUrl = document.getElementById('catUrl').value;
      if(this.checked) {
        ajax('/ajax/change-aval?aval=' + 1 + '&categoryUrl=' + categoryUrl, function(data){
          showProducts(data);
        });
      } else {
        ajax('/ajax/change-aval?aval=' + 0 + '&categoryUrl=' + categoryUrl, function(data){
          showProducts(data);
        });
      }
    });
  }


  comp = document.getElementsByClassName('products-comparison')[0];


  if(comp) {
    comp.addEventListener('click', function(){
      productid = this.dataset.productid;
      ajax('/ajax/change-comparison?productid=' + productid, function(data){
        if(data == 1) {
          document.getElementsByClassName('products-comparison-text')[0].innerHTML = 'Добавить в сравнение';
          document.getElementsByClassName('products-comparison-img')[0].getElementsByTagName('img')[0].setAttribute('src', '../site/images/icon-compare-grey.png');
        }

        if(data == 2) {
          document.getElementsByClassName('products-comparison-text')[0].innerHTML = 'Удалить из сравнения';
          document.getElementsByClassName('products-comparison-img')[0].getElementsByTagName('img')[0].setAttribute('src', '../site/images/icon-compare.png');
        }


        if(data == 3) {
          var fullCampareForm = document.getElementById('full-compare-form');
          fullCampareForm.style.display = "block";

          var sucessClose = document.getElementsByClassName('success-close');
          for(i=0; i < sucessClose.length; i++){
            sucessClose[i].addEventListener('click', function(){
              fullCampareForm.style.display = "none";
            });
            
          }
        }


      });
    });
  }

// картинка на странице продукта

sliderCurImage = document.getElementsByClassName("product-slider-current-image");

if(sliderCurImage[0]) {
  var mainImage = sliderCurImage[0].getElementsByTagName("img")[0];
  var listImage = document.getElementsByClassName('product-slider-list-item');
  function clearBorderImage(){
    for(i=0; i < listImage.length; i++){
      listImage[i].style.cssText = "border-color:#e8e8e8";
    };
  }

  for(i=0; i < listImage.length; i++){
    listImage[i].addEventListener('click', function(){
     clearBorderImage();
     var newTag = this.getElementsByTagName("img")[0].getAttribute('src');
     mainImage.src = newTag;
     this.style.cssText = "border-color:#838383";
   });
  }

}


// картинка на странице продукта


fullUrl = 'http://kaleydoskop.ap.org.ua';
// fullUrl = 'http://kaley.com';


//Наведение на верхние элементы 
headerImages = [];
headerImages[0] = [];
headerImages[1] = [];
headerImages[2] = [];
headerImages[0].imgHover = '/site/images/icon-mail-hover.png';
headerImages[0].img = '/site/images/icon-mail.png';
headerImages[1].imgHover = '/site/images/icon-feedback-hover.png';
headerImages[1].img = '/site/images/icon-feedback.png';
headerImages[2].imgHover = '/site/images/icon-call-back-hover.png';
headerImages[2].img = '/site/images/icon-call-back.png';


headerElements = document.getElementsByClassName('header-line-element');


for(var i=0; i < headerElements.length; i++) {
 (function(index) {
  headerElements[index].addEventListener("mouseover", function() {
    child = getFirstChild(headerElements[index]);
    img = getFirstChild(child);
    img.setAttribute('src', headerImages[index].imgHover);
    text = document.getElementsByClassName('header-line-element-text')[index];
    text.style.color = '#fdde09';
  });

  headerElements[index].addEventListener('mouseout', function(){
    child = getFirstChild(headerElements[index]);
    img = getFirstChild(child);
    img.setAttribute('src', headerImages[index].img);
    text = document.getElementsByClassName('header-line-element-text')[index];
    text.style.color = 'white';
  });
})(i);
}

//Выбор input для текстового поля
searchInput  = document.getElementById('searchInput');
if(searchInput)  {
  searchInput.addEventListener('focus',function(){
    searchIcon = document.getElementById('searchIcon');
    searchIcon.setAttribute('src', '/site/images/icon-sarch-hover.png');
    searchInput.placeholder = '';
  });

  searchInput.addEventListener('blur',function(){
    searchIcon = document.getElementById('searchIcon');
    searchIcon.setAttribute('src', '/site/images/icon-sarch.png');
    if(searchInput.value == '') {
      searchInput.placeholder = 'Поиск';
    }
  });
}


addToCart = document.getElementsByClassName('product-add-to-cart')[0];
addToCartMob = document.getElementsByClassName('product-add-to-cart')[1];


if(addToCart) {

  addToCart.addEventListener('click', function(){
    id = this.dataset.productid;
    count = document.getElementById('product_count').value;

    if(!count) {
      count = 1;
    }

    ajax('/ajax/add-to-cart?id=' + id + '&count=' + count, function(data){
      name = JSON.parse(data);
      document.getElementById('order-text').innerHTML  = "Товар " + name + " успешно добавлен в корзину";
      document.getElementById('sucess-cart-form').style.display = 'block';

      setTimeout(function(){
        document.getElementById('sucess-cart-form').style.display = 'none';
      }, 1000);
    });
  });
}

if(addToCartMob) {

  addToCartMob.addEventListener('click', function(){
    id = this.dataset.productid;
    count = document.getElementById('product_count').value;

    if(!count) {
      count = 1;
    }

    ajax('/ajax/add-to-cart?id=' + id + '&count=' + count, function(data){
      name = JSON.parse(data);
      document.getElementById('order-text').innerHTML  = "Товар " + name + " успешно добавлен в корзину";
      document.getElementById('sucess-cart-form').style.display = 'block';

      setTimeout(function(){
        document.getElementById('sucess-cart-form').style.display = 'none';
      }, 1000);
    });
  });
}





toCartBut = document.getElementsByClassName('toCart-but');


if(toCartBut) {
  for (var i = toCartBut.length - 1; i >= 0; i--) {
    toCartBut[i].addEventListener('click', function(){
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
  };
}



itemsBuy = document.getElementsByClassName('item-buy');


if(itemsBuy) {
  for (var i = itemsBuy.length - 1; i >= 0; i--) {
    itemsBuy[i].addEventListener('click', function(){
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
  };
}



mobileBuy = document.getElementsByClassName('mobile-product-add-to-cart');

if(mobileBuy) {
  for (var i = mobileBuy.length - 1; i >= 0; i--) {
    mobileBuy[i].addEventListener('click', function(){
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
  };
}




//Отображение корзины
cart = document.getElementById('open-cart');

cartClick = 0;

if(cart) {
  cart.addEventListener('click', function(){
    if(cartClick == 0) {
      cart.style.background = "#c6d932";
      cartImage = cart.getElementsByTagName('img')[0];
      cartImage.setAttribute('src', '/site/images/icon-cart-active.png')

      cartBlock = document.getElementById('cart-block');
      ajax('/ajax/cart-products-and-total', function(data){
        data = JSON.parse(data);
        if(data[0]) {
          document.getElementsByClassName('cart-block-list')[0].innerHTML = '';
          data[0].forEach(function(item, i, data){
            addCartItem(item);
          });
          document.getElementsByClassName('change-color-total')[0].innerHTML = data[1] + 'грн';
        } else {
          document.getElementsByClassName('cart-block-list')[0].innerHTML = '<div class="empty-cart"> Корзина пустая </div>';
          document.getElementsByClassName('change-color-total')[0].innerHTML = '0грн';
        }

        cartBlock.style.display = "block";

        deleteCartItems = document.getElementsByClassName('cart-list-item-delete');
        for (var i = deleteCartItems.length - 1; i >= 0; i--) {
          deleteCartItems[i].addEventListener('click', function(){
            deleteBlock = this;
            totalprice = this.dataset.totalprice;
            ajax('/ajax/delete-cart-item?id=' + this.dataset.productid , function(data){
              if(data) {
                listItem = deleteBlock.parentNode.parentNode;
                listItem.style.display = 'none';
                listItem.nextSibling.style.display = 'none';
                changeTotal(totalprice);
              }
            });
          });
        };
      });
      cartClick = 1;
    } else {
      cart.style.background = "white";
      cartImage = cart.getElementsByTagName('img')[0];
      cartImage.setAttribute('src', '/site/images/icon-cart2.png');
      cartBlock = document.getElementById('cart-block');
      cartBlock.style.display = "none"; 
      cartClick = 0;
    }

  });


  document.getElementById('cartClose').addEventListener('click', function(){
    cart.style.background = "white";
    cartImage = cart.getElementsByTagName('img')[0];
    cartImage.setAttribute('src', '/site/images/icon-cart2.png');
    cartBlock.style.display = 'none';
    cartClick = 0;
  });


}



// Слайдер
mainSlider = document.getElementById('main-slider');
if(mainSlider != null) {
  images = mainSlider.getElementsByClassName('slider-image');
  length = images.length;



//Отображаем поинты
pointsBlock = document.getElementById('points');
pointsBlock.innerHTML += '<img src="/site/images/slider-rond.png" alt="">';
for (var i = length - 1; i >= 1; i--) {
  pointsBlock.innerHTML += '<img src="/site/images/slider-rond-active.png" alt="">';
};




//Отображаем первый текст
showText(0);

current = 1;
slideRight = document.getElementById('main-slide-right');

points = document.getElementById('points');


setInterval(function(){
  sliderImages = mainSlider.getElementsByClassName('slider-images')[0];
  if(current > images.length - 1) {
    current = 0;
  }

  changePoint(current + 1);
  changeMargin(current);
  showText(current);
  current++;
}, 3000);


// Клик по значку слайд вправо
slideRight.addEventListener('click', function(){
  sliderImages = mainSlider.getElementsByClassName('slider-images')[0];
  if(current > images.length - 1) {
    current = 0;
  }

  changePoint(current + 1);
  changeMargin(current);
  showText(current);
  current++;
});

slideLeft = document.getElementById('main-slide-left');

// клик по слайд влево
slideLeft.addEventListener('click', function(){

  if(current > 1) {
    changeMargin(current - 2);
    showText(current - 2);
    current--;
    changePoint(current);
  }
});

pointsImg = points.getElementsByTagName('img');

// Клики по поинтам
for(var i=0; i < pointsImg.length; i++) {
 (function(index) {
  pointsImg[index].addEventListener("click", function() {
    current = index + 1;
    changePoint(current);
    changeMargin(index);
    showText(index);
  });

})(i);

}


//Клик на слайдере по стрелке вверх
imgTop = document.getElementsByClassName('slide-top-img')[0];
imgTopClick = 0;
imgTop.addEventListener('click', function(){
  if(imgTopClick == 0) {
    document.getElementsByClassName('slide-text-content')[0].style.display = 'table';
    document.getElementsByClassName('slider-up')[0].style.marginLeft = '225px';
    document.getElementsByClassName('slider-up')[0].style.marginTop = '-125px';
    imgTop.getElementsByTagName('img')[0].setAttribute('src', '/site/images/slide-bg-down.png');
    document.getElementsByClassName('slide-top-img')[0].getElementsByTagName('img')[0].style.marginTop = '10px';
    imgTopClick = 1;
  } else {
    document.getElementsByClassName('slide-text-content')[0].style.display = 'none';
    document.getElementsByClassName('slider-up')[0].style.marginTop = '-27px';
    document.getElementsByClassName('slider-up')[0].style.marginLeft = '508px';
    imgTop.getElementsByTagName('img')[0].setAttribute('src', '/site/images/slide-bg-up.png');
    document.getElementsByClassName('slide-top-img')[0].getElementsByTagName('img')[0].style.marginTop = '0px';
    imgTopClick = 0;
  }
  
});
}


//Выпадающее меню 
catalog = document.getElementsByClassName('main-menu-item')[0];

catalog.addEventListener('mouseover', function(){
 document.getElementsByClassName('main-menu-dropdown')[0].style.display = 'block';
});

catalog.addEventListener('mouseout', function(){
  document.getElementsByClassName('main-menu-dropdown')[0].style.display = 'none';
});

document.getElementsByClassName('main-menu-line')[0].addEventListener('mouseover', function(event) {
 relTarget = event.relatedTarget;
 id = relTarget.getAttribute('id');
 if(id == 'catalog') {
  document.getElementsByClassName('main-menu-dropdown')[0].style.display = 'block';
}
});

document.getElementsByClassName('main-menu-dropdown')[0].addEventListener('mouseover',function(event){
 document.getElementsByClassName('main-menu-dropdown')[0].style.display = 'block';
});

document.getElementsByClassName('main-menu-dropdown')[0].addEventListener('mouseout',function(event){
 document.getElementsByClassName('main-menu-dropdown')[0].style.display = 'none';
});



//Слайдер брендов
brandsLeft  = document.getElementsByClassName('left-brands-slider')[0];

if(brandsLeft != null) {
  brandsRight = document.getElementsByClassName('right-brands-slider')[0];
  countImages = document.getElementsByClassName('brands-image').length - 6;

  curImage = 1;

  brandsLeft.addEventListener('click', function(){
    if(curImage > 1){
      curImage--;
      changeBrandsMargin(curImage);
    }

  });

  brandsRight.addEventListener('click', function(){
    if(curImage > countImages) {
      curImage = 1;
    } else {
      curImage++;
    }

    changeBrandsMargin(curImage);
  });


}

// Мобильная версия
mobileMenuClick = 0;
document.getElementsByClassName('mobile-menu-button')[0].addEventListener('click',function(){
  if(mobileMenuClick == 0) {
    document.getElementsByClassName('mobile-menu-list')[0].style.height = '306px';
    mobileMenuClick = 1;

    var mobileWhiteMenu = 0;
    var mobileWhiteMenuButton = document.getElementById('mobile-white-menu-button').addEventListener('click', function(){
     if(mobileWhiteMenu == 0) {
       document.getElementsByClassName('mobile-white-menu-list')[0].style.height = '185px';
       mobileWhiteMenu = 1;
     }else{
      document.getElementsByClassName('mobile-white-menu-list')[0].style.height = '0px';
      mobileWhiteMenu = 0;
    }
  });



  } else {
    document.getElementsByClassName('mobile-menu-list')[0].style.height = '0px';
    mobileMenuClick = 0;
    document.getElementsByClassName('mobile-white-menu-list')[0].style.height = '0px';
  }

});


recClick = 0;
//Показать больше рекомендованых
showRec = document.getElementById('show-rec');
if(showRec) {
  showRec.addEventListener('click', function() {
    heightBefore = document.getElementsByClassName('main-items-list')[0].clientHeight;
    ajax('ajax/recommended?click=' + recClick, function(data){
      data = JSON.parse(data);
      data.forEach(function(item, i, data){
        addItem(item,0);
      });
      heightAfter = document.getElementsByClassName('main-items-list')[0].clientHeight;
      scroll(heightAfter - heightBefore);
      document.getElementsByClassName('show-less-text')[0].style.display = 'block';
      recClick++;

      if(data.length != 8) {
        document.getElementById('show-rec').style.display = 'none';
      } else {
        ajax('ajax/recommended?click=' + recClick,function(data){
          if(data.length == 0) {
            document.getElementById('show-rec').style.display = 'none';
          }
        });
      }
    });

  });


//Свернуть рекомендованые элементы
document.getElementsByClassName('show-less-text')[0].addEventListener('click', function(){
  listItems = document.getElementsByClassName('main-items-list')[0].getElementsByClassName('main-item');
  heightBefore = document.getElementsByClassName('main-items-list')[0].clientHeight;
  for (var i = listItems.length - 1; i >= 4; i--) {
    remove(listItems[i]);
  };
  heightAfter = document.getElementsByClassName('main-items-list')[0].clientHeight;
  scroll(heightAfter - heightBefore);
  document.getElementsByClassName('show-less-text')[0].style.display = 'none';
  document.getElementById('show-rec').style.display = 'block';
  recClick = 0;
});


newClick = 0
// Показать больше новых товаров 
document.getElementsByClassName('show-more-text')[1].addEventListener('click', function(){
  heightBefore = document.getElementsByClassName('main-items-list')[1].clientHeight;
  ajax('ajax/new?click=' + newClick, function(data){
    data = JSON.parse(data);
    data.forEach(function(item, i, data){
      addItem(item,1);
    });
    heightAfter = document.getElementsByClassName('main-items-list')[1].clientHeight;
    document.getElementsByClassName('show-less-text')[1].style.display = 'block';
    scroll(heightAfter - heightBefore);
    // newClick++;
    document.getElementsByClassName('show-more-text')[1].style.display = 'none';
    // if(data.length != 8) {
    //   document.getElementsByClassName('show-more-text')[1].style.display = 'none';
    // } else {
    //   ajax('ajax/recommended?click=' + newClick,function(data){
    //     if(data.length == 0) {
    //       document.getElementByClassName('show-more-text')[1].style.display = 'none';
    //     }
    //   });
    // }
  });
});

//Свернуть новые элементы 
document.getElementsByClassName('show-less-text')[1].addEventListener('click', function(){
  listItems = document.getElementsByClassName('main-items-list')[1].getElementsByClassName('main-item');
  heightBefore = document.getElementsByClassName('main-items-list')[1].clientHeight;
  for (var i = listItems.length - 1; i >= 4; i--) {
    remove(listItems[i]);
  };
  heightAfter = document.getElementsByClassName('main-items-list')[1].clientHeight;
  scroll(heightAfter - heightBefore +170*(newClick + 1));
  newClick = 0;
  document.getElementsByClassName('show-less-text')[1].style.display = 'none';
  document.getElementsByClassName('show-more-text')[1].style.display = 'block';
});

}






sortSelect = document.getElementById('sort-select');
if(sortSelect != null) {
  url = location.href;
  // categoryUrl = url.split('/')[4];
  categoryUrl = document.getElementById('catUrl').value;



  sortSelect.addEventListener('change', function(){
    categoryUrl = document.querySelector('input[name="categoryUrl"]').value;
    ajax('/ajax/category-products?categoryUrl=' + categoryUrl + '&sortType=' +  sortSelect.value, function(data){
      showProducts(data);
    },1);

  });


  function sendPriceFilter(){
    startPrice = document.getElementById('startPrice').value
    stopPrice = document.getElementById('stopPrice').value
    categoryUrl = document.querySelector('input[name="categoryUrl"]').value;

    ajax('/ajax/category-products?startPrice=' + startPrice + '&stopPrice=' + stopPrice + '&categoryUrl=' + categoryUrl , function(data){
      showProducts(data);
    },1);
  }

  document.getElementById('startPrice').addEventListener('change', sendPriceFilter );
  document.getElementById('stopPrice').addEventListener('change', sendPriceFilter );

  attrs = document.getElementsByClassName('attr-checkbox');
  for (var i = attrs.length - 1; i >= 0; i--) {
    attrs[i].addEventListener('change', function(e){
      attr = this.dataset.attr;
      value = this.dataset.value;
      categoryUrl = document.querySelector('input[name="categoryUrl"]').value;

      if(this.checked) {
        ajax('/ajax/filter-checkbox-add?attr=' + attr + '&value=' + value + '&categoryUrl=' + categoryUrl, function(data){
          showProducts(data);
        },1);
      } else {
        ajax('/ajax/filter-checkbox-delete?attr=' + attr + '&value=' + value + '&categoryUrl=' + categoryUrl, function(data) {
          showProducts(data);
        },1);
      }

    });
  };




  brends = document.getElementsByClassName('brends-checkbox');

  if(brends) {
    for (var i = 0; i < brends.length; i++) {
      brends[i].addEventListener('click', function(){
        id = this.dataset.value;
        if(this.checked) {
          ajax('/ajax/filter-brend-add?id=' + id  + '&categoryUrl=' + categoryUrl, function(data){
            showProducts(data);
          },1);
        } else {
          ajax('/ajax/filter-brend-delete?id=' + id  + '&categoryUrl=' + categoryUrl, function(data) {
          // alert(data);
          showProducts(data);
        },1);
        }
      });
    }
  }

  document.getElementsByClassName('reset-filter')[0].addEventListener('click', function(){
    attrs = document.getElementsByClassName('attr-checkbox');
    categoryUrl = document.querySelector('input[name="categoryUrl"]').value;
    document.getElementById('availability').checked = false;
    for (var i = attrs.length - 1; i >= 0; i--) {
      attrs[i].checked = false;
    }
    ajax('/ajax/filter-clear?categoryUrl=' + categoryUrl, function(data){
      showProducts(data);
    });
  });

  document.getElementById('show-select').addEventListener('change', function(){
    showCount = this.value;

    ajax('/ajax/category-products?categoryUrl=' + categoryUrl + '&showCount=' + showCount, function(data){
      showProducts(data);
    });
  });


  subcats = document.getElementsByClassName('subcat-item');
  for (var i = subcats.length - 1; i >= 0; i--) {
    subcats[i].addEventListener('click', function(){
      subcatId = this.getAttribute('id');
      setActiveSubcat(subcatId);
      ajax('/ajax/category-products?categoryUrl=' + categoryUrl + '&subcatId=' + subcatId, function(data){
        showProducts(data);
      });
    });
  };


  btns = document.getElementsByClassName('grid-button')[0];

  if(btns) {
    document.getElementsByClassName('grid-button')[0].addEventListener('click', function(){

      if($_GET('page')) {
        page  = $_GET('page');
      } else {
        page = 1;
      }

      showType = 'table';
      changeViewButton(showType);
      ajax('/ajax/category-products?categoryUrl=' + categoryUrl + '&showType=' + showType + '&page=' + page, function(data){
        showProducts(data);
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
      ajax('/ajax/category-products?categoryUrl=' + categoryUrl + '&showType=' + showType + '&page=' + page, function(data){
        showProducts(data);
      });
    });
  }
}

subcatsFilter = document.getElementsByClassName('subcat-checkbox');

if(subcatsFilter) {
  for (var i = 0; i < subcatsFilter.length; i++) {
    subcatsFilter[i].addEventListener('click', function(){
      id = this.dataset.value;
      if(this.checked) {
        ajax('/ajax/filter-subcat-add?id=' + id  + '&brendUrl=' + brendUrl, function(data){
          showProducts(data);
        },1);
      } else {
        ajax('/ajax/filter-subcat-delete?id=' + id  + '&brendUrl=' + brendUrl, function(data) {
          showProducts(data);
        },1);
      }
    });
  }
}


desc = document.getElementById('product-description');
if(desc){
  desc.addEventListener('click', function(){
    document.getElementsByClassName('products-attributes-list')[0].style.display = 'block';
    document.getElementsByClassName('product-reviews')[0].style.display = 'none';

    document.getElementById('product-description').classList.add("products-menu-item-active");
    document.getElementById('product-rewiews').classList.remove("products-menu-item-active");
  });

  document.getElementById('product-rewiews').addEventListener('click', function(){
    document.getElementsByClassName('products-attributes-list')[0].style.display = 'none';
    document.getElementsByClassName('product-reviews')[0].style.display = 'block';

    document.getElementById('product-description').classList.remove("products-menu-item-active");
    document.getElementById('product-rewiews').classList.add("products-menu-item-active");
  });
}

descMob = document.getElementById('product-description-mobile');
if(descMob){
  descMob.addEventListener('click', function(){
    document.getElementsByClassName('products-attributes-list')[1].style.display = 'block';
    document.getElementsByClassName('product-reviews')[1].style.display = 'none';

    document.getElementById('product-description-mobile').classList.add("products-menu-item-active");
    document.getElementById('product-rewiews-mobile').classList.remove("products-menu-item-active");
  });

  document.getElementById('product-rewiews-mobile').addEventListener('click', function(){
    document.getElementsByClassName('products-attributes-list')[1].style.display = 'none';
    document.getElementsByClassName('product-reviews')[1].style.display = 'block';

    document.getElementById('product-description-mobile').classList.remove("products-menu-item-active");
    document.getElementById('product-rewiews-mobile').classList.add("products-menu-item-active");
  });
}


if(document.getElementsByClassName('product-fast-order')[0]) {
  document.getElementsByClassName('product-fast-order')[0].addEventListener('click', function(){
    document.getElementsByClassName('fast-order')[0].style.display = 'block';
  });

  document.getElementsByClassName('fast-order-close')[0].addEventListener('click', function(){
    document.getElementsByClassName('fast-order')[0].style.display = 'none';
  });

  document.getElementsByClassName('fast-order-small-input')[0].getElementsByTagName('input')[0].addEventListener('input', function(){
    price = this.dataset.price;
    count = this.value;
    totalPrice = price * count;
    document.getElementsByClassName('right-label')[0].innerHTML = 'Цена: ' + totalPrice + 'грн';
  });
}

if(document.getElementsByClassName('product-fast-order')[1]) {

  document.getElementsByClassName('product-fast-order')[1].addEventListener('click', function(){
    document.getElementsByClassName('fast-order')[0].style.display = 'block';
  });

  // document.getElementsByClassName('fast-order-close')[0].addEventListener('click', function(){
  //   document.getElementsByClassName('fast-order')[0].style.display = 'none';
  // });

  // document.getElementsByClassName('fast-order-small-input')[0].getElementsByTagName('input')[0].addEventListener('input', function(){
  //   price = this.dataset.price;
  //   count = this.value;
  //   totalPrice = price * count;
  //   document.getElementsByClassName('right-label')[0].innerHTML = 'Цена: ' + totalPrice + 'грн';
  // });
}


document.getElementById('mobile-search').addEventListener('click', function(){
  query = document.getElementById('mobile-search-input').value;
  window.location.replace( fullUrl + "/search/" + query);
});


search = document.getElementById('search-big-submit');
if(search) {
  search.addEventListener('click', function(){
    query = document.getElementById('searchInput1').value;
    window.location.replace( fullUrl + "/search/" + query);
  });

  document.getElementById('searchInput1').addEventListener('keydown', function(e){
    e = e || window.event;
    if (e.keyCode == 13)
    {
      search.click();
      return false;
    }
    return true;
  });

}

document.getElementById('searchInput').addEventListener('keydown', function(e){
  e = e || window.event;
  if (e.keyCode == 13)
  {
    document.getElementById('searchIcon').click();
    return false;
  }
  return true;
});

document.getElementById('searchIcon').addEventListener('click', function(){
  query = document.getElementById('searchInput').value;
  window.location.replace(fullUrl + "/search/" + query);
});


intake = document.getElementsByClassName('product-intake-text')[0];

if(intake) {
  intake.addEventListener('click', function(){
    document.getElementsByClassName('announce-the-immediate')[0].style.display = 'block';
  });

  document.getElementById('announce-close').addEventListener('click', function(){
    document.getElementsByClassName('announce-the-immediate')[0].style.display = 'none';
  });
}


intake1 = document.getElementsByClassName('product-intake-text')[1];

if(intake1) {
  intake1.addEventListener('click', function(){
    document.getElementsByClassName('announce-the-immediate')[0].style.display = 'block';
  });

  document.getElementById('announce-close').addEventListener('click', function(){
    document.getElementsByClassName('announce-the-immediate')[0].style.display = 'none';
  });
}

searchMag = document.getElementsByClassName('search-magnifier');

if(searchMag) {
  for (var i = 0; i < searchMag.length; i++) {
    searchMag[i].addEventListener('click', function(){
     showImages(this);
   });
  };
}


magnifiers = document.getElementsByClassName('magnifier');
productImage = document.getElementsByClassName('product-slider-current-image')[0];


cartMag = document.getElementsByClassName('cart-magnifier');

if(cartMag) {
  for (var i = cartMag.length - 1; i >= 0; i--) {
    cartMag[i].addEventListener('click', function(){
      showImages(this);
    });
  };
}

if(productImage) {
  productImage.addEventListener('click', function(){
    showImages(this);
  });
}

if(magnifiers) {
  for (var i = magnifiers.length - 1; i >= 0; i--) {
    magnifiers[i].addEventListener('click', function(){
      showImages(this);
    });
  };



  $(document).keydown(function(e) {
    if( e.keyCode === 27 ) {
      document.getElementsByClassName('show-images')[0].style.display = 'none';
      document.getElementsByClassName('show-images-content')[0].style.display = 'none';
      return false;
    }
  });
  // function pressed(e) { 
  //   if(e.which == 27) {
  //     document.getElementsByClassName('show-images')[0].style.display = 'none';
  //     document.getElementsByClassName('show-images-content')[0].style.display = 'none';
  //   }
  // }

  // window.captureEvents(Event.KEYPRESS); 
  // window.onkeypress = pressed; 



  document.getElementsByClassName('show-images-close')[0].addEventListener('click', function(){
    document.getElementsByClassName('show-images')[0].style.display = 'none';
    document.getElementsByClassName('show-images-content')[0].style.display = 'none';
  });


}

countInputs = document.getElementsByClassName('count-inputs');

if(countInputs) {
  for (var i = countInputs.length - 1; i >= 0; i--) {
    countInputs[i].addEventListener('change', function(){
     price = this.dataset.price;
     productid = this.dataset.productid;

     count = this.value;
     total = price*count;
     totalBlock = this.nextSibling.nextSibling;
     totalBlock.innerHTML = total + ' грн';
     globalTotal = 0;
     for (var i = countInputs.length - 1; i >= 0; i--) {
       globalTotal += countInputs[i].value * countInputs[i].dataset.price;
     };
     ajax('/ajax/change-count?productid=' + productid + '&count=' + count, function(data) {});

     document.getElementById('total').innerHTML = globalTotal + ' грн';
     discount = document.getElementById('discount').innerHTML;
     discount = parseInt(discount.substring(0, discount.length - 1));

     document.getElementById('discount-total').innerHTML = globalTotal - discount*globalTotal/100 + ' грн';
   });
  };
}


deleteCartItems = document.getElementsByClassName('cart-page-delete');

if(deleteCartItems) {
  for (var i = deleteCartItems.length - 1; i >= 0; i--) {
    deleteCartItems[i].addEventListener('click', function(){
     deleteBlock = this;
     totalprice = this.dataset.totalprice;
     ajax('/ajax/delete-cart-item?id=' + this.dataset.productid , function(data){
      if(data) {
        listItem = deleteBlock.parentNode;
        listItem.parentElement.removeChild(listItem);
        pageChangeTotal(totalprice);
      }
    });
   });
  };
}

buttonToLogin = document.getElementById("cart-to-login");

if(buttonToLogin) {
  click = 0;
  buttonToLogin.addEventListener("click", function(){
    var divToLogin = document.getElementById("login-in-cart");

    if(click == 0){
     divToLogin.style.cssText = "display:block;";
     buttonToLogin.style.cssText = "border-color:#616161"; 
     click = 1;
   }
   else{
    divToLogin.style.cssText = "display:none;";
    buttonToLogin.style.cssText = "border-color:##ebebeb"; 
    click = 0;
  }

});
}

buttonToLogin = document.getElementById("cart-to-login-mobile");

if(buttonToLogin) {
  click = 0;
  buttonToLogin.addEventListener("click", function(){
    var divToLogin = document.getElementById("login-in-cart-mobile");

    if(click == 0){
     divToLogin.style.cssText = "display:block;";
     buttonToLogin.style.cssText = "border-color:#616161"; 
     click = 1;
   }
   else{
    divToLogin.style.cssText = "display:none;";
    buttonToLogin.style.cssText = "border-color:##ebebeb"; 
    click = 0;
  }

});
}




deliveryCheckboxes = document.querySelectorAll("input[name='delivery[]']");

if(deliveryCheckboxes) {
  for (var i = deliveryCheckboxes.length - 1; i >= 0; i--) {
    deliveryCheckboxes[i].addEventListener('change', function(){

      changeAvailableChexboxes(this.value);


      for (var i = deliveryCheckboxes.length - 1; i >= 0; i--) {
        deliveryCheckboxes[i].checked = 0;
      };
      this.checked = 1;
    });
  };
}


paymentCheckboxes = document.querySelectorAll("input[name='payment[]']");

if(paymentCheckboxes) {
  for (var i = paymentCheckboxes.length - 1; i >= 0; i--) {
    paymentCheckboxes[i].addEventListener('change', function(){
      for (var i = deliveryCheckboxes.length - 1; i >= 0; i--) {
        if(deliveryCheckboxes[i].checked) {
          k = i;
        }
      }



      delStr = document.getElementById('delStr');
      delStr = delStr.value;
      delStr = JSON.parse(delStr);

      if(this.value == 'nalog') {
        if(k == 2) {
          setDeliveryCost(delStr.novanal);
        }
        if(k == 3) {
          setDeliveryCost(delStr.ukrnal);
        }
      } else {
        if(k == 2) {
          setDeliveryCost(delStr.novaposhta);
        }
        if(k == 3) {
          setDeliveryCost(delStr.ukrposhta);
        }

      }



      for (var i = paymentCheckboxes.length - 1; i >= 0; i--) {
        paymentCheckboxes[i].checked = 0;
      };
      this.checked = 1;
    });
  };
}


if(document.getElementById('header-list-call')) {
  document.getElementById('header-list-call').addEventListener('click', function(){
    hideOtherFeedbackBlocks();
    document.getElementById('callback-block').style.display = 'block';
  });
}



document.getElementById('callback-close').addEventListener('click', function(){
  document.getElementById('callback-block').style.display = 'none';
});

document.getElementById('header-list-feedback').addEventListener('click', function(){
  hideOtherFeedbackBlocks();
  document.getElementById('feedback-block').style.display = 'block';
});


document.getElementById('header-list-feedback-2').addEventListener('click', function(){
  hideOtherFeedbackBlocks();
  document.getElementById('feedback-block').style.display = 'block';
});

document.getElementById('feedback-close').addEventListener('click', function(){
  document.getElementById('feedback-block').style.display = 'none';
});

if(document.getElementById('register-close')) {
  document.getElementById('register-close').addEventListener('click', function(){
    document.getElementById('register-block').style.display = 'none';
  });
}


if(document.getElementById('sub-close')) {
  document.getElementById('sub-close').addEventListener('click', function(){
    document.getElementById('sub-block').style.display = 'none';
  });
}

if(document.getElementById('feedback-res-close')) {
  document.getElementById('feedback-res-close').addEventListener('click', function(){
    document.getElementById('feedback-res').style.display = 'none';
  });
}


if(document.getElementById('callback-res-close')) {
  document.getElementById('callback-res-close').addEventListener('click', function(){
    document.getElementById('callback-res').style.display = 'none';
  });
}

if(document.getElementById('header-list-send')) {
  document.getElementById('header-list-send').addEventListener('click', function(){
    hideOtherFeedbackBlocks();
    document.getElementById('sendmail-block').style.display = 'block';
  });
}



document.getElementById('sendmail-close').addEventListener('click', function(){
  document.getElementById('sendmail-block').style.display = 'none';
});


document.getElementById('send-mail-mobile').addEventListener('click', function(){
 hideOtherFeedbackBlocks();
 document.getElementById('sendmail-block').style.display = 'block';
});


document.getElementById('feedback-mobile').addEventListener('click', function(){
 hideOtherFeedbackBlocks();
 document.getElementById('feedback-block').style.display = 'block';
});


document.getElementById('callback-mobile').addEventListener('click', function(){
  hideOtherFeedbackBlocks();
  document.getElementById('callback-block').style.display = 'block';
});

// heartSearch = document.getElementsByClassName('category-spisok-heard')[0];

// if(heartSearch) {
//   heartSearch.getElementsByTagName('img')[0].setAttribute('src', )
// }


addWish = document.getElementsByClassName('products-add-to-wishlist')[0];

if(addWish) {
  addWish.addEventListener('click', function(){
    productid = this.dataset.productid;

    ajax('/ajax/add-wish?productid=' + productid, function(data){
      if(data == 1) {
        document.getElementsByClassName('products-wishlidt-text')[0].innerHTML = 'Добавить в желания';
        document.getElementsByClassName('products-wishlist-img')[0].getElementsByTagName('img')[0].setAttribute('src',  fullUrl +'/site/images/ixon-wishlist.png');
      } else {
        document.getElementsByClassName('products-wishlidt-text')[0].innerHTML = 'Удалить из желаний';
        document.getElementsByClassName('products-wishlist-img')[0].getElementsByTagName('img')[0].setAttribute('src',  fullUrl +'/site/images/ixon-wishlist-active.png');
      }
    });
  });
}

addWish1 = document.getElementsByClassName('products-add-to-wishlist')[1];

if(addWish1) {
  addWish1.addEventListener('click', function(){
    productid = this.dataset.productid;

    ajax('/ajax/add-wish?productid=' + productid, function(data){
      if(data == 1) {
        document.getElementsByClassName('products-wishlidt-text-mobile')[0].innerHTML = 'Добавить в желания';
        document.getElementsByClassName('products-wishlist-img')[1].getElementsByTagName('img')[0].setAttribute('src',  fullUrl +'/site/images/ixon-wishlist.png');
      } else {
        document.getElementsByClassName('products-wishlidt-text-mobile')[0].innerHTML = 'Удалить из желаний';
        document.getElementsByClassName('products-wishlist-img')[1].getElementsByTagName('img')[0].setAttribute('src',  fullUrl +'/site/images/ixon-wishlist-active.png');
      }
    });
  });
}


wishDelete = document.getElementsByClassName('wish-delete');

if(wishDelete) {
  for (var i = wishDelete.length - 1; i >= 0; i--) {
    wishDelete[i].addEventListener('click', function(){
      productid = this.dataset.productid;
      item = this;
      ajax('/ajax/delete-wish?productid=' + productid, function(data){
       item.parentNode.parentNode.removeChild(item.parentNode);
     });
    });
  };
}



hearts = document.getElementsByClassName('item-heart');

if(hearts) {
  for (var i = 0; i < hearts.length; i++) {
    hearts[i].addEventListener('click', function(){
      block = this;
      id = this.dataset.productid;
      ajax('/ajax/add-wish?productid=' + id, function(data){
        if(data == 1) {
          block.getElementsByTagName('img')[0].setAttribute('src', fullUrl + '/site/images/ixon-wishlist.png');
        } else {
          block.getElementsByTagName('img')[0].setAttribute('src',  fullUrl + '/site/images/ixon-wishlist-active.png');
        }
      });
    });
  };

}

var elemImage = document.getElementsByClassName("main-dropdown-item");
var slideArrowRight = document.getElementById('main-slide-left');
var slideArrowLeft = document.getElementById('main-slide-right');
var slideArrowRightSm = document.getElementById('slide-arow-sm-l');
var slideArrowLeftSm = document.getElementById('slide-arow-sm-r');


for (i=0; i < elemImage.length; i++){
  elemImage[i].addEventListener("mouseover", function(){
    var imageTag = this.getElementsByTagName('img')[0].getAttribute('src'); 
    var newImageTag = imageTag.replace(".png", "-hover.png");
    this.getElementsByTagName('img')[0].src = newImageTag;
  });
  elemImage[i].addEventListener("mouseout", function(){
    var imageTag = this.getElementsByTagName('img')[0].getAttribute('src'); 
    var newImageTag = imageTag.replace("-hover.png", ".png");
    this.getElementsByTagName('img')[0].src = newImageTag;
  });
}


var slideArrowRight = document.getElementById('main-slide-left');
if(slideArrowRight) {
  var slideArrowLeft = document.getElementById('main-slide-right');
  var slideArrowRightSm = document.getElementById('slide-arow-sm-l');
  var slideArrowLeftSm = document.getElementById('slide-arow-sm-r');

  slideArrowRight.addEventListener('mouseover', function(){
    var imageTag = slideArrowRight.getElementsByTagName('img')[0].getAttribute('src');  
    var newImageTag = imageTag.replace(".png", "-hover.png");
    slideArrowRight.getElementsByTagName('img')[0].src = newImageTag;
  })
  slideArrowRight.addEventListener('mouseout', function(){
    var imageTag = slideArrowRight.getElementsByTagName('img')[0].getAttribute('src');  
    var newImageTag = imageTag.replace("-hover.png", ".png");
    slideArrowRight.getElementsByTagName('img')[0].src = newImageTag;
  })
  slideArrowLeft.addEventListener('mouseover', function(){
    var imageTag = slideArrowLeft.getElementsByTagName('img')[0].getAttribute('src'); 
    var newImageTag = imageTag.replace(".png", "-hover.png");
    slideArrowLeft.getElementsByTagName('img')[0].src = newImageTag;
  })
  slideArrowLeft.addEventListener('mouseout', function(){
    var imageTag = slideArrowLeft.getElementsByTagName('img')[0].getAttribute('src'); 
    var newImageTag = imageTag.replace("-hover.png", ".png");
    slideArrowLeft.getElementsByTagName('img')[0].src = newImageTag;
  })
  slideArrowLeftSm.addEventListener('mouseover', function(){
    var imageTag = slideArrowLeftSm.getElementsByTagName('img')[0].getAttribute('src'); 
    var newImageTag = imageTag.replace(".png", "-hover.png");
    slideArrowLeftSm.getElementsByTagName('img')[0].src = newImageTag;
  })
  slideArrowLeftSm.addEventListener('mouseout', function(){
    var imageTag = slideArrowLeftSm.getElementsByTagName('img')[0].getAttribute('src'); 
    var newImageTag = imageTag.replace("-hover.png", ".png");
    slideArrowLeftSm.getElementsByTagName('img')[0].src = newImageTag;
  })
  slideArrowRightSm.addEventListener('mouseover', function(){
    var imageTag = slideArrowRightSm.getElementsByTagName('img')[0].getAttribute('src');  
    var newImageTag = imageTag.replace(".png", "-hover.png");
    slideArrowRightSm.getElementsByTagName('img')[0].src = newImageTag;
  })
  slideArrowRightSm.addEventListener('mouseout', function(){
    var imageTag = slideArrowRightSm.getElementsByTagName('img')[0].getAttribute('src');  
    var newImageTag = imageTag.replace("-hover.png", ".png");
    slideArrowRightSm.getElementsByTagName('img')[0].src = newImageTag;
  })
}

var sucessOrderForm = document.getElementById('sucess-order-form');
if(sucessOrderForm){
  var sucessClose = document.getElementsByClassName('success-close');
  for(i=0; i < sucessClose.length; i++){
    sucessClose[i].addEventListener('click', function(){
      sucessOrderForm.style.display = "none";
    });
  };}
  var sucessCartForm = document.getElementById('sucess-cart-form');
  if(sucessCartForm){
    setTimeout(function(){
      document.getElementById('sucess-cart-form').style.display = 'none';
    }, 1000);
  }



  var subcatMobButton = document.getElementById('subcat-button-mobileD');
  var subCatmobBlock = document.getElementById('subcategory-mobile-blockD');
  var filterMobButton = document.getElementById('filer-button-mobileD ');
  var filtermobBlock = document.getElementById('filter-mobile-blockD');
  var filterMobClose = document.getElementById('filter-mobile-close');
  var filtermobitem = document.getElementsByClassName('filter-mobile-item');
  var fiterItemsblock = document.getElementById('filter-mobile-item-items');



  if(subcatMobButton){

    subcatMobButton.addEventListener('click', function(){
     filtermobBlock.style.display = "none";
     subCatmobBlock.style.display = "block";
   });

    filterMobButton.addEventListener('click', function(){
      subCatmobBlock.style.display = "none";
      filtermobBlock.style.display = "block";

      filterMobClose.addEventListener('click', function(){
        filtermobBlock.style.display = "none";
      });



      for (i=0; i < filtermobitem.length; i++){

        filtermobitem[i].addEventListener('click', function(){
          var oldMobFilterItems = document.getElementsByClassName('filter-mobile-item-items');
          for(i=0; i < oldMobFilterItems.length; i++){
            oldMobFilterItems[i].style.display = 'none';
          }
          this.getElementsByClassName('filter-mobile-item-items')[0].style.display = 'block';
        });
      };
    });
  }



  elements = document.getElementsByClassName('mobile-subat-item-mobile');


  if(elements[0]) {
    for (var i = elements.length - 1; i >= 0; i--) {

      elements[i].addEventListener('click', function(){
       subcatId = this.dataset.subcateogoryid;
       categoryUrl = document.querySelector('input[name="categoryUrl"]').value;
       ajax('/ajax/category-products?categoryUrl=' + categoryUrl + '&subcatId=' + subcatId, function(data){
        data[2] = 'mobile';
        showProducts(data);
      });

     });
    }
  }

});