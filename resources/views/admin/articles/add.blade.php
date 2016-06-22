@extends('admin.layouts.admin')




@section('content')


<section class="content-header">
	<h1>
		Добавить cтатью
	</h1>
</section>


<!-- Main content -->
<section class="content">
	<div class="row">

		<div class="col-md-12">

			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Форма добавления статьи</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<form method="POST" action="" enctype="multipart/form-data">

						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<!-- text input -->
						<div class="form-group">
							<label>Название статьи</label>
							<input type="text" class="form-control" placeholder="Введите название статьи ..." name="name" id="article_name">
						</div>

						<div class="form-group">
							<label>Описание статьи (meta-description)</label>
							<input type="text" class="form-control" placeholder="Введите описание статьи ..." name="description">
						</div>

						<div class="form-group">
							<label>Вступление</label>
							<input type="text" class="form-control" name="previewText" placeholder="Введите вступление статьи ..." name="description">
						</div>

						<div class="form-group">
							<label>Url статьи</label>
							<input type="text" class="form-control" name="url" id="article_url">
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Изображения статьи</label>
									<input type="file" name="image">
								</div>
							</div>
						</div>

						<div class="form-group" name="description">
							<label>Текст категории</label>
							<textarea name="text">
							</textarea>
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