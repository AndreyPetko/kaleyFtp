@extends('admin.layouts.admin')

@section('js')
<!-- 
  <script type="text/javascript">
    jQuery(document).ready(function(){
      var today = new Date();
      $.datetimepicker.setLocale('ru');
      $('#datetimepicker').datetimepicker({
        mask:'9999/19/39 29:59',
        startDate:  new Date(today.getFullYear(), today.getMonth(), today.getDate()),
      });
    });
</script> -->


<script>
	$(document).ready(function(){
		$(".select-product").select2();
	});
</script>


@stop



@section('content')

<section class="content-header">
	<h1>
		Изменить статус и номер декларации
	</h1>

</section>



<section class="content-header">

	<form method="POST" action="/admin/orders/set-declaration-number">
		<input type="hidden" value="{{csrf_token()}}" name="_token">
		<input type="hidden" value="{{$order->id}}" name="order_id">
		<div class="row mt">
			<div class="col-md-3">
				<input type="text" class="form-control" placeholder="Введите номер декларации" name="number" @if($order->declarationNumber) value="{{$order->declarationNumber}}" @endif>
			</div>
			<div class="col-md-3">
				<button class="btn btn-block btn-primary btn-flat add-product-button">Сохранить номер</button>
			</div>
		</div>
	</form>
</section>

<section class="content-header">
	<form method="POST" action="/admin/orders/add-product-to-order">
		<input type="hidden" value="{{csrf_token()}}" name="_token">
		<input type="hidden" value="{{$order->id}}" name="order_id">
		<div class="row mt">
			<div class="col-md-3">
				<select class="select-product form-control" name="product_id">
					@foreach($allProducts as $allProduct)
					<option value="{{$allProduct->id}}">{{$allProduct->name}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-3">
				<input type="text" class="form-control" placeholder="Введите количество" name="count">
			</div>
			<div class="col-md-3">
				<button class="btn btn-block btn-primary btn-flat add-product-button">Добавить товар</button>
			</div>
		</div>
	</form>
</section>


<section class="content-header">
	<h1>
		Информация о заказе
	</h1>

</section>

<section class="my-content">
	<form action="/admin/orders/edit-item" method="POST">
		<input type="hidden" name="id" value="{{$order->id}}"></input>
		{{ csrf_field() }}
		<div class="box-body table-responsive no-padding info-table">
			<table class="table table-bordered">
				<tbody><tr>
					<th>Поле</th>
					<th>Значение</th>

				</tr>

				<tr>
					<td>№ заказа</td>
					<td>
						{{$order->id}}
					</td>
				</tr>

				<tr>
					<td>Статус</td>
					<td>
						<select class="" name="status">
							<option value="Принят" @if($order->status == 'Принят') selected @endif>Принят</option>
							<option value="Отправлен(Оплачен)" @if($order->status == 'Отправлен(Оплачен)') selected @endif>Отправлен(Оплачен)</option>
							<option value="Отправлен(Ожидает оплаты)" @if($order->status == 'Отправлен(Ожидает оплаты)') selected @endif>Отправлен(Ожидает оплаты)</option>
							<option value="Ожидает" @if($order->status == 'Ожидает') selected @endif>Ожидает</option>
							<option value="Выполнен" @if($order->status == 'Выполнен') selected @endif>Выполнен</option>
						</select>
					</td>
				</tr>



				<tr>
					<td>Дата доставки</td>
					<td>
						<input name="delivery_dt" type="date" value="{{$order->delivery_dt}}"></input> ({{$order->human_dt}})
					</td>
				</tr>

				<tr>
					<td>Время от</td>
					<td><input name="time_start" value="{{$order->time_start}}"></input></td>
				</tr>

				<tr>
					<td>Время до</td>
					<td><input name="time_end" value="{{$order->time_end}}"></input></td>
				</tr>


				<tr>
					<td>Тип доставки</td>
					<td>
						<select name="delivery_type" id="">
							@if($order->fast == 1)
							<option disabled selected value="">Не указано</option>
							@endif
							<option value="sam" @if($order->delivery_type == 'sam') selected @endif>Самовывоз</option>
							<option value="kuryer" @if($order->delivery_type == 'kuryer') selected @endif >Курьер</option>
							<option value="nova poshta" @if($order->delivery_type == 'nova poshta') selected @endif>Новой почтой</option>
							<option value="ukr poshta" @if($order->delivery_type == 'ukr poshta') selected @endif>Укрпочтой</option>
							<option value="autolux" @if($order->delivery_type == 'autolux') selected @endif>Автолюкс</option>
						</select>
					</td>
				</tr>

				<tr>
					<td>Тип оплаты</td>
					<td>
						<select name="payment_type" id="">
							@if($order->fast == 1)
							<option disabled selected value="">Не указано</option>
							@endif
							<option value="nal" @if($order->payment_type == 'nal') selected @endif>Наличными курьеру</option>
							<option value="privat" @if($order->payment_type == 'privat') selected @endif >На карту Приват Банка</option>
							<option value="visa" @if($order->payment_type == 'visa') selected @endif>Оплата Visa/Mastercart</option>
							<option value="visa" @if($order->payment_type == 'nalog') selected @endif>Наложенный платеж</option>
						</select>
					</td>
				</tr>


				<tr>
					<td>Сумма</td>
					<td>{{$order->totalprice}} грн</td>
					<!-- <input type="text" name="totalprice" value=""></input> -->
				</tr>

				<tr>
					<td>Скидка</td>
					<td><input value="{{$order->discount}}" name="discount"></input>%</td>
				</tr>

				<tr>
					<td>Адрес доставки</td>
					<td><input type="text" class="form-control" name="adress" value="{{$order->address}}"></input></td>
				</tr>



			</tbody></table>
		</div>
	</section>


	@if($order->comment)
	<section class="content-header">
		<h1>
			Комментарий к заказу
		</h1>

	</section>


	<section>

		<div class="order-comment">
			{{$order->comment}}
		</div>

	</section>
	@endif


	<section class="content-header">
		<h1>
			Информация о пользователе
		</h1>

	</section>
	<section class="my-content">
		<div class="box-body table-responsive no-padding info-table">
			<table class="table table-bordered">
				<tbody><tr>
					<th>Поле</th>
					<th>Значение</th>

				</tr>


				<tr>
					<td>Имя</td>
					<td><input value="{{$order->fio}}" class="form-control" name="fio"></input></td>
				</tr>

				<tr>
					<td>Телефон</td>
					<td><input value="{{$order->phone}}" class="form-control" name="phone"></input></td>
				</tr>



				<tr>
					<td>Email</td>
					<td><input value="{{$order->email}}" class="form-control" name="email"></input></td>
				</tr>


			</tbody></table>
		</div>
	</section>

	<section class="content-header">
		<h1>
			Товары
		</h1>


	</section>


	<section class="content">


		<div class="box-body table-responsive no-padding info-table">
			<table class="table table-bordered single-order-table">
				<tbody>
					<tr>
						<th>Изображение</th>
						<th>Название</th>
						<th>Артикул</th>
						<th>Количество</th>
						<th>Цена</th>
					</tr>
					@foreach($products as $product)
					<tr>
						<td class="order-product-image">
							@if($product->image)
								<img src="/product_images/{{$product->image}}">
							@else
								<img src="{{ url('/site/images/zaglushka.png') }}">
							@endif
						</td>
						<td>{{$product->product_name}}</td>
						<td>@if(isset($product->article)) {{$product->article}} @else Товар удален @endif</td>
						<td><input value="{{$product->product_count}}" name="count[{{$product->product_id}}]"></input></td>
						<td>{{$product->product_price}}грн</td>
					</tr>
					@endforeach


					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>{{$totalprice}}грн</td>
					</tr>


				</tbody></table>
			</div>

			<div class="row mt">
				<div class="col-md-3">
					<button type="submit" class="btn btn-block btn-primary btn-flat add-product-button">Сохранить изменения</button>
				</div>
				<div class="col-md-3">
					<a href="/admin/orders/print/{{$order->id}}"><div class="btn btn-block btn-primary btn-flat add-product-button">Печать</div></a>
				</div>
			</div>
		</section>

	</form>
	@stop