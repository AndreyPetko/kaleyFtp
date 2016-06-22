@extends('admin.layouts.admin')


@section('content')




<section class="content-header">
	<h1>
		Пользователи
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Tables</a></li>
		<li class="active">Simple</li>
	</ol>
</section>

<div class="content-header">
	<form method="POST" action="">
	<input type="hidden" name="_token" value="{{csrf_token()}}"></input>
		<div class="row">
			<div class="col-md-4">
				<input name="query" class="form-control" placeholder="Поиск"></input>
			</div>
			<div class="col-md-3">
				<button type="submit" class="btn btn-block btn-primary btn-flat add-product-button">Найти</button>
			</div>
		</div>
	</form>
</div>

<section class="content">
	<!-- /.row -->
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Список розничных покупателей сайта</h3>
				</div>

				<!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tbody><tr>
							<th>Имя</th>
							<th>Email</th>
							<th>Телефон</th>
							<th>Адрес</th>
							<th>Скидка</th>
							@if(Auth::user()->email == 'ander@admin.com')
							<th>Сделать оптовиком</th>
							@endif
							<th>Удалить</th>
						</tr>
						@foreach($users as $user)
						<tr>
							<td><a href="/admin/users/single-edit/{{$user->id}}">{{$user->name}}</a></td>
							<td>{{$user->email}}</td>
							<td>{{$user->phone}}</td>
							<td>{{$user->address}}</td>
							<td>{{$user->discount}}</td>
							@if(Auth::user()->role == 'ander')
							<td><a href="/admin/users/make-wholesaler/{{$user->id}}">Сделать оптовиком</a></td>
							@endif
							<td>
								<form action="/admin/users/delete" method="POST" onsubmit="return confirm('Вы точно хотите удалить подкатегорию: {{$user->name}} ?')">
									<input type="hidden" name="userId" value="{{$user->id}}"></input>
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