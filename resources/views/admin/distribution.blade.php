@extends('admin.layouts.admin')



@section('content')


<!-- Main content -->
<section class="content">
	<div class="row">

		<!-- /.col -->
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Сделать рассылку по подписчикам:</h3>
					<div class="box-tools pull-right">
						<div class="has-feedback">
							<span class="glyphicon glyphicon-search form-control-feedback"></span>
						</div>
					</div>
					<!-- /.box-tools -->
				</div>
				<div class="answer-text">
				</div>
				@if(Auth::user()->role == 'admin')
				<form action="" method="POST">
				@else
				<form action="/admin/wholesaler-distribution" method="POST">
				@endif
				{!! csrf_field() !!}
					<div class="answer-textarea">
						<textarea name="message">

						</textarea>
					</div>
					<div class="answer-submit mt mb">
						<div class="row">
							<div class="col-xs-4">
								<input type="submit" class="btn btn-block btn-primary btn-flat"></input>
							</div>
						</div>
					</div>
				</form>
			</div>



		</div>
		<!-- /. box -->
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
@stop