@extends('site.layout')

@section('content')
@include('elements.breadcrumbs')
<div class="category-content">
 <div class="clear"></div>
 <div class="category-title">
  Поиск по сайту
</div>
<div class="category-title-line">
</div>

<div class="search-mail fl">
  <div class="search-header">
    Не смогли найти?
  </div>
  <div class="search-content">

   <div class="reviews-form">
    <form action="/send-feedback" method="POST" id="add-review">
      <input type="hidden" value="{{csrf_token()}}" name="_token">
      <div class="search-form-title">Напишите нам</div>

      <div class="search-form">
        <div class="search-form-label">
          Имя:
        </div>
        <div class="search-form-input">
          <input type="text" name="name">
        </div>
        <div class="search-form-label">
          Email:
        </div>
        <div class="search-form-input">
          <input type="text" name="email">
        </div>
        <div class="search-form-label">
          Телефон:
        </div>
        <div class="search-form-input">
          <input type="text" class="phone" name="phone">
        </div>
        <div class="search-form-label">
          Сообщение:
        </div>
        <div class="search-form-textarea">
          <textarea name="comment"></textarea>
        </div>
        <div class="search-form-submit">
          <button>Отправить</button>
        </div>
      </div>


    </form>
  </div>
</div>
</div>

<div class="category-products-content fl">


  <div class="search-big">
    <input type="text" name="query" value="{{$query}}" placeholder="Введите запрос" id="searchInput1">

    <div class="search-big-icon">
     <input type="submit" id="search-big-submit" value=""></input>
   </div>
 </div>
 @if(count($products) != 0)
 <div class="category-list">

  @foreach($products as $product)
  <div class="category-spisok-item">
   <div class="category-spisok-image fl">
   <div class="search-magnifier" data-productid="{{$product->id}}">
       <img src="{{ url('site/images/icon-loop.png') }}" alt="">
     </div>

          @if($product->image)
     <a href="/product/{{$product->url}}">
       @if($product->category_id == 39) 
       <img src="{{ url('site/images/IMG_9745-450x300.png') }}">
       @else
       <img src="{{ url('product_images/' . $product->image) }}">
       @endif
     </a>
     @else
     <a href="/product/{{$product->url}}">
       <img src="{{ url('site/images/zaglushka.png') }}" alt="">
     </a>
     @endif

     
   </div>
   <div class="category-spisok-info fl">
     <div class="category-spisok-title"><a href="/product/{{$product->url}}">{{$product->name}}</a></div>
     <div class="availability-spisok"><img src="{{ url('site/images/add-cart-success.png') }}" alt="">Есть в наличии</div>
     <div class="category-spisok-text">
       {!!$product->description!!}
     </div>
   </div>
   <div class="category-spisok-other fr">
     <div class="category-spisok-heard item-heart" data-productid="{{$product->id}}">
     @if(isset($product->wish))
     <img src="{{ url('site/images/ixon-wishlist-active.png') }}" alt="">
     @else
     <img src="{{ url('site/images/ixon-wishlist.png') }}" alt="">
     @endif

   </div>
   <div class="category-spisok-price">{{$product->price}}грн</div>
   <div class="category-spisok-add-to-cart item-buy" data-productid="{{$product->id}}">

    <div class="item-buy-image">
      <img src="{{ url('site/images/icon-cart-main.png') }}" alt="">
    </div>
    <div class="item-buy-text">
      В корзину
    </div>
    <div class="item-buy-shadow spisok-shadow"></div>

  </div>
</div>
</div>
<div class="category-spisok-line"></div>
@endforeach
@else
<p>Поиск не дал результатов</p>
@endif
</div>
<?php echo $products->render(); ?>
</div>
</div>
@stop



@section('mobile')
<div class="mobile-list">
@foreach($products as $product)
    <div class="mobile-product">
        <div class="mobile-product-image">
              @if($product->image)
        <a href="/product/{{$product->url}}">
            <img src="{{ url('product_images/' . $product->image) }}">
        </a>
        @else
        <a href="/product/{{$product->url}}">
            <img src="{{ url('site/images/zaglushka.png') }}" alt="">
        </a>
        @endif
        </div>
        <a href="/product/{{$product->url}}">
            <div class="mobile-product-name">
                 {{$product->name}}
            </div>
        </a>
        <div class="mobile-product-bottom-line">
            <div class="mobile-product-price">
                {{$product->price}} грн
            </div>
            <div class="mobile-product-add-to-cart" data-productid="{{$product->id}}">
               <div class="mobile-add-button">
                <div class="mobile-add-image">
                    <img src="{{ url('site/images/icon-cart-main.png') }}" alt="">
                </div>
                <div class="mobile-add-text">
                    В корзину
                </div>
            </div>
            <div class="mobile-add-bottom-line">

            </div>
        </div>
    </div>
</div>

@endforeach
</div>

<?php echo $products->render(); ?>


@stop