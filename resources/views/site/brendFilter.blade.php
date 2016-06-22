@extends('site.layout')


@section('header')
<script src="{{ url('site/brends.js') }}"></script>
@stop


@section('content')
@include('elements.breadcrumbs')
<input type="hidden" id="brendUrl" value="{{$brend->url}}">
<div class="clear"></div>




<div class="category-content">
    <div class="category-filter fl">
        <div class="filter-header">
            ФИЛЬТР
        </div>
        <div class="filter-content">
            <div class="filter-title">
                ЦЕНА
            </div>
            <div class="filter-price">
                <div class="filter-from fl">
                    <span class="filter-grey">От</span> <input value="0" id="brendMinPrice"> <span class="filter-currency">ГРН</span>
                </div>
                <div class="filter-to fr">
                    <span class="filter-grey">До</span> <input value="{{$maxPrice}}" id="brendMaxPrice"> <span class="filter-currency">ГРН</span>
                </div>
            </div>


            <div class="filter-grey-line">
                <img src="{{ url('site/images/filter-line.png') }}" alt="">
            </div>
            <div class="filter-title">
                Подкатегории
            </div>
            <div class="filter-grey-line">
                <img src="{{ url('site/images/filter-line.png') }}" alt="">
            </div>

            @foreach($subcategories as $subcategory)
            <div class="filter-value">
                <div class="filter-checkbox fl">
                    <input type="checkbox" @if(Session::get('subcat')) @if(in_array($subcategory->id, Session::get('subcat'))) checked @endif @endif class="subcat-checkbox"  data-value='{{$subcategory->id}}'>
                </div>
                <div class="filter-value-text fl">
                    {{$subcategory->name}}
                </div>
            </div>
            @endforeach

            @foreach($brendAttributes as $name => $attr)
            <div class="filter-grey-line">
                <img src="{{ url('site/images/filter-line.png') }}" alt="">
            </div>
            <div class="filter-title">
                {{$name}}
            </div>
            <div class="filter-grey-line">
                <img src="{{ url('site/images/filter-line.png') }}" alt="">
            </div>
            
            @foreach($attr as $value)
            <div class="filter-value">
                <div class="filter-checkbox fl">
                    <input type="checkbox" @if(Session::get('brendFilter.' . $name)) @if(in_array($value, Session::get('brendFilter.' . $name))) checked @endif @endif class="attr-checkbox" data-attr='{{$name}}' data-value='{{$value}}'>
                </div>
                <div class="filter-value-text fl">
                    {{$value}}
                </div>
            </div>
            @endforeach

            @endforeach


            <div class="reset-filter">
                <div class="reset-filter-img fl">
                    <img src="{{ url('site/images/refresh-icon-green.png') }}" alt="">
                </div>
                <div class="reset-filter-text fl" id="brend-reset">
                    СБРОСИТЬ ФИЛЬТР
                </div>
            </div>
        </div>

        <div class="filter-header brends-list">
            ДРУГИЕ БРЕНДЫ
        </div>
        <div class="filter-content">
            @foreach($brends as $brendsItem)
            <a href="/brend-products/{{$brendsItem->url}}">
                <div @if($brendsItem->id == $brend->id) class="article-filter-title-act other-brends-list" @else class="article-filter-title other-brends-list" @endif>
                    {{$brendsItem->name}}
                </div>
            </a>
            @endforeach
        </div>
    </div>
    
    <div class="category-products-content fl">
        <div class="category-title">
            {{$brend->name}}
        </div>
        <div class="category-title-line">
        </div>
        
        <div class="category-description">
            {!!$brend->preview!!}
        </div>

        <div class="clear"></div>
        
        <div class="subcat-sort-line">
            @if(!Session::get('brendsShowType') || Session::get('brendsShowType') == 'table')
            <div class="grid-button fl">
                <img src="{{ url('site/images/sort-tabl-active.png') }}" alt="">
            </div>
            <div class="line-button fl">
                <img src="{{ url('site/images/sort-spisok.png') }}" alt="">
            </div>
            @else
            <div class="grid-button fl">
                <img src="{{ url('site/images/sort-tabl.png') }}" alt="">
            </div>
            <div class="line-button fl">
                <img src="{{ url('site/images/sort-spisok-active.png') }}" alt="">
            </div>
            @endif
            
            <div class="sort-by fl">
                <div class="sort-by-text fl">
                    Сортировать по: 
                    <select id="brendOrderBy">
                        <option value="name">Названию</option>
                        <option value="price">Цене</option>
                    </select>
                </div>
                <!-- <div class="sort-by-img fl"> -->
                <!-- <img src="{{ url('site/images/chck-icon.png') }}" alt=""> -->
                <!-- </div> -->
            </div>
            
            <div class="show-by fl">
                <div class="sort-by-text fl">
                    Показывать по: 
                    <select id="brendsShowCount">
                        <option value='9' @if(Session::get('brendsShowCount') == 9) selected @endif>9</option>
                        <option value='18' @if(Session::get('brendsShowCount') == 18) selected @endif>18</option>
                        <option value='27' @if(Session::get('brendsShowCount') == 27) selected @endif>27</option>
                    </select>
                </div>
                <!-- <div class="sort-by-img fl"> -->
                <!-- <img src="{{ url('site/images/chck-icon.png') }}" alt=""> -->
                <!-- </div> -->
            </div>
        </div>
        

        <div class="category-list">
            @if(count($products) != 0)
            @foreach($products as $product)
            @if(!Session::get('brendsShowType') || Session::get('brendsShowType') == 'table')
            <div class="category-item fl">
                @if($product->new)
                <div class="new-item-category">
                    <img src="{{ url('/site/images/new_item.png') }}">
                </div>
                @endif

                <div class="magnifier" data-productid="{{$product->id}}">
                   <img src="{{ url('site/images/icon-loop.png') }}" alt="">
               </div>
               <div class="item-image">
                   <a href="/product/{{$product->url}}">
                       @if($product->category_id == 39)
                       <img src="{{ url('site/images/IMG_9745-450x300.png') }}">
                       @else
                       <img src="{{ url('product_images/' . $product->image) }}" alt="">
                       @endif
                   </a>
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
                <div class="item-price category">
                    {{$product->price}} грн
                </div>
                <div class="item-heart fl" data-productid="{{$product->id}}">
                    @if(isset($product->wish))
                    <img src="{{ url('site/images/ixon-wishlist-active.png') }}" alt="">
                    @else
                    <img src="{{ url('site/images/ixon-wishlist.png') }}" alt="">
                    @endif
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
        @else
        <div class="category-spisok-item">
            @if($product->new)
            <div class="new-item-list">
                <img src="{{ url('/site/images/new_item.png') }}">
            </div>
            @endif
            <div class="category-spisok-image fl">
                <a href="/product/{{$product->url}}">
                    <img src="{{ url('product_images/' . $product->image) }}" alt="">
                </a>
            </div>
            <div class="category-spisok-info fl">
                <a href="/product/{{$product->url}}">
                    <div class="category-spisok-title">
                        {{$product->name}}
                    </div>
                </a>
                <div class="availability-spisok"><img src="{{ url('site/images/add-cart-success.png') }}" alt="">Есть в наличии</div>
                <div class="category-spisok-text">
                    {!! $product->description !!}
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
        @endif
        @endforeach
        @else
        <div class="no-products">
            Нет товаров
        </div>
        @endif

    </div>



    <div id="pagination">
        <?php echo $products->render(); ?>
    </div>
</div>
</div>
@stop