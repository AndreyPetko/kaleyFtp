@extends('admin.layouts.admin')


@section('content')

<div class="change-attr">
	<div class="close-attr">
		<img src="{{ url('site/images/close-attr.png') }}">
	</div>
	<div class="box-header">
		<h3 class="box-title">Изменить имя атрибута</h3>
	</div>
	<div class="change-attr-form">
		<form action="/admin/change-attribute">
			<input type="hidden" name="_token" value="{{csrf_token()}}">
			<input type="hidden" name="attribute_id">
			<div class="form-group">
				<label>Название атрибута</label>
				<input type="text" class="form-control" id="attr_name" placeholder="Введите новое название атрибута ..." name="name">
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
		<form action="/admin/add/attributes" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="col-xs-6"><input type="text"  name="name" class="form-control" placeholder="Название" id="name"></div>
			<div class="col-xs-3"><input type="submit" class="form-control btn-primary" id="submit" value="Добавить"></div>
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
							<th>Удалить</th>
						</tr>
						@foreach($attributes as $attribute)
						<tr>
							<td><a class="show-attribute-name" data-attrid="{{$attribute->id}}">{{$attribute->name}}</a></td>
							<td>
								<form action="/admin/delete-attr/{{$attribute->id}}" method="POST" onsubmit="return confirm('Вы точно хотите удалить атрибут: {{$attribute->name}} ?')">
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