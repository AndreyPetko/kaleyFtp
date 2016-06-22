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
          <h3 class="box-title">Комментарии</h3>

          <div class="box-tools pull-right">
            <div class="has-feedback">
              <!-- <input type="text" class="form-control input-sm" placeholder="Search Mail"> -->
              <span class="glyphicon glyphicon-search form-control-feedback"></span>
            </div>
          </div>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <div class="mailbox-controls">
            <!-- Check all button -->
          <!--   <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
            </button>
            <div class="btn-group">
              <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
              <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
              <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
            </div> -->
            <!-- /.btn-group -->
            <button type="button" class="btn btn-default btn-sm refresh"><i class="fa fa-refresh"></i></button>
            <div class="pull-right">
              {{$paginateInfo['first']}}-{{$paginateInfo['last']}}/{{$paginateInfo['total']}}
              <div class="btn-group">
                <a href="{{$paginateInfo['prev']}}"><button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button></a>
                <a href="{{$paginateInfo['next']}}"><button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button></a>
              </div>
              <!-- /.btn-group -->
            </div>
            <!-- /.pull-right -->
          </div>
          <div class="table-responsive mailbox-messages">
            <table class="table table-hover table-striped">
              <tbody>
                <tr>
                  <th class="mailbox-name">Имя</th>
                  <th class="mailbox-subject">Комментарий</th>
                  <th class="mailbox-attachment">Товар</th>
                  <th class="mailbox-subject">Дата</th>
                  <th>Удалить</th>
                  <th>Ответить</th>
                </tr>
                @foreach($reviews as $review)
                <tr @if($review->readed == 0)class="not-readed" @endif>
                  <td class="mailbox-name">{{$review->name}}</td>
                  <td class="mailbox-subject">{!!$review->text!!}</td>
                  <td class="mailbox-attachment"><a href="../product/{{$review->productUrl}}">{{$review->productName}}</a></td>
                  <td class="mailbox-date">{{$review->date}}</td>
                  <td>
                    <form action="/admin/reviews/review-delete" method="POST" onsubmit="return confirm('Вы точно хотите удалить комментарий: {{$review->name}} ?')">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="review_id" value="{{$review->id}}">
                      <button type="submit" class="btn btn-block btn-danger btn-flat">Удалить</button>
                    </form>
                  </td>
                  <td>
                  <a href="/admin/comment-answer/{{$review->id}}">
                      <button type="button" class="btn btn-block btn-warning btn-flat">Ответить</button>
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <!-- /.table -->
          </div>
          <!-- /.mail-box-messages -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer no-padding">
          <div class="mailbox-controls">
            <!-- Check all button -->
           <!--  <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
            </button>
            <div class="btn-group">
              <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
              <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
              <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
            </div> -->
            <!-- /.btn-group -->
            <button type="button" class="btn btn-default btn-sm refresh"><i class="fa fa-refresh"></i></button>
            <div class="pull-right">
              {{$paginateInfo['first']}}-{{$paginateInfo['last']}}/{{$paginateInfo['total']}}
              <div class="btn-group">
                <a href="{{$paginateInfo['prev']}}"><button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button></a>
                <a href="{{$paginateInfo['next']}}"><button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button></a>
              </div>
              <!-- /.btn-group -->
            </div>
            <!-- /.pull-right -->
          </div>
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