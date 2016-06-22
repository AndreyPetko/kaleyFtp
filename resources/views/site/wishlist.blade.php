@extends('site.layout')


@section('content')
@include('elements.breadcrumbs')
<div class="clear"></div>




<div class="category-content">

  <div class="wishlist-content">
    <div class="category-title">
      Список желаний
    </div>
    <div class="category-title-line">
    </div>

    <div class="category-list">
      @if($wishlist)
      @foreach($wishlist as $wishlistItem)
      <div class="wish-item fl">
        <div class="wish-delete" data-productid="{{$wishlistItem->id}}"></div>

        <div class="magnifier" data-productid="{{$wishlistItem->id}}">
         <img src="{{ url('site/images/icon-loop.png') }}" alt="">
        </div>
          @if($wishlistItem->new)
              <div class="new-item">
                  <img src="{{ url('/site/images/new_item.png') }}">
              </div>
          @endif
          <div class="item-image">
         <a href="/product/{{$wishlistItem->url}}">
           @if(!$wishlistItem->image)
           <img src="{{ url('site/images/zaglushka.png') }}" alt="">
           @else
           <img src="{{ url('product_images/' . $wishlistItem->image) }}" alt="item">
           @endif
         </a>
       </div>
       <a href="/product/{{$wishlistItem->url}}">
        <div class="item-name">
          <div class="availability"><img src="{{ url('site/images/add-cart-success.png') }}" alt="">Есть в наличии</div>
          {{$wishlistItem->name}}
        </div>
      </a>
      <div class="item-bottom-line">
        <div class="item-price category">
          {{$wishlistItem->price}} грн
        </div>
        <div class="item-comp fl" data-productid="{{$wishlistItem->id}}">
         @if($wishlistItem->comp)
         <img src="{{ url('site/images/icon-compare.png') }}" alt="">
         @else
         <img src="{{ url('/site/images/icon-compare-grey.png') }}">
         @endif
       </div>
       <div class="item-buy" data-productid="{{$wishlistItem->id}}">
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
  <div class="no-wishlist">
    Список желаний пуст
  </div>
  @endif







</div>
</div>

</div>
<script>
  var oneWish = document.getElementsByClassName('wish-item');
  for(i=0; i < oneWish.length; i++){
    oneWish[i].addEventListener("mouseover", function(){
      this.firstChild.nextSibling.style.display = "block";

    })
    oneWish[i].addEventListener("mouseout", function(){
      this.firstChild.nextSibling.style.display = "none";

    })
  }

</script>
@stop

@section('mobile')
@include('elements.breadcrumbs')


<div class="category-content">

  <div class="wishlist-content">
    <div class="category-title">
      Список желаний
    </div>
    <div class="category-title-line">
    </div>

    <div class="category-list">
      @if($wishlist)
      @foreach($wishlist as $wishlistItem)
      <div class="wish-item-mobile">
        <div class="wish-delete" data-productid="{{$wishlistItem->id}}"></div>

        <div class="item-image-mobile">
         <a href="/product/{{$wishlistItem->url}}">
          <img src="{{ url('/product_images/' . $wishlistItem->image) }}" alt="">
        </a>
      </div>
      <a href="/product/{{$wishlistItem->url}}">
        <div class="item-name-mobile">
          {{$wishlistItem->name}}
        </div>
      </a>
      <div class="item-bottom-line">
        <div class="item-price category">
          {{$wishlistItem->price}} грн
        </div>
        <div class="item-comp fl" data-productid="{{$wishlistItem->id}}">
         @if($wishlistItem->comp)
         <img src="{{ url('site/images/icon-compare.png') }}" alt="">
         @else
         <img src="{{ url('/site/images/icon-compare-grey.png') }}">
         @endif
       </div>
       <div class="item-buy" data-productid="{{$wishlistItem->id}}">
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
  <div class="no-wishlist">
   Список желаний пуст
 </div>
 @endif







</div>
</div>

</div>

@stop