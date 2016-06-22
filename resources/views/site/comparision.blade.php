@extends('site.layout')

@section('content')
    <div class="comparesion">
        <div class="title">Сравнение товаров</div>
        @if(!empty($products))
            <a href="/clear-comparison">
                <div class="clear-comparison-button">Очистить список</div>
            </a>
            <div class="table">
                <div class="table-header">
                    <div class="product name">Название</div>
                    <div class="product photo">Изображение</div>
                    <div class="product cost">Цена</div>
                    @foreach($attributes as $attribute)
                        <div class="product cost">{{$attribute->name}}</div>
                    @endforeach
                    <div class="product">
                        Наличие
                    </div>
                    <div class="product buttons"></div>
                </div>
                <div class="table-columns">

                    @foreach($products as $product)
                        <div class="item"
                             @if(count($products) == 1) style="width: 100%;" @endif
                             @if(count($products) == 2) style="width: 49.7%;" @endif
                             @if(count($products) == 3) style="width: 33.1%;" @endif
                             @if(count($products) == 4) style="width: 24.71%;" @endif
                        >
                            <div class="product name">
                                <div class="">
                                    <a href="/product/{{$product->url}}">{{$product->name}}</a>
                                </div>
                            </div>
                            <div class="magnifier"
                                 @if(count($products) == 1) style="margin-left: 610px;" @endif
                                 @if(count($products) == 2) style="margin-left: 350px;" @endif
                                 @if(count($products) == 3) style="margin-left: 240px;" @endif
                                 @if(count($products) == 4) style="margin-left: 180px;" @endif
                                 data-productid="{{$product->id}}">
                                <img src="/site/images/icon-loop.png" alt="">
                            </div>
                            <div class="product photo">
                                @if($product->new)
                                    <div class="new-item-comparison">
                                        <img src="{{ url('/site/images/new_item.png') }}">
                                    </div>
                                @endif
                                <a href="/product/{{$product->url}}">
                                    @if(!$product->image)
                                        <img src="{{ url('site/images/zaglushka.png') }}" alt="">
                                    @else
                                        <img src="{{ url('product_images/' . $product->image) }}" alt="item">
                                    @endif
                                </a>

                            </div>
                            <div class="product cost">{{$product->price}}грн</div>

                            @if(isset($product->attrs))
                            @foreach($product->attrs as $attr)
                                <div class="product size">
                                    @if(!isset($attr) || $attr == '')
                                        -
                                    @else
                                        {{$attr}}
                                    @endif
                                </div>
                            @endforeach
                            @endif
                            <div class="product size">
                                {{$product->avail}}
                            </div>
                            <div class="product buttons">
                                <div class="btn-panel">
                                    <div class="toCart-but" data-productid="{{$product->id}}">
                                        <img src="{{ url('site/images/icon-cart.png') }}" alt="">
                                        <div class="text">В корзину</div>
                                    </div>
                                    <a href="/comparison-delete/{{$product->id}}">
                                        <div class="delete-but">
                                            <img src="{{ url('/site/images/delete-xxl.png') }}" alt="del">
                                            <div class="text">Удалить</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <p>В списке сравнений нет товаров</p>
        @endif
        <div class="clear"></div>
    </div>
@stop