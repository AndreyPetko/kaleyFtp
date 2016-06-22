@extends('admin.layouts.admin')


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
		<div class="col-xs-3">
			<a href="/admin/category-add"><button type="button" class="btn btn-block btn-primary btn-flat add-product-button">Добавить</button></a>
		</div>

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
							<th>Удалить</th>
						</tr>
						@foreach($categories as $category)
						<tr>
							<td><a href="/admin/category-edit/{{$category->id}}">{{$category->name}}</a></td>
							<td>
								<form action="/admin/delete-category/{{$category->id}}" method="POST" onsubmit="return confirm('Вы точно хотите удалить категорию: {{$category->name}} ?')">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<button type="submit" class="btn btn-block btn-danger btn-flat">Удалить</button>
								</form>
							</td>
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