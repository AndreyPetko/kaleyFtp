@extends('admin.layouts.admin')

@section('content')

<section class="content-header">
	<h1>
		Контакты
	</h1>

</section>


<section class="content">

	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Форма обновления контактов</h3>
				</div>
				<div class="box-body">
					<form action="" method="POST">
					{{csrf_field()}}
						<div class="form-group">
							<label>Номер телефона 1</label>
							<input type="text" class="form-control" name="phone1" value="{{$contacts['phone1']}}">
						</div>
						<div class="form-group">
							<label>Номер телефона 2</label>
							<input type="text" class="form-control" name="phone2" value="{{$contacts['phone2']}}">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="text" class="form-control" name="email" value="{{$contacts['email']}}">
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
								<input type="submit" class="btn btn-block btn-primary btn-lg" value="Обновить">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</section>


@stop