@extends('admin.layouts.admin')


@section('content')
<!-- Main content -->
<section class="content-header">
	<h1>
		Элементы слайдера на главной странице
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active">Таблицы</li>
	</ol>

</section>

<section class="content-header">
	<div class="row">
		<div class="col-xs-3">
			<a href="/admin/components/slide-add/main"><button type="button" class="btn btn-block btn-primary btn-flat add-product-button">Добавить</button></a>
		</div>
	</div>
</section>



<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table id="slides-table" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Изображение</th>
								<th>Текст</th>
								<th>Позиция</th>
								<th>Удалить</th>
							</tr>
						</thead>
						<tbody>
							@foreach($slides as $slide)
							<tr>
								<td class="slides-images">
									<a href="/admin/components/slide-edit/{{$slide->id}}">
										<img src="{{ url('slides_images/' . $slide->image)}}">
									</a>
								</td>
								<td>{!!$slide->text!!}</td>
								<td>{{$slide->position}}</td>
								<td>
									<form action="/admin/components/slide-delete" method="POST" onsubmit="return confirm('Вы точно хотите удалить этот слайд ?')">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="slide_id" value="{{$slide->id}}">
										<button type="submit" class="btn btn-block btn-danger btn-flat">Удалить</button>
									</form>
								</td>
							</tr>
							@endforeach
						</table>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->


			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->

	@stop