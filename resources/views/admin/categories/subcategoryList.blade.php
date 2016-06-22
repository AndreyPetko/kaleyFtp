@extends('admin.layouts.admin')


@section('content')


<div class="change-attr subcat-form">
	<div class="close-attr">
		<img src="{{ url('site/images/close-attr.png') }}">
	</div>
	<div class="box-header">
		<h3 class="box-title">Изменить имя атрибута</h3>
	</div>
	<div class="change-attr-form">
		<form action="/admin/change-subcategory">
			<input type="hidden" name="_token" value="{{csrf_token()}}">
			<input type="hidden" name="subcategory_id">
			<div class="form-group">
				<label>Категория</label>
				<select class="form-control" name="category_id">
					@foreach($categories as $category)
						<option value="{{$category->id}}">{{$category->name}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label>Название атрибута</label>
				<input type="text" class="form-control" id="subcat-name" placeholder="Введите новое название атрибута ..." name="name">
			</div>
			<div class="form-group">
				<input type="submit" class="form-control btn-primary" value="Обновить">
			</div>
		</form>
	</div>
</div>

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
		<form action="/admin/add/subcategories" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="url" id="subcategory_url">
			<div class="col-xs-4"><input type="text"  name="name" class="form-control" placeholder="Название" id="subcategory_name"></div>
			<div class="col-xs-4">
				<select class="form-control" name="category_id">
					@foreach($categories as $category)
					<option value="{{$category->id}}">{{$category->name}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-xs-4"><input type="submit" class="form-control" id="submit" value="Добавить"></div>
		</form>
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
							<th>Категория</th>
							<th>Удалить</th>
						</tr>
						@foreach($subcategories as $subcategory)
						<tr>
							<td><a class="change-subcat" data-subcatid="{{$subcategory->id}}">{{$subcategory->name}}</a></td>
							<td>{{$subcategory->catName}}</td>
							<td>
								<form action="/admin/subcategory-delete/{{$subcategory->id}}" method="POST" onsubmit="return confirm('Вы точно хотите удалить подкатегорию: {{$subcategory->name}} ?')">
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