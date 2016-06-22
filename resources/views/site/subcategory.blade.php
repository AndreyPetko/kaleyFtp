@extends('site.layout')


@section('content')
<input type="hidden" name="categoryUrl" value="{{$categoryUrl}}">
<div class="breadcrumbs">
	<div class="home-image fl">
		<img src="{{ url('site/images/imagesGG60IGZZ.png') }}" alt="">
	</div>
	<div class="breadcrumbs-next fl">
		<img src="{{ url('site/images/%D0%92%D0%B5%D0%BA%D1%82%D0%BE%D1%80%D0%BD%D1%8B%D0%B9-%D1%81%D0%BC%D0%B0%D1%80%D1%82-%D0%BE%D0%B1%D1%8A%D0%B5%D0%BA%D1%82-%D0%BA%D0%BE%D0%BF%D0%B8%D1%8F-2.png') }}" alt="">
	</div>
	<div class="breadcrumbs-text fl">
		Раздел
	</div>
	<div class="breadcrumbs-next fl">
		<img src="{{ url('site/images/%D0%92%D0%B5%D0%BA%D1%82%D0%BE%D1%80%D0%BD%D1%8B%D0%B9-%D1%81%D0%BC%D0%B0%D1%80%D1%82-%D0%BE%D0%B1%D1%8A%D0%B5%D0%BA%D1%82-%D0%BA%D0%BE%D0%BF%D0%B8%D1%8F-2.png') }}" alt="">
	</div>
	<div class="breadcrumbs-text fl">
		Подраздел
	</div>
</div>

<div class="clear"></div>

<div class="add-to-cart-block">
	<div class="add-image fl">
		<img src="{{ url('site/images/icon-add-cart.png') }}" alt="">
	</div>
	<div class="add-text fl">
		Вы успешно добавили <span class="green-name">Название товара</span> в <a href="">корзину</a>
	</div>
</div>


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
					<span class="filter-grey">От</span> <input id="startPrice" value="0"> <span class="filter-currency">ГРН</span>
				</div>
				<div class="filter-to fr">
					<span class="filter-grey">До</span> <input  id="stopPrice" value="1000"> <span class="filter-currency">ГРН</span>
				</div>
			</div>
			<div class="filter-grey-line">
				<img src="{{ url('site/images/filter-line.png') }}" alt="">
			</div>

			@foreach($attributesValues as $key => $attributesValue)
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
			{{$subcategory->name}}
		</div>
		<div class="category-title-line">
		</div>


		@if($subcategories)
		<div class="subcategories-title">
			Перейти в подкатегорию:
		</div>
		<div class="subcategories-line"></div>
		<div class="subcategories-list">


			<div class="subcat-item fl">
				<a href="/category/{{$subcategory->categoryUrl}}">
					<div class="subcat-image-home fl">
						<img src="{{ url('/site/images/imagesGG60IGZZ.png') }}" alt="">
					</div>
					<div class="subcat-text fl">
						{{$subcategory->categoryName}}
					</div>
				</a>
			</div>

			@foreach($subcategories as $subcategoriesItem)
			@if($subcategoriesItem->id == $subcategory->id)
			<div class="subcat-item fl">
				<div class="subcat-image fl">
					<img src="{{ url('site/images/icon-catecory-list-active.png') }}" alt="">
				</div>
				<div class="subcat-text subcat-text-active fl">
					{{$subcategoriesItem->name}}
				</div>
			</div>
			@else
			<div class="subcat-item fl">
				<a href="/subcategory/{{$subcategoriesItem->url}}">
					<div class="subcat-image fl">
						<img src="{{ url('site/images/icon-catecory-list.png') }}" alt="">
					</div>
					<div class="subcat-text fl">
						{{$subcategoriesItem->name}}
					</div>
				</a>
			</div>
			@endif
			@endforeach

		</div>
		@endif


		<div class="clear"></div>

		<div class="subcat-sort-line">
			<div class="grid-button fl">
				<img src="{{ url('site/images/sort-tabl.png') }}" alt="">
			</div>
			<div class="line-button fl">
				<img src="{{ url('site/images/sort-spisok-active.png') }}" alt="">
			</div>

			<div class="sort-by fl">
				<div class="sort-by-text fl">
					Сортировать по: 
					<!-- цене -->
					<select id="sort-select">
						<option value='price'>Цене</option>
						<option value='name'>Названию</option>
					</select>
				</div>
				<div class="sort-by-img fl">
					<!-- <img src="{{ url('site/images/chck-icon.png') }}" alt=""> -->
				</div>
			</div>

			<div class="show-by fl">
				<div class="sort-by-text fl">
					Показывать по: 12
				</div>
				<div class="sort-by-img fl">
					<img src="{{ url('site/images/chck-icon.png') }}" alt="">
				</div>
			</div>
		</div>

		<div class="category-list">
			@foreach($products as $product)
			<div class="category-item fl">
				<div class="magnifier">
					<img src="{{ url('site/images/icon-loop.png') }}" alt="">
				</div>
				<div class="item-image">
					<img src="{{ url('product_images/' . $product->image) }}" alt="">
				</div>
				<div class="item-name">
					{{$product->name}}
				</div>
				<div class="item-bottom-line">
					<div class="item-price category">
						{{$product->price}} грн
					</div>
					<div class="item-heart fl">
						<img src="{{ url('site/images/ixon-wishlist.png') }}" alt="">
					</div>
					<div class="item-buy">
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
<!-- 		<div class="pagination">
			<ul>
				<li>1</li>
				<li class="pagination-active">2</li>
				<li>3</li>
			</ul>
		</div> -->
	</div>
</div>


@stop