@extends('admin.layouts.admin')


@section('header')

<script type="text/javascript" src="{{ url('dist/js/add-menu.js')}}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />

@stop


@section('content')

<section class="content-header">
	<h1>
		Simple Tables
		<small>preview of simple tables</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Tables</a></li>
		<li class="active">Simple</li>
	</ol>
</section>

<section class="content">
	<div class="row mb">
		<div class="col-xs-3"><input type="text" class="form-control" placeholder="Название" id="name"></div>
		<div class="col-xs-3"><input type="text" class="form-control" placeholder="Ссылка" id="link"></div>
		<div class="col-xs-3"><input type="text" class="form-control" placeholder="Позиция" id="position"></div>
		<div class="col-xs-3"><input type="submit" class="form-control" id="submit"></div>
	</div>

	<!-- /.row -->
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Список элементов меню</h3>


				</div>
				<!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tbody><tr>
							<th>Имя</th>
							<th>Ссылка</th>
							<th>Позиция</th>
						</tr>
						@foreach($menu as $menuItem)
						<tr>
							<td>{{$menuItem->name}}</td>
							<td>{{$menuItem->link}}</td>
							<td>{{$menuItem->position}}</td>
						</tr>
						@endforeach
					</tbody></table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>

@stop