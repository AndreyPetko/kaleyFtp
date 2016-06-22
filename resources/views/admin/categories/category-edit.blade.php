@extends('admin.layouts.admin')




@section('content')


<section class="content-header">
	<h1>
		Обновить категорию
	</h1>
</section>


<!-- Main content -->
<section class="content">
	<div class="row">

		<div class="col-md-12">

			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Форма обновления категории</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<form method="POST" action="" enctype="multipart/form-data">

						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<!-- text input -->
						<div class="form-group">
							<label>Название категории</label>
							<input type="text" class="form-control" value="{{$category->name}}" placeholder="Введите название товара ..." name="name" id="category_name">
						</div>

						<div class="form-group">
							<label>Выберите атрибуты:</label>
							<br>
							@foreach($attributes as $attribute)
							<div class="my-checkbox">
								<input type="checkbox" @if($attribute->hasAttr) checked @endif name="attributes[]" value="{{$attribute->id}}"> {{$attribute->name}}
							</div>
							@endforeach
						</div>
						<div class="clear"></div>
						<div class="form-group">
							<label>Url категории</label>
							<input type="text" value="{{$category->url}}" class="form-control" name="url" id="category_url">
						</div>

						<div class="form-group" name="description">
							<label>Описание категории</label>
							<textarea name="description">
								{{$category->description}}
							</textarea>
						</div>


						<div class="form-group">
							@if($category->image)
							<div class="article-image">
								<img src="{{ url('category_images/' . $category->image) }}">
							</div>
							@endif
						</div>


						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Логотип категории</label>
									<input type="file" name="image">
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

@stop