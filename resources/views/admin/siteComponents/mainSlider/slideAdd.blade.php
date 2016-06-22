@extends('admin.layouts.admin')




@section('content')


<section class="content-header">
	<h1>
		Добавить слайд
	</h1>
</section>


<!-- Main content -->
<section class="content">
	<div class="row">

		<div class="col-md-12">

			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Форма добавления слайда</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<form method="POST" action="" enctype="multipart/form-data" >

						<input type="hidden" name="_token" value="{{ csrf_token() }}">



						<div class="form-group">
							<label>Позиция слайда</label>
							<input type="number" class="form-control" placeholder="" name="position">
						</div>

						<div class="form-group">
							<label>Текст слайда</label>
							<textarea class="form-control" rows="3" placeholder="" name="text"></textarea>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-12" >
									<label>Изображения слайда</label>
									<input type="file"   name="image">
								</div>
							</div>
						</div>

						<div class="form-group add-button-page">
							<input type="submit" class="btn btn-block btn-primary btn-lg" value="Добавить">
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