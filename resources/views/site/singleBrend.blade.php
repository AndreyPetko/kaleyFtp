@extends('site.layout')


@section('content')
@include('elements.breadcrumbs')
<div class="clear"></div>


<div class="category-content">
	<div class="category-filter fl">
		<div class="filter-header">
			Другие бренды
		</div>
		<div class="filter-content">

			<div class="filter-grey-line">
				<img src="{{ url('site/images/filter-line.png') }}" alt="">
			</div>
			@foreach($brends as $brendsItem)
			<a href="/brend/{{$brendsItem->url}}">
			<div @if($brendsItem->id == $brend->id) class="article-filter-title-act"  @else class="article-filter-title" @endif>
					{{$brendsItem->name}}
				</div>
			</a>
			@endforeach
		</div>
	</div>
	<div class="category-single-art-content fl">
		<div class="category-title">
			{{$brend->name}}
		</div>
		<div class="category-title-line">
		</div>
		<div class="brend-img">  <img src="{{ url('brends_images/' . $brend->logo) }}"> </div>
		<div class="brend-preview">
			{!!$brend->preview!!}
		</div>
		<div class="clear"></div>
		<div class="article-content">
			{!!$brend->description!!}
		</div>



		@if($brend->thread == 0)
		<a href="/brend-products/{{$brend->url}}"><div class="brend-button">Полный каталог товаров {{$brend->name}}</div></a>
		@endif
	</div>




	<div class="clear"></div>




</div>


@stop


@section('mobile')
@include('elements.breadcrumbs')

<div class="category-title">
			{{$brend->name}}
		</div>
		<div class="category-title-line">
		</div>
<div class="brend-img-mobile">  <img src="{{ url('brends_images/' . $brend->logo) }}"> </div>
		<div class="brend-preview-mobile">
			{!!$brend->preview!!}
		</div>
		<div class="clear"></div>
		<div class="article-content">
			{!!$brend->description!!}
		</div>


		<a href="/brend-products/{{$brend->url}}"><div class="brend-button-mobile">Полный каталог товаров {{$brend->name}}</div></a>
@stop