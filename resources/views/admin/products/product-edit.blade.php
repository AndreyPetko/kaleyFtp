@extends('admin.layouts.admin')




@section('content')

<section class="content-header">
	<h1>
		Изменить товар
	</h1>
</section>


<!-- Main content -->
<section class="content">
	<div class="row">

		<div class="col-md-12">

			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Форма обновления товара</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<form method="POST" action="" enctype="multipart/form-data">
						<input type="hidden" name="redirect_url" value="{{$url}}"></input>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<!-- text input -->
						<div class="form-group">
							<label>Название товара</label>
							<input type="text" class="form-control" id="product_name" placeholder="Введите название товара ..." name="name" value="{{$product->name}}" >
						</div>

						<div class="form-group">
							<label>Введите артикул</label>
							<input type="text" class="form-control" placeholder="Введите артикул ..." name="article" value="{{$product->article}}">
						</div>

						<div class="form-group">
							<label>Выберите бренд</label>
							<div class="row">
								<div class="col-md-6">
									<select name="brend_id" class="form-control">
										<option value="0" disabled selected>Выберите бренд</option>
										@foreach($brends as $brend)
										<option value="{{$brend->id}}" @if($product->brend_id == $brend->id) selected @endif>{{$brend->name}}</option>
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
										<option value="{{$category->id}}" @if($product->category_id == $category->id) selected @endif>{{$category->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="form-group" id="subcats">
							@foreach($subcategories as $subcategory)
							<li><input type="checkbox" name="subcats[]" value="{{$subcategory->id}}" @if(isset($subcategory->active)) @if($subcategory->active) checked @endif @endif>{{$subcategory->name}}</li>
							@endforeach
						</div>
						<div class="form-group" id="attributes">
							@foreach($attributes as $attribute)
							<input type="text" name="attributes[{{$attribute->id}}]" @if(isset($attribute->value)) value="{{$attribute->value}}" @endif placeholder="{{$attribute->name}}" class="form-control">
							@endforeach
						</div>


						<div class="form-group">
							<label>Введите цену товара</label>
							<input type="text" class="form-control" placeholder="Введите цену товара ..." 
							@if(Auth::user()->role == 'admin')
							name="price"
							value="{{$product->price}}"
							@else
							name="wholesale_price"
							value="{{$product->wholesale_price}}"
							@endif
							>
						</div>


						<span class="form-group">
							<label>Введите количество товара</label>
							<input name="quantity" value="{{$product->quantity}}" class="form-control"></input>
						</span>

						<div class="form-group">
							<label>url</label>
							<input type="text" class="form-control" id="product_url" placeholder="url ..." name="url" value="{{$product->url}}">
						</div>

						<!-- textarea -->
						<div class="form-group">
							<label>Описание товара</label>
							<textarea class="form-control" rows="3" placeholder="Введите описание товара ..." name="description">
								@if(empty($product->description))
								<p><strong>Размер</strong>: см</p>

								<p><strong>Ткань</strong>:<strong>&nbsp;</strong>Zweigart Aida</p>

								<p><strong>Нитки</strong>:<strong> </strong>шерсть мулине Anchor</p>

								<p><strong>Схема</strong>:<strong> </strong>цветная знаковая</p>

								<p><strong>Количество цветов</strong>:&nbsp;</p>

								<p><strong>В набор также входит</strong>:&nbsp;игла, подробная инструкция.</p>

								<p>&nbsp;</p>
								@else
								{{$product->description}}
								@endif
							</textarea>
						</div>
						<div class="row">
							@foreach($images as $image)
							<div class="col-md-3 admin-product-images" id="{{$image->id}}">
								<div class="image-delete">X</div>
								<img src="{{url('product_images/' . $image->url)}}">
							</div>
							@endforeach
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
									<input type="checkbox" @if($product->active) checked @endif name="active"></input>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Активность(Опт)</label>
									<input type="checkbox" @if($product->active_wholesale) checked @endif name="active_wholesale"></input>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Не обновлять имя товара из 1С</label>
									<input type="checkbox" @if($product->no1c) checked @endif name="no1c"></input>
								</div>
							</div>
						</div>

						<div class="form-group add-button-page">
							<input type="submit" class="btn btn-block btn-primary btn-lg" value="Обновить">
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
</section>

@stop