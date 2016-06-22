@extends('admin.layouts.admin')




@section('content')


<section class="content-header">
	<h1>
		Обновить текст
	</h1>
</section>


<!-- Main content -->
<section class="content">
	<div class="row">

		<div class="col-md-12">

			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Форма изменения текста</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<form method="POST" action="">

						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<!-- text input -->
						<div class="form-group">
							<label>Alias</label>
							<input type="text" class="form-control" placeholder="Введите alias текста..." name="alias" value="{{$text->alias}}">
						</div>


						<div class="form-group" name="description">
							<label>Текст</label>
							<textarea name="text">
								{{$text->text}}
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