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

	<div class="row">
		<form action="" method="GET">
			<div class="col-xs-4">
				<select class="form-control" name="status">
					<option @if(isset($_GET['status']) && $_GET['status'] == 'Все статусы') selected @endif>Все статусы</option>
					<option @if(isset($_GET['status']) && $_GET['status'] == 'Принят') selected @endif>Принят</option>
					<option @if(isset($_GET['status']) && $_GET['status'] == 'Отправлен(Оплачен)') selected @endif>Отправлен(Оплачен)</option>
					<option @if(isset($_GET['status']) && $_GET['status'] == 'Отправлен(Ожидает оплаты)') selected @endif>Отправлен(Ожидает оплаты)</option>
					<!-- <option @if(isset($_GET['status']) && $_GET['status'] == 'Выполнен') selected @endif>Выполнен</option> -->
				</select>
			</div>
			<div class="col-xs-4">
				<select class="form-control" name="type">
					<option @if(isset($_GET['type']) && $_GET['type'] == '2') selected @endif value="2">Все типы заказов</option>
					<option @if(isset($_GET['type']) && $_GET['type'] == '1') selected @endif value="1">Быстрые</option>
					<option @if(isset($_GET['type']) && $_GET['type'] == '0') selected @endif value="0">Обычные</option>
				</select>
			</div>
			<div class="col-xs-4">
			<input type="submit" class="btn btn-block btn-primary btn-flat add-product-button" value="Применить">
			</div>
		</form>
	</div>
	
	<!-- /.row -->
	<div class="row mt">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Список заказов</h3>


				</div>
				<!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tbody>
							<tr>
								<th>№</th>
								<th>Дата доставки</th>
								<th>Имя</th>
								<th>Телефон</th>
								<th>Сумма</th>
								<th>Статус</th>
								<th>Тип заказа</th>
								<th>Подробнее</th>
								<th>Удалить</th>
							</tr>
							@foreach($orders as $order)
							<tr>
								<td>{{$order->id}}</td>
								<td>{{$order->delivery_dt}}</td>
								<td>{{$order->fio}}</td>
								<td>{{$order->phone}}</td>
								<td>{{$order->totalprice}}грн</td>
								<td>
									@if($order->status == 'Принят')
									<span class="label label-warning">Принят</span>
									@endif
									@if($order->status == 'Отправлен(Оплачен)')
									<span class="label label-primary">Отправлен(Оплачен)</span>
									@endif
									@if($order->status == 'Отправлен(Ожидает оплаты)')
									<span class="label label-primary">Отправлен(Ожидает оплаты)</span>
									@endif
									@if($order->status == 'Ожидает')
									<span class="label label-danger">Ожидает</span>
									@endif
									@if($order->status == 'Выполнен')
									<span class="label label-success">Выполнен</span>
									@endif

								</td>
								<td>
									@if($order->fast)
									Быстрый
									@else
									Обычный
									@endif
								</td>
								<td class="orders-more">
									<a href="/admin/orders/single/{{$order->id}}"><button type="submit" class="btn btn-block  btn-flat">Подробнее</button></a>
								</td>
								<td class="order-delete">
									<form action="/admin/orders/delete" method="POST" onsubmit="return confirm('Вы точно хотите удалить заказ ?')">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" value="{{$order->id}}" name="orderId">
										<button type="submit" class="btn btn-block btn-danger btn-flat">Удалить</button>
									</form>
								</td>
							</tr>
							@endforeach
						</tbody></table>
						<?php echo $orders->render(); ?>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
		</div>
	</section>


	@stop