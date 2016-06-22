@extends('admin.layouts.admin')


@section('content')

<section class="content-header">
	<h1>
		Заявки на "сообщить о поступлении" на товар  {{$product->name}}
	</h1>

</section>


<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<h2>Список ожидающих</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="box-body table-responsive no-padding info-table">
				<table class="table table-bordered">
					<tbody>
						<tr>
							<th>Имя</th>
							<th>Email</th>
							<th>Удалить</th>
						</tr>
						@foreach($intake as $intakeItem)
						<tr>
							<td>{{$intakeItem->name}}</td>
							<td>{{$intakeItem->email}}</td>
							<td><a href="/admin/intake-email-delete/{{$intakeItem->id}}">Удалить</a></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>


</section>

@stop