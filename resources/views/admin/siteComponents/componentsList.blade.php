@extends('admin.layouts.admin')


@section('content')
<!-- Main content -->
<section class="content-header">
	<h1>
		Компоненты
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active">Таблицы</li>
	</ol>

</section>



<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Hover Data Table</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table id="example2" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Имя</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><a href="/admin/components/main-slider">Слайдер на главной странице</a></td>
							</tr>
							<tr>
								<td><a href="/admin/components/recommended-list">Рекомендуемые товары</a></td>
							</tr>
							<tr>
								<td><a href="/admin/texts">Тексты</a></td>
							</tr>
							@if(Auth::user()->role == 'ander')
							<tr>
								<td><a href="/admin/components/files">Файлы для оптовиков</a></td>
							</tr>
							@endif

							<tr>
								<td><a href="/admin/components/contacts-retails">Контакты розница</a></td>
							</tr>
							<tr>
								<td><a href="/admin/components/contacts-wholesales">Контакты оптовики</a></td>
							</tr>
							<tr>
								<td><a href="/admin/components/delivery-prices">Цены на доставку</a></td>
							</tr>

						</table>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->


			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->

	@stop