@extends('site.layout')



@section('headContent')
@if(Session::get('orderSuccess'))
<div class="sucess-order-alert" id="sucess-order-form">
  <div class="fast-order-title">
    <div class="fast-order-title fl">Ваш заказ успешно принят</div>
    <div class="intake-close fr success-close" ><img src="{{ url('site/images/close-photo.png') }}" alt=""></div>
  </div>

  <div class="sunny"><img src="site/images/smile-kv-sm.jpg"></div>
  <div class="fast-order-text">
   Спасибо за заказ. Мы свяжемся с Вами в ближайшее время.
 </div>
 <div class="cart-buttons">
  @if(Auth::check())
  <a href="/dashboard">
    <div class="cart-add-button">
      <div class="to-cart cart-buy">
        <div class="item-buy-image">
          <img src="{{ url('site/images/icon-account-wh.png') }}" alt="">
        </div>
        <div class="item-buy-text cart-text">
          Личный кабинет
        </div>
        <div class="item-buy-shadow cart-shadow"></div>
      </div>
    </div>
  </a>
  @endif
  <div class="close-issue fr success-close">
    <div class="to-cart cart-buy cart-close" >
      <div class="item-buy-text cart-close-text">
        Продолжить покупки
      </div>
    </div>
  </div>
</div>
<div class="fast-order-form-row"></div>
</div>

@endif
@stop



@section('content')


@if(!Auth::check() || Auth::user()->role == 'retail')

<div class="slide-left" id="main-slide-left">
 <img src="{{ url('site/images/arrow-big2.png') }}" alt="">
</div>
<div class="slide-right" id="main-slide-right">
 <img src="{{ url('site/images/arrow-big.png') }}" alt="">
</div>
<div class="points">
  <center>
    <div id="points">
    </div>
  </center>
</div>
<div class="slider" id="main-slider">
 <div class="slider-images">
  @foreach($mainSlides as $slide)
  <div class="slider-image">
    <img src="{{ url('slides_images/' . $slide->image) }}" alt="">
  </div>
  @endforeach

</div>
</div>
<div class="slider-up">
  <center>
    <div class="slide-top-img">
      <img src="{{ url('site/images/slide-bg-up.png') }}">
    </div>
    <div class="slide-text-content">
      @foreach($mainSlides as $slide)
      <div>
        {!!$slide->text!!}
      </div>
      @endforeach

    </div>
  </center>
</div>
<div class="slider-bg"></div>

@endif

<div class="main-title">
  Рекомендуем
</div>
<div class="main-title-line"></div>


@if(isset($recProducts))

<div class="main-items-list">
  @foreach($recProducts as $recProduct)
  <div class="main-item">

  @if($recProduct->new)
    <div class="new-item">
        <img src="{{ url('/site/images/new_item.png') }}">
    </div>
    @endif


   <div class="magnifier" data-productid="{{$recProduct->id}}">
     <img src="{{ url('site/images/icon-loop.png') }}" alt="">
   </div>
   <div class="item-image">
    @if($recProduct->image)
    <a href="/product/{{$recProduct->url}}">
      <img src="{{ url('product_images/' . $recProduct->image) }}">
    </a>
    @else
    <a href="/product/{{$recProduct->url}}">
      <img src="{{ url('site/images/zaglushka.png') }}" alt="">
    </a>
    @endif
  </div>
  <a href="/product/{{$recProduct->url}}">
    <div class="item-name">
      @if($recProduct->quantity > 2)
      <div class="availability"><img src="/site/images/add-cart-success.png" alt="">Есть в наличии</div>
      @else
      @if($recProduct->quantity == 0)
      <div class="availability"><img src="/site/images/icon-disavailability.png" alt="">Нет в наличии</div>
      @else
      <div class="availability"><img src="/site/images/icon-availability-attantion.png" alt="">Заканчивается</div>
      @endif
      @endif
      {{$recProduct->name}}
    </div>
  </a>
  <div class="item-bottom-line">
    <div class="item-price">
      {{$recProduct->price}} грн
    </div>
    <div class="item-buy" data-productid="{{$recProduct->id}}">
      <div class="item-buy-image">
        <img src="{{ url('site/images/icon-cart-main.png') }}" alt="">
      </div>
      <div class="item-buy-text">
        В корзину
      </div>
      <div class="item-buy-shadow"></div>
    </div>
  </div>
</div>
@endforeach
</div>

<div class="show-more">
  <div class="show-more-content">
    <div class="show-less-text">
      Свернуть
    </div>
    <div class="show-more-text" id="show-rec">
      Показать больше
    </div>
    <div class="show-more-image">
      <img src="{{ url('site/images/icon-arrow.png') }}" alt="">
    </div>
  </div>
</div>


@endif


<div class="main-title">
  Новинки
</div>
<div class="main-title-line"></div>


<div class="main-items-list">

  @foreach($newProducts as $newProduct)
  <div class="main-item">
    @if($newProduct->new)
    <div class="new-item">
        <img src="{{ url('/site/images/new_item.png') }}">
    </div>
    @endif

   <div class="magnifier" data-productid="{{$newProduct->id}}">
     <img src="{{ url('site/images/icon-loop.png') }}" alt="">
   </div>
   <div class="item-image">
     @if($newProduct->image)
     <a href="/product/{{$newProduct->url}}">
       @if($newProduct->category_id == 39) 
       <img src="{{ url('site/images/IMG_9745-450x300.png') }}">
       @else
       <img src="{{ url('product_images/' . $newProduct->image) }}">
       @endif
     </a>
     @else
     <a href="/product/{{$newProduct->url}}">
       <img src="{{ url('site/images/zaglushka.png') }}" alt="">
     </a>
     @endif
   </div>
   <a href="/product/{{$newProduct->url}}">
     <div class="item-name">
       @if($newProduct->quantity > 2)
       <div class="availability"><img src="/site/images/add-cart-success.png" alt="">Есть в наличии</div>
       @else
       @if($newProduct->quantity == 0)
       <div class="availability"><img src="/site/images/icon-disavailability.png" alt="">Нет в наличии</div>
       @else
       <div class="availability"><img src="/site/images/icon-availability-attantion.png" alt="">Заканчивается</div>
       @endif
       @endif
       {{$newProduct->name}}
     </div>
   </a>
   <div class="item-bottom-line">
    <div class="item-price">
      {{$newProduct->price}} грн
    </div>
    <div class="item-buy" data-productid="{{$newProduct->id}}">
      <div class="item-buy-image">
        <img src="{{ url('site/images/icon-cart-main.png') }}" alt="">
      </div>
      <div class="item-buy-text">
        В корзину
      </div>
      <div class="item-buy-shadow"></div>
    </div>
  </div>
</div>
@endforeach

</div>

<div class="show-more">
  <div class="show-more-content">
    <div class="show-less-text">
      Свернуть
    </div>
    <div class="show-more-text">
      Показать больше
    </div>
    <div class="show-more-image">
      <img src="{{ url('site/images/icon-arrow.png') }}" alt="">
    </div>
  </div>
</div>
<div class="clear"></div>
<div class="our-brands">
  Наши бренды
</div>
<div class="left-brands-slider" id="slide-arow-sm-l">
  <img src="{{ url('site/images/arrow-sm2.png') }}" alt="">
</div>
<div class="right-brands-slider" id="slide-arow-sm-r">
  <img src="{{ url('site/images/arrow-sm.png') }}" alt="">
</div>
<div class="brands-slider">
  <div class="brands-images">
    @foreach($brends as $brend)
    <div class="brands-image">
      <a href="/brend-products/{{$brend->url}}">
        <img src="{{ url('brends_images/' . $brend->logo) }}" alt="">
      </a>
    </div>
    @endforeach
  </div>
</div>

@stop

@section('mobile')

<div class="mobile-yellow-line"></div>
<div class="mobile-slider">
 <div class="mobile-slider-image">
  <img src="{{ url('site/images/4d5bbf6752863b73c9dc5077dam3--materialy-dlya-tvorchestva-muline-fabriki-im.png') }}" alt="">
</div>
<div class="mobile-slider-text">
  Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus fuga assumenda vero in necessitatibus vel, nesciunt ex autem deleniti eligendi.
</div>
</div>

<div class="mobile-title">
  Рекомендуем
</div>
<div class="mobile-title-line"></div>

@if(isset($recProducts))
<div class="mobile-products-list">
  @foreach($recProducts as $recProduct)
  <div class="mobile-product">
    <div class="mobile-product-image">
      @if($recProduct->image)
      <a href="/product/{{$recProduct->url}}">
        <img src="{{ url('product_images/' . $recProduct->image) }}">
      </a>
      @else
      <a href="/product/{{$recProduct->url}}">
        <img src="{{ url('site/images/zaglushka.png') }}" alt="">
      </a>
      @endif
    </div>
    <a href="/product/{{$newProduct->url}}">
      <div class="mobile-product-name">
       {{$recProduct->name}}
     </div>
   </a>
   <div class="mobile-product-bottom-line">
    <div class="mobile-product-price">
      {{$recProduct->price}} грн
    </div>
    <div class="mobile-product-add-to-cart" data-productid="{{$recProduct->id}}">
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
@endif
<!-- <div class="mobile-show-more">
    <div>Показать больше <div class="mobile-more-img"><img src="{{ url('site/images/more-arrow.png') }}" alt=""></div></div>
  </div> -->
  <div class="mobile-title">
    Новинки
  </div>
  <div class="mobile-title-line"></div>

  <div class="mobile-products-list">
    @foreach($newProducts as $newProduct)
    <div class="mobile-product">
      <div class="mobile-product-image">
       @if($newProduct->image)
       <a href="/product/{{$newProduct->url}}">
         @if($newProduct->category_id == 39) 
         <img src="{{ url('site/images/IMG_9745-450x300.png') }}">
         @else
         <img src="{{ url('product_images/' . $newProduct->image) }}">
         @endif
       </a>
       @else
       <a href="/product/{{$newProduct->url}}">
         <img src="{{ url('site/images/zaglushka.png') }}" alt="">
       </a>
       @endif
     </div>
     <a href="/product/{{$newProduct->url}}">
      <div class="mobile-product-name">
       {{$newProduct->name}}
     </div>
   </a>
   <div class="mobile-product-bottom-line">
    <div class="mobile-product-price">
     {{$newProduct->price}} грн
   </div>
   <div class="mobile-product-add-to-cart" data-productid="{{$newProduct->id}}">
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
<!-- 
<div class="mobile-show-more">
    <div>Показать больше <div class="mobile-more-img"><img src="{{ url('site/images/more-arrow.png') }}" alt=""></div></div>
  </div> -->


  @stop