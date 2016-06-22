@extends('admin.layouts.admin')




@section('content')


<section class="content-header">
	<h1>
		Добавить бренд
	</h1>
</section>


<!-- Main content -->
<section class="content">
	<div class="row">

		<div class="col-md-12">

			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Форма добавления бренда</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<form method="POST" action="" enctype="multipart/form-data" >

						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label>Название бренда</label>
							<input type="text" class="form-control" id="name" name="name" placeholder="Введите название бренда...">
						</div>

						<div class="form-group">
							<label>Url</label>
							<input type="text" class="form-control" id="url" name="url" placeholder="Введите url бренда...">
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-12" >
									<label>Логотип бренда</label>
									<input type="file"   name="logo">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Короткое описание</label>
									<textarea name="preview"></textarea>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Полное описание</label>
									<textarea name="description"></textarea>
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