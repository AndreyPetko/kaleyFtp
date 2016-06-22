@extends('site.layout')


@section('content')
@include('elements.breadcrumbs')

<div class="category-content">
	<div class="category-title">
		{{$title}}
	</div>
	<div class="category-title-line"></div>

	<div class="oplata-dostavka-content">
		{!! $textVar !!}
	</div>
</div>
@stop