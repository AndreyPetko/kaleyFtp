@extends('admin.layouts.admin')


@section('content')
@extends('admin.layouts.admin')




@section('content')
@extends('admin.layouts.admin')


@section('content')


<section class="content-header">
	<h1>
		Сообщить о поступлении
		<!-- <small>страница списка статей</small> -->
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Tables</a></li>
		<li class="active">Simple</li>
	</ol>
</section>

<section class="content">


	<!-- /.row -->
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<!-- <div class="box-header"> -->
				<!-- <h3 class="box-title">Список элементов меню</h3> -->
				<!-- </div> -->
				<!-- /.box-header -->
				@if($intakes)
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tbody><tr>
							<th>Название продукта</th>
							<td>Количество ожидающих</td>
							<th>Сообщить</th>
							<th>Удалить</th>
						</tr>

						@foreach($intakes as $intake)
						<tr>
							<td><a href="/admin/intake-single/{{$intake->product_id}}">{{$intake->name}}</a></td>
							<td>{{$intake->count}}</td>
							<td>
								<a href="/admin/intake-report/{{$intake->product_id}}">
									<button type="submit" class="btn btn-block btn-primary btn-flat">Сообщить</button>
								</a>
							</td>
							<td>
								<form action="/admin/intake-delete" method="POST" onsubmit="return confirm('Вы точно хотите удалить статью: {{$intake->name}} ?')">
									<input type="hidden" name="id" value="{{$intake->product_id}}">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<button type="submit" class="btn btn-block btn-danger btn-flat">Удалить</button>
								</form>
							</td>
						</tr>
						@endforeach
					</tbody></table>
				</div>
				@else
				<div class="empty">
					Список ожиданий пуст
				</div>
				@endif
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>


@stop
@stop

@stop