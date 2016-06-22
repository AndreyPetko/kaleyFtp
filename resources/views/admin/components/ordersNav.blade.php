@if(Auth::user()->role == 'admin')
<div class="row mb">
	<div class="col-xs-12">
		<a href="/admin/orders/new-order"><button type="button" class="btn btn-block btn-primary btn-flat add-product-button">Создать заказ</button></a>
	</div>
</div>
@endif
	<div class="row mb">
		@if(Auth::user()->role == 'admin')
		<div class="col-xs-4">
			<a href="/admin/orders"><button type="button" class="btn btn-block btn-primary btn-flat add-product-button">Все  заказы</button></a>
		</div>
		<div class="col-xs-4">
			<a href="/admin/orders/fast"><button type="button" class="btn btn-block btn-primary btn-flat add-product-button">Быстрые заказы</button></a>
		</div>
		<div class="col-xs-4">
			<a href="/admin/orders/archive"><button type="button" class="btn btn-block btn-primary btn-flat add-product-button">Архив</button></a>
		</div>
		@else
		<div class="col-xs-6">
			<a href="/admin/orders"><button type="button" class="btn btn-block btn-primary btn-flat add-product-button">Все  заказы</button></a>
		</div>

		<div class="col-xs-6">
			<a href="/admin/orders/archive"><button type="button" class="btn btn-block btn-primary btn-flat add-product-button">Архив</button></a>
		</div>
		@endif
	</div>