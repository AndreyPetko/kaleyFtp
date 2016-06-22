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
		Список "С этим товаром также берут" для товара "{{$currentProduct->name}}"
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i>Главная</a></li>
		<li class="active">Таблицы</li>
	</ol>

</section>

<section class="content-header">
	<form method="POST" action="/admin/with-add">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="hidden" name="product_id" value="{{$currentProduct->id}}">
		<div class="row">
			<div class="col-xs-3">
				<select class="select-product form-control" name="with_product_id">
					@foreach($notWithProducts as $notWithProduct)
					<option value="{{$notWithProduct->id}}">{{$notWithProduct->name}}</option>
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
			@if(Session::get('status')) 
			@if(Session::get('status') == 'error')
			<div class="callout callout-danger">
				<h4>Ошибка!</h4>

				<p>Максимальное количество привязанных товаров - 4.</p>
			</div>
			@endif

			@if(Session::get('status') == 'success')
			<div class="callout callout-success">
			<h4>Успех!</h4>

				<p>Товар успешно добавлен в список.</p>
			</div>
			@endif
			@endif
			<div class="box">
				<div class="box-header">
				</div>
				<!-- /.box-header -->
				@if($products)
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
									<form action="/admin/with-delete" method="POST" onsubmit="return confirm('Вы точно хотите удалить этот товар из этого списка?')">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="product_id" value="{{$currentProduct->id}}">
										<input type="hidden" name="with_product_id" value="{{$product->id}}">
										<button type="submit" class="btn btn-block btn-danger btn-flat">Удалить</button>
									</form>
								</td>
							</tr>
							@endforeach
						</table>
					</div>
					<!-- /.box-body -->
				</div>
				@else
				<div class="box-body">
					<table class="table table-bordered table-hover">
						<td>У этого товара список "С этим товаром берут" пуст, выберите необходимый элемент из выпадающего списка</td>
					</table>
				</div>
				@endif
				<!-- /.box -->


			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->

	@stop