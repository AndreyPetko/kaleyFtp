@extends('admin.layouts.admin')



@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Сообщения от пользователей
		<!-- <small>13 new messages</small> -->
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Mailbox</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-3">
			@include('admin.components.feedbackNav')
		</div>
		<!-- /.col -->
		<div class="col-md-9">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Ответить на сообщение пользователя {{$feedback->name}}:</h3>
					<div class="box-tools pull-right">
						<div class="has-feedback">
							<span class="glyphicon glyphicon-search form-control-feedback"></span>
						</div>
					</div>
					<!-- /.box-tools -->
				</div>
				<div class="answer-text">
					{{$feedback->comment}}
				</div>
				<form action="" method="POST">
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