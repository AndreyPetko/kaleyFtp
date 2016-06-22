@extends('admin.layouts.admin')




@section('content')


<section class="content-header">
	<h1>
		Добавить товар
		<!-- <small>Список товаров</small> -->
	</h1>
</section>


<!-- Main content -->
<section class="content">
	<div class="row">

		<div class="col-md-12">

			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Форма добавления товара</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<form method="POST" action="" enctype="multipart/form-data" id="add-product-form">

						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<!-- text input -->
						<div class="form-group">
							<label>Название товара</label>
							<input type="text" class="form-control" id="product_name" placeholder="Введите название товара ..." name="name">
						</div>

						<div class="form-group">
							<label>Введите артикул</label>
							<input type="text" class="form-control" placeholder="Введите артикул ..." name="article">
						</div>

						<div class="form-group">
							<label>Выберите бренд</label>
							<div class="row">
								<div class="col-md-6">
									<select name="brend_id" class="form-control">
										<option value="0" disabled selected>Выберите категорию</option>
										@foreach($brends as $brend)
										<option value="{{$brend->id}}">{{$brend->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label>Выберите категорию</label>
							<div class="row">
								<div class="col-md-6">
									<select name="category_id" class="form-control" id="changeCategory">
										<option value="0" disabled selected>Выберите категорию</option>
										@foreach($categories as $category)
										<option value="{{$category->id}}">{{$category->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							
						</div>

						<div class="form-group" id="subcats"></div>
						<div class="form-group" id="attributes"></div>



						@if(Auth::user()->role == 'admin')
						<div class="form-group">
							<label>Введите цену товара</label>
							<input type="number" class="form-control" id="product_price" placeholder="Введите цену товара ..." name="price">
						</div>
						@else
						<div class="form-group">
							<label>Введите цену товара</label>
							<input type="number" class="form-control" id="product_price" placeholder="Введите цену товара ..." name="wholesale_price">
						</div>
						@endif

						<span class="form-group">
							<label>Введите количество товара</label>
							<input name="quantity" placeholder="Введите количество товара" value="999" class="form-control"></input>
						</span>

						<div class="form-group">
							<label>url</label>
							<input type="text" class="form-control" id="product_url" placeholder="url ..." name="url">
						</div>

						<!-- textarea -->
						<div class="form-group">
							<label>Описание товара</label>
							<textarea class="form-control" rows="3" placeholder="Введите описание товара ..." name="description"></textarea>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-12" id="images-inputs-list">
										<label>Изображения товара</label>
										<input type="file"   name="images[]">
									</div>
								</div>
								<div class="row mt">
									<div class="col-md-3">
										<button type="button" id="add-image" class="btn btn-block btn-primary btn-flat">Добавить изображение</button>
									</div>
								</div>
							</div>


							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Активность(Розница)</label>
										<input type="checkbox" name="active"></input>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Активность(Опт)</label>
										<input type="checkbox" name="active_wholesale"></input>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Не обновлять имя товара из 1С</label>
										<input type="checkbox" name="no1c" checked="checked"></input>
									</div>
								</div>
							</div>


							<div class="form-group add-button-page">
								<input type="submit" class="btn btn-block btn-primary btn-lg" value="Добавить">
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