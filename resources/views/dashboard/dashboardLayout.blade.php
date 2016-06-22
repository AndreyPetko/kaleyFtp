@extends('site.layout')


@section('content')
@include('elements.breadcrumbs')
<div class="category-content">
 <div class="clear"></div>
 <div class="category-title">
   Личный кабинет
 </div>
 <div class="category-title-line">
 </div>

 <div class="account-left fl">
  <div class="account-left-title">
   <span>Email:</span> {{Auth::user()->email}}
 </div>
 <div class="account-left-info">
  <div class="account-info-l fl"> Покупок на сумму:</div><div class="account-info-r fl"> {{$userTotalPrice}} грн</div>
  <div class="account-info-l fl">Текущая скидка:</div><div class="account-info-r fl"> {{Auth::user()->discount}}%</div>

</div>
<a href='/dashboard/edit-account' class="account-edit-button">
  Редактировать учетную запись
</a>

@if(Request::url() != 'http://kaleydoskop.ap.org.ua/dashboard')
<a href='/dashboard' class="account-section">
  Личный кабинет
</a>
<!-- <div class="account-center-title">
 Покупки
</div> -->
<a href='/dashboard/orders-history' class="account-section">
  История заказов
</a>
<!-- <a href='/dashboard/orders-status' class="account-section">
 Статусы заказов
</a>
<a href='/dashboard/payment-history' class="account-section">
  История платежей
</a> -->
<!-- <div class="account-center-title">
 Товары
</div> -->
<a href='/wishlist' class="account-section">
 Список желаний
</a>
<a href='#' class="account-section">
 Список сравнений
</a>
@endif

</div>


@yield('dashboardContent')


<div class="account-wishlist fl">
 <div class="account-right-title">
   Товары в списке желаний
 </div>

 @if($lastWish)
 @foreach($lastWish as $lastWishItem)
 <div class="main-item">
   <div class="magnifier" data-productid="{{$lastWishItem->id}}">
     <img src="{{ url('site/images/icon-loop.png') }}" alt="">
   </div>
   <div class="item-image">
    <a href="/product/{{$lastWishItem->url}}">
    @if(isset($lastWishItem->image))
    <img src="{{ url('product_images/' . $lastWishItem->image) }}" alt="">
    @else
    <img src="{{ url('site/images/zaglushka.png') }}" alt="">
    @endif
    </a>
  </div>
  <a href="/product/{{$lastWishItem->url}}">
    <div class="item-name">
      <div class="availability"><img src="{{ url('site/images/add-cart-success.png') }}" alt="">Есть в наличии</div>
      {{$lastWishItem->name}}
    </div>
  </a>
  <div class="item-bottom-line">
    <div class="item-price">
      {{$lastWishItem->price}} грн
    </div>
    <div class="item-buy" data-productid="{{$lastWishItem->id}}">
      <div class="item-buy-image">
        <img src="{{ url('site/images/icon-cart-main.png') }}" alt="">
      </div>
      <div class="item-buy-text">
        В корзину
      </div>
      
    </div>
  </div>
</div>
@endforeach

@else

<div class="empty-cart">
  Список желаний пуст
</div>

@endif



</div>
</div>
<div class="clear"></div>


@stop



@section('mobile')
<div class="category-title">
 Личный кабинет
</div>
<div class="category-title-line">
</div>
@yield('dashboardMobile')

@stop