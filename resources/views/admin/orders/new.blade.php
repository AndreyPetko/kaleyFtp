@extends('admin.layouts.admin')



@section('js')

<script type="text/javascript">
	jQuery(document).ready(function(){
		var today = new Date();
		$.datetimepicker.setLocale('ru');
		$('#datetimepicker').datetimepicker({
			timepicker:false,
			format:'Y/m/d',
			startDate:  new Date(today.getFullYear(), today.getMonth(), today.getDate()),
			startDate:  new Date(today.getFullYear(), today.getMonth(), today.getDate()),
		});
	});

	$(document).ready(function(){
		$(".select-product").select2();
		$(".select-user").select2();

		$('#add-product').click(function(){
			$('.add-product-hidden-block>div:first').clone().appendTo($('.new-products-block'));
			$('select:last').select2();
		});

	});



</script>

@stop

@section('content')
<section class="content-header">
	<h1>
		Добавить заказ
		<!-- <small>Список товаров</small> -->
	</h1>
</section>


<!-- Main content -->
<section class="content">
	<div class="row">

		<div class="col-md-12">

			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Форма добавления заказа</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<form method="POST" action="" enctype="multipart/form-data">
						<input type="hidden" name="comment" value="0"></input>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<!-- text input -->


						<div class="form-group">
							<label>Выберите пользователя</label>
							<select class="form-control select-user" name="user_id">
								<option value="0">Не выбран</option>
								@foreach($users as $user)
								<option value="{{$user->id}}">{{$user->name}}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label>Введите имя</label>
							<input name="name" class="form-control"></input>
						</div>

						<div class="form-group">
							<label>Введите телефон</label>
							<input name="phone" class="form-control"></input>
						</div>

						<div class="form-group">
							<label>Введите Email</label>
							<input name="email" class="form-control"></input>
						</div>


						<div class="form-group">
							<label>Введите адрес</label>
							<input name="address" class="form-control"></input>
						</div>

						<div class="form-group">
							<label>Выберите дату доставку</label>
							<input id="datetimepicker" name="delivery_dt" class="form-control" type="date"></input>
						</div>

						<div class="form-group">
							<label>Выберите начальное время доставки</label>
							<select name="time_start" class="form-control">
								<option value="10:00">10:00</option>
								<option value="11:00">11:00</option>
								<option value="12:00">12:00</option>
								<option value="13:00">13:00</option>
								<option value="14:00">14:00</option>
								<option value="15:00">15:00</option>
								<option value="16:00">16:00</option>
								<option value="17:00">17:00</option>
								<option value="18:00">18:00</option>
							</select>
						</div>

						<div class="form-group">
							<label>Выберите конечное время доставки</label>
							<select name="time_end" class="form-control">
								<option value="10:00">10:00</option>
								<option value="11:00">11:00</option>
								<option value="12:00">12:00</option>
								<option value="13:00">13:00</option>
								<option value="14:00">14:00</option>
								<option value="15:00">15:00</option>
								<option value="16:00">16:00</option>
								<option value="17:00">17:00</option>
								<option value="18:00">18:00</option>
							</select>
						</div>


						<div class="form-group">
							<label>Выберите тип доставки</label>
							<select name="delivery" id="" class="form-control">
								<option>Не указано</option>
								<option value="sam">Самовывоз</option>
								<option value="kuryer" >Курьер</option>
								<option value="nova poshta" >Новой почтой</option>
								<option value="ukr poshta" >Укрпочтой</option>
							</select>
						</div>

						<div class="form-group">
							<label>Выберите способ оплаты</label>
							<select name="payment" class="form-control">
								<option disabled selected value="">Не указано</option>
								<option value="nal">Наличными курьеру</option>
								<option value="privat">На карту Приват Банка</option>
								<option value="visa">Оплата Visa/Mastercart</option>
							</select>
						</div>


						<h2>Товары</h2>


						<div class="add-product-hidden-block">
							<div>
								<div class="form-group">
									<label>Выберите товар</label>
									<select class="form-control" name="products_ids[]">
										@foreach($products as $product)
										<option value="{{$product->id}}">{{$product->name}}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group">
									<label>Введите количество</label>
									<input class="form-control" name="count[]"></input>
								</div>

								<hr>
							</div>
						</div>


						<div class="add-product-to-order">

							<div class="form-group">
								<label>Выберите товар</label>
								<select class="form-control select-product" name="products_ids[]">
									@foreach($products as $product)
									<option value="{{$product->id}}">{{$product->name}}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group">
								<label>Введите количество</label>
								<input class="form-control" name="count[]"></input>
							</div>

							<hr>
						</div>



						<div class="new-products-block">

						</div>

						<div class="row mt">
							<div class="col-md-3">
								<button type="button" id="add-product" class="btn btn-block btn-primary btn-flat">Добавить товар</button>
							</div>
						</div>






						<div class="form-group add-button-page mt">
							<input type="submit" class="btn btn-block btn-primary btn-lg" value="Создать заказ">
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