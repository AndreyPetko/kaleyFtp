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
							<th>Товар</th>
							<th>Количество</th>
							<th>Сумма</th>
							<th>Статус</th>
							<th>Удалить</th>
						</tr>
						@foreach($fastOrders as $fastOrder)
						<tr>
							<td>{{$fastOrder->orderId}}</td>
							<td>{{$fastOrder->fio}}</td>
							<td>{{$fastOrder->phone}}</td>
							<td>{{$fastOrder->product_name}}</td>
							<td>{{$fastOrder->product_count}}</td>
							<td>{{$fastOrder->totalprice}} ({{$fastOrder->product_price}} * {{$fastOrder->product_count}})</td>
							<td>
							@if($fastOrder->status == 'Принят')
								<span class="label label-warning">Принят</span>
								@endif
								@if($fastOrder->status == 'Отправлен(Оплачен)')
								<span class="label label-primary">Отправлен(Оплачен)</span>
								@endif
								@if($fastOrder->status == 'Отправлен(Ожидает оплаты)')
								<span class="label label-primary">Отправлен(Ожидает оплаты)</span>
								@endif
								@if($fastOrder->status == 'Ожидает')
								<span class="label label-danger">Ожидает</span>
								@endif
								@if($fastOrder->status == 'Выполнен')
								<span class="label label-success">Выполнен</span>
								@endif
							</td>
							<td class="orders-more">
								<a href="/admin/orders/single/{{$fastOrder->orderId}}"><button type="submit" class="btn btn-block  btn-flat">Подробнее</button></a>
							</td>
							<td>
								<form action="/admin/orders/delete" method="POST" onsubmit="return confirm('Вы точно хотите удалить заказ ?')">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" value="{{$fastOrder->orderId}}" name="orderId">
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