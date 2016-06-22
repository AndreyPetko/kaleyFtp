@extends('admin.layouts.admin')


@section('js')
<script>
	$(document).ready(function(){
		$(".select-product").select2();
	});
</script>
@stop

@section('content')
<!-- Main content -->
<section class="content-header">
	<h1>
		Рекомендуемые товары
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i>Главная</a></li>
		<li class="active">Таблицы</li>
	</ol>

</section>

<section class="content-header">
	<form method="POST" action="/admin/components/recommended-add">
	<input type="hidden" name="_token" value="{{csrf_token()}}">
		<div class="row">
			<div class="col-xs-3">
				<select class="select-product form-control" name="product_id">
					@foreach($notRecProducts as $noRecProduct)
					<option value="{{$noRecProduct->id}}">{{$noRecProduct->name}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-xs-2">
				<input type="submit" class="form-control" value="Добавить">
			</div>
		</div>
	</form>
</section>



<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Имя</th>
								<th>Удалить</th>
							</tr>
						</thead>
						<tbody>
							@foreach($products as $product)
							<tr>
								<td >
									{{$product->name}}
								</td>
								<td class="recomended-delete">
									<form action="/admin/components/recommended-delete" method="POST" onsubmit="return confirm('Вы точно хотите удалить этот товар из рекомендуемых?')">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="product_id" value="{{$product->id}}">
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