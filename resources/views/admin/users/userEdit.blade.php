@extends('admin.layouts.admin')


@section('content')


<section class="content-header">
	<h1>
		Редактирование данных пользователя
	</h1>
</section>


<section class="content">
	<div class="row">

		<div class="col-md-12">

			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Форма добавления товара</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<form method="POST" action="" enctype="multipart/form-data">

						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<!-- text input -->
						<div class="form-group">
							<label>ФИО</label>
							<input type="text" class="form-control"  placeholder="Введите имя пользователя ..." name="name" value="{{$user->name}}">
						</div>

						<div class="form-group">
							<label>Email</label>
							<input type="text" class="form-control"  placeholder="Введите имя пользователя ..." name="email" value="{{$user->email}}">
						</div>

						<div class="form-group">
							<label>Телефон</label>
							<input type="text" class="form-control"  placeholder="Введите имя пользователя ..." name="phone" value="{{$user->phone}}">
						</div>


						<div class="form-group">
							<label>Адрес</label>
							<input type="text" class="form-control"  placeholder="Введите имя пользователя ..." name="address" value="{{$user->address}}">
						</div>


						<div class="form-group">
							<label>Скидка</label>
							<input type="text" class="form-control"  placeholder="Введите имя пользователя ..." name="discount" value="{{$user->discount}}">
						</div>

						<div class="form-group add-button-page">
							<input type="submit" class="btn btn-block btn-primary btn-lg" value="Обновить">
						</div>
					</form>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!--/.col (right) -->
	</div>
	<!-- /.row -->
</section>

@stop