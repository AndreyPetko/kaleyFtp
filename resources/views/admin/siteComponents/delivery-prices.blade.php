@extends('admin.layouts.admin')


@section('content')



<section class="content-header">
	<h1>
		Цены на доставку
	</h1>
</section>


<!-- Main content -->
<section class="content">
	<div class="row">

		<div class="col-md-12">

			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Обновить цены на доставку</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<form method="POST" action="" enctype="multipart/form-data">

						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<!-- text input -->
						<div class="form-group">
							<label>Самовывоз</label>
							<input type="text" class="form-control" id="product_name" placeholder="Введите стоимость..." name="sam" value="{{$prices['sam']}}">
						</div>

						<div class="form-group">
							<label>Курьером по Киеву</label>
							<input type="text" class="form-control" name="kuryer" placeholder="Введите стоимость..." id="kuryer" value="{{$prices['kuryer']}}"/>
						</div>


						<div class="form-group">
							<label>Новой почтой</label>
							<input type="text" class="form-control" name="novaposhta" placeholder="Введите стоимость..." id="novaposhta" value="{{$prices['novaposhta']}}"/>
						</div>

						<div class="form-group">
							<label>Новой почтой (наложенный платеж)</label>
							<input type="text" class="form-control" name="novanal" placeholder="Введите стоимость..." id="novanal" value="{{$prices['novanal']}}"/>
						</div>

						<div class="form-group">
							<label>Укр. почтой</label>
							<input type="text" class="form-control" name="ukrposhta" placeholder="Введите стоимость..." id="ukrposhta" value="{{$prices['ukrposhta']}}"/>
						</div>

						<div class="form-group">
							<label>Укр. почтой (наложенный платеж)</label>
							<input type="text" class="form-control" name="ukrnal" placeholder="Введите стоимость..." id="ukrnal" value="{{$prices['ukrnal']}}"/>
						</div>

						<div class="form-group">
							<label>Автолюкс</label>
							<input type="text" class="form-control" name="autolux" placeholder="Введите стоимость..." id="autolux" value="{{$prices['autolux']}}"/>
						</div>

						<div class="form-group add-button-page">
							<input type="submit" class="btn btn-block btn-primary btn-lg" value="Добавить">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>


@stop