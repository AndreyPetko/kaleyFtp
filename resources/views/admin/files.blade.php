@extends('admin.layouts.admin')



@section('content')

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<h1>Файлы</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-body">
					@if(count($files))
					<table id="example2" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Имя файла</th>
								<th>Удалить</th>
							</tr>
						</thead>
						@foreach($files as $file)
						<tr>
							<td>{{$file->name}}</td>
							<td><a href="/admin/components/file-delete/{{$file->id}}">Удалить</a></td>
						</tr>
						@endforeach
					</table>
					@else
					<div class="empty">Список файлов пуст</div>
					@endif

				</div>
			</div>
		</div>
	</div>


	<div class="row">
		<div class="col-md-12">
			<h2>Добавить файл</h2>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="box-body">
				<form method="POST" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<!-- text input -->
					<div class="form-group">
						<label>Название товара</label>
						<input type="file" class="form-control" name="file">
					</div>

					<div class="form-group">
						<input type="submit" class="form-control"></input>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

@stop