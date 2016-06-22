@extends('admin.layouts.admin')


@section('content')


<section class="content-header">
	<h1>
		Simple Tables
		<small>preview of simple tables</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Tables</a></li>
		<li class="active">Simple</li>
	</ol>
</section>

<section class="content">
	@include('admin.components.ordersNav')
	<!-- /.row -->
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Список заказов</h3>


				</div>
				<!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tbody><tr>
							<th>№</th>
							<th>Имя</th>
							<th>Телефон</th>
							<th>Сумма</th>
							<th>Статус</th>
							<th>Подробнее</th>
							<th>Удалить</th>
						</tr>
						@foreach($orders as $order)
						<tr>
							<td>{{$order->id}}</td>
							<td>{{$order->fio}}</td>
							<td>{{$order->phone}}</td>
							<td>{{$order->totalprice}} грн</td>
							<td><span class="label label-success">Выполнен</span></td>
							<td class="orders-more">
								<a href="/admin/orders/single/{{$order->id}}"><button type="submit" class="btn btn-block  btn-flat">Подробнее</button></a>
							</td>
							<td>
								<form action="/admin/orders/delete" method="POST" onsubmit="return confirm('Вы точно хотите удалить заказ ?')">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" value="{{$order->id}}" name="orderId">
									<button type="submit" class="btn btn-block btn-danger btn-flat">Удалить</button>
								</form>
							</td>
						</tr>
						@endforeach
					</tbody></table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>


@stop