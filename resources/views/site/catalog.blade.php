@extends('site.layout')

@section('header')

<script>
    var katalogButtonOpen = document.getElementsByClassName('category-button');
    var katalogButtonOpenMobile = document.getElementsByClassName('category-button-mobile');
    var subCategory = document.createElement('div');
    subCategory.setAttribute('id', 'subCategory');
    function buttonClear(){
        for(i =0; i< katalogButtonOpen.length; i++){
            katalogButtonOpen[i].classList.remove("to-katalog-active");
        }
    };
    function hide(item) {
     document.getElementById('subCategory').parentNode.removeChild(document.getElementById('subCategory'));
     item.style.display = 'none';
     buttonClear();
 }
 window.addEventListener("load", function(){

    function insertAfter( node, referenceNode ) {
        if ( !node || !referenceNode ) return;
        var parent = referenceNode.parentNode, nextSibling = referenceNode.nextSibling;
        if ( nextSibling && parent ) {
            parent.insertBefore(node, referenceNode.nextSibling);
        } else if ( parent ) {
            parent.appendChild( node );
        }
    };

    for(i=0; i < katalogButtonOpen.length; i++){
        (function(index) {

            katalogButtonOpen[index].addEventListener("click", function() {
                 buttonClear();
                    this.className += " to-katalog-active";

                categoryid = this.dataset.categoryid;
                categoryUrl = document.getElementById('category-' + categoryid).value;
                ajax('/ajax/subcategories-by-category-id?id=' + categoryid, function(data) {
                    data = JSON.parse(data);
                    document.getElementsByClassName('subcategories-list')[0].innerHTML = '';
                    if(!data.length) {
                        document.getElementsByClassName('subcategories-list')[0].innerHTML = 'У этой категории нет подкатегорий';
                    } else {
                        for (var i = 0; i < data.length; i++) {
                            document.getElementsByClassName('subcategories-list')[0].innerHTML += '<a href="/category/' + categoryUrl + '?subcategory=' + data[i].id + '"><div class="subcat-item subcat-hover fl">' +
                            '<div class="subcat-image fl">' +
                            '<img src="site/images/icon-catecory-list.png" alt="">' +
                            '</div>' +
                            '<div class="subcat-text  fl">' +
                            data[i].name +
                            '</div>' +
                            '</div></a>';
                        };
                    }



                    curent = Math.ceil((index + 1) / 4);   
                    var subCategoryBlock = document.getElementById('subcategory-katalog');
                    subCategory.innerHTML = subCategoryBlock.innerHTML;
                    curIndex = curent*4 - 1;
                    if(!document.getElementsByClassName('category-button')[curIndex]) {
                        list = document.getElementsByClassName('category-button');
                        curIndex = list.length - 1;
                    }
                    curItem = document.getElementsByClassName('category-button')[curIndex].parentNode.parentNode;

                    insertAfter(subCategory, curItem);
                    // subCategoryBlock.style.display="block";
                    subCategory.style.display="block";
                    var elemImage = document.getElementsByClassName("subcat-hover");
                    for (i=0; i < elemImage.length; i++){
                        elemImage[i].addEventListener("mouseover", function(){
                            this.getElementsByTagName('img')[0].setAttribute("src", "{{ url('site/images/icon-catecory-list-active.png') }}");
                        });
                        elemImage[i].addEventListener("mouseout", function(){
                            this.getElementsByTagName('img')[0].setAttribute("src", "{{ url('site/images/icon-catecory-list.png') }}");
                        });
                    }


                });

});


})(i);
};


 for(i=0; i < katalogButtonOpenMobile.length; i++){
        (function(index) {

            katalogButtonOpenMobile[i].addEventListener("click", function() {
                 buttonClear();
                    // this.className += " to-katalog-active";

                categoryid = this.dataset.categoryid;
                categoryUrl = document.getElementById('category-' + categoryid).value;
                ajax('/ajax/subcategories-by-category-id?id=' + categoryid, function(data) {
                    data = JSON.parse(data);
                    document.getElementsByClassName('subcategories-list')[0].innerHTML = '';
                    if(!data.length) {
                        document.getElementsByClassName('subcategories-list')[0].innerHTML = 'У этой категории нет подкатегорий';
                    } else {
                        for (var i = 0; i < data.length; i++) {
                            document.getElementsByClassName('subcategories-list')[0].innerHTML += '<a href="/category/' + categoryUrl + '?subcategory=' + data[i].id + '"><div class="subcat-item subcat-hover fl">' +
                            '<div class="subcat-image fl">' +
                            '<img src="site/images/icon-catecory-list.png" alt="">' +
                            '</div>' +
                            '<div class="subcat-text  fl">' +
                            data[i].name +
                            '</div>' +
                            '</div></a>';
                        };
                    }


                    var curIndex = Math.ceil(index); 
                    var subCategoryBlock = document.getElementById('subcategory-katalog');
                    subCategory.innerHTML = subCategoryBlock.innerHTML;
                    curItem = document.getElementsByClassName('category-button-mobile')[curIndex].parentNode.parentNode;
                    insertAfter(subCategory, curItem);
                    // subCategoryBlock.style.display ="block";
                    subCategory.style.display="block";
         
                });



});


})(i);
};

});


</script>

@stop


@section('content')
@include('elements.breadcrumbs')
<div class="clear"></div>

<div id="subcategory-katalog">
    <div class="clear"></div>

    <div class="subcategories-list">

    </div>
    <div class="clear"></div>
    <div id="close-subcategory" onclick="hide(this);">Свернуть <img src="{{ url('site/images/icon-arrow.png') }}"></div>

</div>

<div class="category-content">
    <div class="category-katalog-content">
        <div class="category-title">
            Категории
        </div>
        <div class="category-title-line">
        </div>


        @foreach($catalog as $catalogItem)
        <input type="hidden" id="category-{{$catalogItem->id}}" value="{{$catalogItem->url}}">
        <div class="category-pre">
            <a href="/category/{{$catalogItem->url}}">
                @if($catalogItem->image)
                <img src="{{ url('/category_images/' . $catalogItem->image) }}">
                @else
                <img src="{{ url('site/images/IMG_9745-450x300.png') }}" alt="">
                @endif
                <a href="/category/{{$catalogItem->url}}"><div class="category-pre-title">{{$catalogItem->name}}</div></a>
                <div class="category-pre-info">
                    <p>Товаров:{{$catalogItem->countProducts}}<br> От 0 до 
                        @if($catalogItem->maxPrice)
                        {{$catalogItem->maxPrice}}
                        @else
                        0
                        @endif
                        грн</p><div class="category-button" data-categoryid="{{$catalogItem->id}}">Подкатегории</div>
                    </div>

                </a>
            </div>
            @endforeach


            <div class="clear"></div>

        </div>
<!--         <div class="pagination">
            <ul>
                <li>1</li>
                <li class="pagination-active">2</li>
                <li>3</li>
            </ul>
        </div> -->
    </div>

    @stop

    @section('mobile')
    @include('elements.breadcrumbs')

 
    <div id="subcategory-katalog">
    <div class="clear"></div>

    <div class="subcategories-list">

    </div>
    <div class="clear"></div>
    <div id="close-subcategory" onclick="hide(this);">Свернуть <img src="{{ url('site/images/icon-arrow.png') }}"></div>

</div>



     <div class="category-title">
            Категории
        </div>
        <div class="category-title-line">
        </div>

  @foreach($catalog as $catalogItem)
        <input type="hidden" id="category-{{$catalogItem->id}}" value="{{$catalogItem->url}}">
        <div class="category-pre-mobile">
            <a href="/category/{{$catalogItem->url}}">
                @if($catalogItem->image)
                <img src="{{ url('/category_images/' . $catalogItem->image) }}">
                @else
                <img src="{{ url('site/images/IMG_9745-450x300.png') }}" alt="">
                @endif
                <a href="/category/{{$catalogItem->url}}"><div class="category-pre-title-mobile">{{$catalogItem->name}}</div></a>
                <div class="category-pre-info">
                    <p>Товаров:{{$catalogItem->countProducts}}<br> От 0 до 
                        @if($catalogItem->maxPrice)
                        {{$catalogItem->maxPrice}}
                        @else
                        0
                        @endif
                        грн</p><div class="category-button-mobile" data-categoryid="{{$catalogItem->id}}">Подкатегории</div>
                    </div>

                </a>
                <div class="clear"></div>
            </div>
            @endforeach
             <div class="clear"></div>
    @stop