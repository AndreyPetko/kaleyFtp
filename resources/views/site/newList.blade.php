@extends('site.layout')


@section('content')
@include('elements.breadcrumbs')
<div class="contacts-title">Новинки</div>
<div class="new-list">

    @foreach($products as  $key => $product)

    <div class="main-item">
    @if($product->new)
    <div class="new-item">
        <img src="{{ url('/site/images/new_item.png') }}">
    </div>
    @endif

     <div class="magnifier" data-productid="{{$product->id}}">
         <img src="{{ url('site/images/icon-loop.png') }}" alt="">
     </div>
     <div class="item-image">
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
        <div class="item-name">
            @if($product->quantity > 2)
            <div class="availability"><img src="/site/images/add-cart-success.png" alt="">Есть в наличии</div>
            @else
            @if($product->quantity == 0)
            <div class="availability"><img src="/site/images/icon-disavailability.png" alt="">Нет в наличии</div>
            @else
            <div class="availability"><img src="/site/images/icon-availability-attantion.png" alt="">Заканчивается</div>
            @endif
            @endif
            {{$product->name}}
        </div>
    </a>
    <div class="item-bottom-line">
        <div class="item-price">
            {{$product->price}} грн
        </div>
        <div class="item-buy" data-productid="{{$product->id}}">
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

@stop

