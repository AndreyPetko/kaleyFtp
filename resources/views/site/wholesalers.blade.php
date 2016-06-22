@extends('site.layout')



@section('content')
@include('elements.breadcrumbs')

<div class="category-title">
	Оптовикам
</div>
<div class="category-title-line"></div>

<div class="wholesalers-text">
	{!! $textVar !!}
</div>


@if(Auth::check() && (Auth::user()->role == 'wholesaler' || Auth::user()->role == 'ander' ))

@if(count($files))

<div class="download-price-title">
	Загрузить оптовый прайс
</div>

<div class="price-files">


	@foreach($files as $file)
	<div class="price-item">
		<div class="price-item-name fl">
			{{$file->name}}
		</div>
		<a href="/download/{{$file->id}}">
			<div class="price-button fr">
				Скачать
			</div>
		</a>
	</div>
	@endforeach


</div>

@endif

@endif

@stop