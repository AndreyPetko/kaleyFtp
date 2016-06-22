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

<section class="content-header">
	<div class="row">
		<div class="col-xs-3">
			<a href="/admin/brend-add"><button type="button" class="btn btn-block btn-primary btn-flat add-product-button">Добавить</button></a>
		</div>
		<div class="col-xs-3">
			<input type="text" class="form-control product-search-button" id="search" placeholder="Поиск ...">
		</div>
	</div>
</section>

<section class="content">
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
						<tbody>
							<tr>
								<th>Имя</th>
								<th>Картинка</th>
								<th>Это нитки</th>
								<th>Удалить</th>
							</tr>
							@foreach($brends as $brend)
							<tr>
								<td><a href="/admin/update-brend/{{$brend->id}}">{{$brend->name}}</a></td>
								<td class="brend-table-image"><img src="{{ url('brends_images/' . $brend->logo) }}"></td>
								<td>
									@if($brend->thread == 0)
									<a href="/admin/set-brend-thread/{{$brend->id}}/1">Это нитки</a>
									@else
									<a href="/admin/set-brend-thread/{{$brend->id}}/0">Это не нитки</a>
									@endif
								</td>
								<td>
									<form action="/admin/brend-delete" method="POST" onsubmit="return confirm('Вы точно хотите удалить бренд: {{$brend->name}} ?')">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="brend_id" value="{{$brend->id}}">
										<button type="submit" class="btn btn-block btn-danger btn-flat">Удалить</button>
									</form>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>


@stop