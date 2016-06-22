@extends('dashboard.dashboardLayout')


@section('dashboardContent')
<div class="register-content fl">
 <!-- <div class="account-center-title">
   Покупки
 </div> -->
 <a href='/dashboard/orders-history' class="account-section">
  <img src="{{ url('site/images/icon-order-history.png') }}" > История заказов
</a>
<!-- <a href='/dashboard/orders-status' class="account-section">
 <img src="{{ url('site/images/icon-order-status.png') }}" >Статусы заказов
</a> -->
<!-- <a href='/dashboard/payment-history' class="account-section">
 <img src="{{ url('site/images/icon-payment-history.png') }}" >История платежей
</a> -->
<!-- <div class="account-center-title">
 Товары
</div> -->
<a href='/wishlist' class="account-section">
  <img src="{{ url('site/images/icon-wishlist-copy.png') }}"> Список желаний
</a>
<a href='#' class="account-section">
  <img src="{{ url('site/images/icon-compare-copy.png') }}" > Список сравнений
</a>


@if($sub)
<div class="account-section-mail" >
 <img src="{{ url('site/images/mail-subscribe-on.png') }}" > Подписка на рассылку активна
 <a href='/dashboard/unsubscribe'>Отписаться от рассылки</a>
</div>
@else
<div class="account-section-mail" >
 Подписка на рассылку не активна
 <a href='/dashboard/subscribe'>Подписаться на рассылку</a>
</div>
@endif


</div>

@stop

@section('dashboardMobile')
<div class="register-content-mobil fl">

 <a href='/dashboard/orders-history' class="account-section">
  <img src="{{ url('site/images/icon-order-history.png') }}" > История заказов
</a>
<a href='/dashboard/orders-status' class="account-section">
 <img src="{{ url('site/images/icon-order-status.png') }}" >Статусы заказов
</a>
<a href='/dashboard/payment-history' class="account-section">
 <img src="{{ url('site/images/icon-payment-history.png') }}" >История платежей
</a>
<a href='/wishlist' class="account-section">
  <img src="{{ url('site/images/icon-wishlist-copy.png') }}"> Список желаний
</a>

@if($sub)
<div class="account-section-mail" >
 <img src="{{ url('site/images/mail-subscribe-on.png') }}" > Подписка на рассылку активна
 <a href='#'>Отписаться от рассылки</a>
</div>
@else
<div class="account-section-mail" >
 <img src="{{ url('site/images/mail-subscribe-on.png') }}" > Подписка на рассылку активна
 <a href='#'>Подписаться на рассылку</a>
</div>
@endif


</div>

@stop