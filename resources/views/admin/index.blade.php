@extends('admin.layouts.admin')


@section('content')
        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Главная
        <small>тут будет общая информация</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">Главная</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-12">
            <a href="/xml">
                <button type="button" class="btn btn-block btn-primary btn-lg">Обновить товары из 1С</button>
            </a>
        </div>
    </div>

    <div class="row mt">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$countNewOrders}}</h3>

              <p>Новые заказы</p>
            </div>
            <div class="icon">
              <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="/admin/orders" class="small-box-footer">
              Подробнее <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->

        @if(Auth::user()->role == 'admin')
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$countNewCallbacks}}</h3>

              <p>Новые обратные звонки</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="/admin/callbacks" class="small-box-footer">
              Подробнее <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        @endif
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$countUsers}}</h3>

              <p>Пользователи</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            @if(Auth::user()->role == 'admin')
            <a href="/admin/users" class="small-box-footer">
            @else
            <a href="/admin/users/wholesalers" class="small-box-footer">
            @endif
              Подробнее <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

      </div>
    </div>

    <!-- Your Page Content Here -->

</section>
<!-- /.content -->

@stop