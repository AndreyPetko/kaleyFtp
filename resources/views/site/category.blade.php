@extends('site.layout')

@section('js')
<script src="{{ url('dist/js/category.js') }}"></script>

@stop

@section('content')

@if(isset($theads))
<input type="hidden" value="1" id="threads">
@endif

<input type="hidden" name="categoryUrl" id="catUrl" value="{{$category->url}}">
@include('elements.breadcrumbs')

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
					<span class="filter-grey">От</span> <input id="startPrice"  @if(Session::get('startPrice')) value="{{Session::get('startPrice')}}" @else  value="0" @endif> <span class="filter-currency">ГРН</span>
				</div>
				<div class="filter-to fr">
					<span class="filter-grey">До</span> <input  id="stopPrice" @if(Session::get('stopPrice')) value="{{Session::get('stopPrice')}}" @else value="{{$maxPrice}}" @endif> <span class="filter-currency">ГРН</span>
				</div>
			</div>

			<div class="filter-grey-line">
				<img src="{{ url('site/images/filter-line.png') }}" alt="">
			</div>
			<div class="filter-title">
				Бренды
			</div>
			<div class="filter-grey-line">
				<img src="{{ url('site/images/filter-line.png') }}" alt="">
			</div>

			@foreach($brends as $brend)
			<div class="filter-value">
				<div class="filter-checkbox fl">
					<input type="checkbox" @if(Session::get('brends')) @if(in_array($brend->id, Session::get('brends'))) checked @endif @endif class="brends-checkbox"  data-value='{{$brend->id}}'>
				</div>
				<div class="filter-value-text fl">
					{{$brend->name}}
				</div>
			</div>
			@endforeach

			@if($attributesValues)
			@foreach($attributesValues as $key => $attributesValue)
			<div class="filter-grey-line">
				<img src="{{ url('site/images/filter-line.png') }}" alt="">
			</div>
			<div class="filter-title">
				{{$key}}
			</div>
			<div class="filter-grey-line">
				<img src="{{ url('site/images/filter-line.png') }}" alt="">
			</div>

			@foreach($attributesValue as $el)
			<div class="filter-value">
				<div class="filter-checkbox fl">
					<input type="checkbox" @if(Session::get('filter.' . $key)) @if(in_array($el, Session::get('filter.' . $key))) checked @endif @endif class="attr-checkbox" data-attr='{{$key}}' data-value='{{$el}}'>
				</div>
				<div class="filter-value-text fl">
					{{$el}}
				</div>
			</div>
			@endforeach
			@endforeach
			@endif


			<div class="filter-grey-line">
				<img src="{{ url('site/images/filter-line.png') }}" alt="">
			</div>
			<div class="filter-title">
				Наличие
			</div>
			<div class="filter-grey-line">
				<img src="{{ url('site/images/filter-line.png') }}" alt="">
			</div>


			<div class="filter-value">
				<div class="filter-checkbox fl">
					<input type="checkbox" id="availability"></input>
				</div>
				<div class="filter-value-text fl">
					Есть в наличии
				</div>
			</div>


			<div class="reset-filter">
				<div class="reset-filter-img fl">
					<img src="{{ url('site/images/refresh-icon-green.png') }}" alt="">
				</div>
				<div class="reset-filter-text fl">
					СБРОСИТЬ ФИЛЬТР
				</div>
			</div>
		</div>
	</div>
	<div class="category-products-content fl">
		<div class="category-title">
			{{$category->name}}
		</div>
		<div class="category-title-line">
		</div>

		<div class="category-description">
			{!! $category->description !!}
		</div>
		@if($subcategories)
		<div class="subcategories-title" id="categorySubCategoryButton">
			Перейти в подкатегорию 
			<div id="block-tria"></div>
		</div>
		<div class="subcategories-list" id="categorySubCategoryDiv">


			<div class="subcat-item fl" id="0">
				<div class="subcat-image-home fl">
					<img src="{{ url('/site/images/imagesGG60IGZZ.png') }}" alt="">
				</div>
				<div class="subcat-text @if(empty(Session::get('subcatId')) || Session::get('subcatId') == 0 ) subcat-text-active @endif fl">
					{{$category->name}}
				</div>
			</div>

			@foreach($subcategories as $subcategory)
			@if(Session::get('subcatId') != $subcategory->id)
			<div class="subcat-item fl" id="{{$subcategory->id}}">
				<!-- <a href="/subcategory/{{$subcategory->url}}"> -->
				<div class="subcat-image fl">
					<img src="{{ url('site/images/icon-catecory-list.png') }}" alt="">
				</div>
				<div class="subcat-text fl">
					{{$subcategory->name}}
				</div>
				<!-- </a> -->
			</div>
			@else
			<div class="subcat-item fl" id="{{$subcategory->id}}">
				<div class="subcat-image fl">
					<img src="{{ url('site/images/icon-catecory-list-active.png') }}" alt="">
				</div>
				<div class="subcat-text subcat-text-active fl">
					{{$subcategory->name}}
				</div>
			</div>

			@endif
			@endforeach

		</div>
		@endif

		<div class="clear"></div>

		<div class="subcat-sort-line">
			@if(!isset($theads))
			@if(!empty(Session::get('showType')) && Session::get('showType') != 'table')
			<div class="grid-button fl">
				<img src="{{ url('site/images/sort-tabl.png') }}" alt="">
			</div>
			<div class="line-button fl">
				<img src="{{ url('site/images/sort-spisok-active.png') }}" alt="">
			</div>
			@else
			<div class="grid-button fl">
				<img src="{{ url('site/images/sort-tabl-active.png') }}" alt="">
			</div>
			<div class="line-button fl">
				<img src="{{ url('site/images/sort-spisok.png') }}" alt="">
			</div>

			@endif
			@endif
	<div class="show-by fl">
				<div class="sort-by-text fl">
					Показывать по: 
					<!-- 12 -->
					<select id="show-select">
						<option value='9' @if(Session::get('brendsShowCount') == 9) selected @endif>9</option>
						<option value='18' @if(Session::get('brendsShowCount') == 18) selected @endif>18</option>
						<option value='27' @if(Session::get('brendsShowCount') == 27) selected @endif>27</option>
					</select>
				</div>
				<div class="sort-by-img fl">
					<!-- <img src="{{ url('site/images/chck-icon.png') }}" alt=""> -->
				</div>
			</div>
			<div class="sort-by fl">
				<div class="sort-by-text fl">
					Сортировать по:
					<!-- цене -->
					<select id="sort-select">
						<option value='name' @if(Session::get('sortType') == 'name') selected @endif>Названию</option>
						<option value='price' @if(Session::get('sortType') == 'price') selected @endif>Цене</option>
					</select>
				</div>
				<div class="sort-by-img fl">
					<!-- <img src="{{ url('site/images/chck-icon.png') }}" alt=""> -->
				</div>
			</div>

		
		</div>

		<div class="category-list">
			@if(count($products) != 0)
			@if(!isset($theads))
			@foreach($products as $product)
			@if(!Session::get('showType') || Session::get('showType') == 'table')
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

				<div class="category-spisok-image fl">
					@if($product->new)
					<div class="new-item-list">
						<img src="{{ url('/site/images/new_item.png') }}">
					</div>
					@endif
					<div class="search-magnifier" data-productid="{{$product->id}}">
						<img src="http://kaleydoskop.ap.org.ua/site/images/icon-loop.png" alt="">
					</div>
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
				<div class="category-spisok-info fl">
					<a href="/product/{{$product->url}}">
						<div class="category-spisok-title">
							{{$product->name}}
						</div>
					</a>
					@if($product->quantity > 2)
					<div class="availability-spisok"><img src="/site/images/add-cart-success.png" alt="">Есть в наличии</div>
					@else
					@if($product->quantity == 0)
					<div class="availability-spisok"><img src="/site/images/icon-disavailability.png" alt="">Нет в наличии</div>
					@else
					<div class="availability-spisok"><img src="/site/images/icon-availability-attantion.png" alt="">Заканчивается</div>
					@endif

					@endif
					<div class="category-spisok-text">
						{!! $product->description !!}
					</div>
				</div>
				<div class="category-spisok-other fr">
					<div class="category-spisok-heard">
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
			@foreach($products as $product)
			<div class="thread-item fl">
				<a href="/product/{{$product->url}}">
					@if($product->new)
					<div class="new-item-threads">
						<img src="{{ url('/site/images/new_item.png') }}">
					</div>
					@endif
					<div class="thread-image"
					 @if($product->image)
					  style="background-image:url('{{ url('/product_images/' . $product->image) }}');"
					  @else
					  style="background-image:url('{{ url('/site/images/main-logo.png') }}'); background-size: contain; background-repeat: no-repeat; background-position: center;"
					   @endif></div>
				</a>
				<a href="/product/{{$product->url}}">
					<div class="thread-item-name">
						{{$product->name}}
						@if($product->quantity > 2)
						<div class="availability-spisok"><img src="/site/images/add-cart-success.png" alt="">Есть в наличии</div>
						@else
						@if($product->quantity == 0)
						<div class="availability-spisok"><img src="/site/images/icon-disavailability.png" alt="">Нет в наличии</div>
						@else
						<div class="availability-spisok"><img src="/site/images/icon-availability-attantion.png" alt="">Заканчивается</div>
						@endif

						@endif
					</div>
				</a>
				<div class="thread-item-txt-left fl">
					<p>Цена:</p>
					<p>Кол-во:</p>
				</div>
				<div class="thread-item-txt-left fl">
					<p>{{$product->price}} грн</p>
					<input type="text">
				</div>
				<div class="thread-button fr" data-productid="{{$product->id}}">
					В корзину
				</div>
			</div>
			@endforeach
			@endif

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

@section('mobile')

@if(isset($theads))
<input type="hidden" value="1" id="threads">
@endif

<input type="hidden" name="categoryUrl" id="catUrl" value="{{$category->url}}">
@include('elements.breadcrumbs')
<div class="category-title">
	{{$category->name}}
</div>
<div class="category-title-line">
</div>
<div class="category-description">
	{!! $category->description !!}
</div>
<div class="category-title-line" style="background-color:#c6d932"></div>
<div class="sort-mobile">
	<div class="filer-button-mobile fl" id="filer-button-mobileD ">	<img src="{{ url('site/images/icon-filter-mobile.png') }}" alt="">Фильтр</div>
	<div class="subcat-button-mobile fl" id="subcat-button-mobileD">	<img src="{{ url('site/images/icon-subcat-mobile.png') }}" alt="">Подкатегории</div>

</div>
<div class="clear"></div>
<div class="subcategory-mobile-block" id="subcategory-mobile-blockD">
	<div class="mobile-cart-item-mobile">{{$category->name}}</div>
	@foreach($subcategories as $subcategory)
	<div class="mobile-subat-item-mobile fl" data-subcateogoryid="{{$subcategory->id}}"><img src="{{ url('site/images/icon-catecory-list.png') }}" alt="">{{$subcategory->name}}</div>
	@endforeach
</div>
<div class="clear"></div>
<div class="filter-mobile-block" id="filter-mobile-blockD">
	<div id="filter-mobile-close"><img src="{{ url('site/images/close-photo.png') }}" alt=""></div>
	<div class="filter-mobile-item-price">Цена</div>
	<div class="filter-mobile-price">
		<div class="mobile-filter-price-line">От<input  id="stopPrice" @if(Session::get('stopPrice')) value="{{Session::get('stopPrice')}}" @else value="{{$maxPrice}}" @endif> <span class="filter-currency">ГРН</span> </div>
		<div class="mobile-filter-price-line">До<input  id="stopPrice" @if(Session::get('stopPrice')) value="{{Session::get('stopPrice')}}" @else value="{{$maxPrice}}" @endif> <span class="filter-currency">ГРН</span> </div>
	</div>

	@if($attributesValues)

	<div class="filter-mobile-item">Опция
		<div class="filter-mobile-item-items">
			<div class="filter-value">
				<div class="filter-checkbox fl">
					<input type="checkbox" @if(Session::get('filter.' . $key)) @if(in_array($el, Session::get('filter.' . $key))) checked @endif @endif class="attr-checkbox" data-attr='{{$key}}' data-value='{{$el}}'>
				</div>
				<div class="filter-value-text fl">
					{{$el}}
				</div>
			</div>
			<div class="filter-value">
				<div class="filter-checkbox fl">
					<input type="checkbox" @if(Session::get('filter.' . $key)) @if(in_array($el, Session::get('filter.' . $key))) checked @endif @endif class="attr-checkbox" data-attr='{{$key}}' data-value='{{$el}}'>
				</div>
				<div class="filter-value-text fl">
					{{$el}}
				</div>
			</div>
			<div class="filter-value">
				<div class="filter-checkbox fl">
					<input type="checkbox" @if(Session::get('filter.' . $key)) @if(in_array($el, Session::get('filter.' . $key))) checked @endif @endif class="attr-checkbox" data-attr='{{$key}}' data-value='{{$el}}'>
				</div>
				<div class="filter-value-text fl">
					{{$el}}
				</div>
			</div>
			<div class="filter-items=mobile-bottom-line">
				<div id="filter">
				</div>
			</div>
		</div>
	</div>

	@endif


	<div class="reset-filter">
		<div class="reset-filter-img fl">
			<img src="{{ url('site/images/refresh-icon-green.png') }}" alt="">
		</div>
		<div class="reset-filter-text fl">
			СБРОСИТЬ ФИЛЬТР
		</div>
	</div>

</div>
<div class="clear"></div>
<div class="sort-by-text-mobile fl">
	Сортировать по:
	<!-- цене -->
	<select id="sort-select">
		<option value='name' @if(Session::get('sortType') == 'name') selected @endif>Названию</option>
		<option value='price' @if(Session::get('sortType') == 'price') selected @endif>Цене</option>
	</select>
</div>
<div class="sort-by-text-mobile fl">
	Показывать по: 
	<!-- 12 -->
	<select id="show-select">
		<option value='9' @if(Session::get('brendsShowCount') == 9) selected @endif>9</option>
		<option value='18' @if(Session::get('brendsShowCount') == 18) selected @endif>18</option>
		<option value='27' @if(Session::get('brendsShowCount') == 27) selected @endif>27</option>
	</select>
</div>
<div class="clear"></div>

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
<div id="pagination">
			<?php echo $products->render(); ?>
		</div>
<div class="clear"></div>
@stop
