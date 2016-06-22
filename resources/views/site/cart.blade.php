@extends('site.layout')

@section('header')
<link rel="stylesheet" type="text/css" href="{{ url('datetimepicker/jquery.datetimepicker.css') }}">
<script type="text/javascript" src="{{ url('datetimepicker/build/jquery.datetimepicker.full.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    var today = new Date();
    $.datetimepicker.setLocale('ru');
    $('#datetimepicker').datetimepicker({
      timepicker:false,
      format:'Y/m/d',
      startDate:  new Date(today.getFullYear(), today.getMonth(), today.getDate()),
    });
  });
</script>
@stop


@section('content')
<input type="hidden" value="{{$deliveryPricesStr}}" id="delStr"></input>
@include('elements.breadcrumbs')

<div class="clear"></div>

<form action="/orders/add" method="POST" id="order-form">

  <input type="hidden" value="{{csrf_token()}}" name="_token">
  <input type="hidden" name="user_id" @if(Auth::check()) value="{{Auth::user()->id}}" @else value="0" @endif>
  <input type="hidden" name="type"  value="0">

  <div class="category-content">
    <div class="category-filter fl">
      <div class="cart-info-header">
        Информация о клиенте
      </div>

      @if(!Auth::check())
      <div class="cart-tologin-group">
        <p>Уже есть аккаунт?</p>
        <div id="cart-to-login">Войти</div></div>
        <div id="login-in-cart">
          <div class="cart-info-input">
            <p>Email*</p>
            <input type="text" name="name">
          </div>
          <div class="cart-info-input">
            <p>Пароль*</p>
            <input type="text" name="name">
          </div>
          <input type="submit" value="Войти" class="to-login-button">
        </div>
        @endif

        <div class="clear"></div>
        <div class="cart-info-content">
          <div class="cart-info-input">
            <p>Имя и Фамилия*</p>
            <input type="text" name="name" @if(Auth::check()) value="{{Auth::user()->name}}" @endif>
          </div>
          <div class="cart-info-input">
            <p>Телефон*</p>
            <input type="text" name="phone" @if(Auth::check()) value="{{Auth::user()->phone}}" @endif >
          </div>
          <div class="cart-info-input">
            <p>Email</p>
            <input type="text" name="email" @if(Auth::check()) value="{{Auth::user()->email}}" @endif>
          </div>
          <div class="cart-info-input">
            <p>Адресс доставки</p>
            <input type="text" name="address" @if(Auth::check()) value="{{Auth::user()->address}}" @endif>
          </div>
          <div class="cart-info-input">
            <p>Дата доставки</p>
            <input type="date" id="datetimepicker" name="delivery_dt">
          </div>
          <div class="cart-info-input">
            <p>Время от</p>
            <select name="time_start">
              <option value="10:00">10:00</option>
              <option value="11:00">11:00</option>
              <option value="12:00">12:00</option>
              <option value="13:00">13:00</option>
              <option value="14:00">14:00</option>
              <option value="15:00">15:00</option>
              <option value="16:00">16:00</option>
              <option value="17:00">17:00</option>
              <option value="18:00">18:00</option>
            </select>
          </div>
          <div class="cart-info-input">
            <p>Время до</p>
            <select name="time_end">
              <option value="10:00">10:00</option>
              <option value="11:00">11:00</option>
              <option value="12:00">12:00</option>
              <option value="13:00">13:00</option>
              <option value="14:00">14:00</option>
              <option value="15:00">15:00</option>
              <option value="16:00">16:00</option>
              <option value="17:00">17:00</option>
              <option value="18:00">18:00</option>
            </select>
          </div>

          <div class="cart-info-input-coment">
            <p>Комментарий к заказу</p>
            <textarea name="comment"></textarea>
          </div>
        </div>

      </div>




      <div class="category-products-content fl">
        <div class="category-title">
          Корзина
        </div>
        <div class="category-title-line">
        </div>
        @if($products)
        <div class="cart-products">
          <p>Товары в корзине</p>
          <div class="cart-products-title">
           <span>Изображение</span>
           <span>Название</span>
           <span>Цена</span>
           <span>Количество</span>
           <span>Сумма</span>
           <span>Удалить</span>

         </div>

         @foreach($products as $product)
         <div class="cart-products-content">
           <div class="cart-product-img">
             <div class="img-block">
                 <a href="{{ url('/product/' . $product->url) }}">
                 @if($product->image)
                   <img src="{{ url('/product_images/' . $product->image) }}">
                 @else
                   <img src="{{ url('/site/images/zaglushka.png') }}">
                 @endif
                 </a>
             </div>
             <div class="cart-magnifier" data-productid="{{$product->id}}">
               <img src="{{ url('/site/images/icon-loop.png') }}">
             </div>
           </div>
           <a href="{{ url('/product/' . $product->url) }}"><p>{{$product->name}}</p></a>
           <div class="cart-product-price">{{$product->price}} грн</div>
           <input type="text" name="product[{{$product->id}}]" value="{{$product->count}}" data-productid="{{$product->id}}" class="count-inputs" data-price="{{$product->price}}">
           <div class="cart-product-price-total">{{$product->price*$product->count}} грн</div>
           <div class="cart-list-item-delete cart-page-delete fl" data-productid="{{$product->id}}" data-totalprice="{{$product->price * $product->count}}"><img src="{{ url('site/images/MergedLayers4.png') }}" alt=""></div>
         </div>
         @endforeach
         @else
         <div class="cart-products">
           <div class="cart-products-content">
             <div class="empty-cart">
               Ваша корзина пуста
             </div>
             @if(Session::get('emptyCartError'))
             <div class="empty-cart-error">
              Вы не можете оформить заказ с пустой корзиной
            </div>
            @endif
          </div>
          @endif

          <div class="big-cart-total">
           <p> Сумма: <span style="color:#eb7f2b" id="total" >@if($total){{$total}} @else 0 @endif грн</span></p>
           @if(Auth::check())
           <p>Скидка: <span style="color:#eb7f2b"  id="discount">{{Auth::user()->discount}}%</span></p>
           @else
           <p>Скидка: <span style="color:#eb7f2b" id="discount">0%</span></p>
           @endif
           <p>Доставка: <span style="color:#eb7f2b" id="delivery">0грн</span></p>
           <p> Итого: <span style="color:#eb7f2b" id="discount-total" >
             @if($total)
             @if(Auth::check())
             {{ $total - Auth::user()->discount * $total/100 }}
             @else
             {{$total}}
             @endif
             @else 
             0 
             @endif 
             грн
           </span></p>
         </div>
       </div>
       <div class="clear"></div>
       <div class="cart-pay-del fl">
        <div class="cart-pay-del fl">
          <div class="cart-pay-del-head">
            Способ доставки
          </div>
          <div class="cart-pay-del-cont">
           <input type="checkbox" name="delivery[]" value="sam"><p>Самовывоз</p>
           @if(!Auth::check() || (Auth::user()->role == 'retail' || Auth::user()->role == 'admin'))
           <input type="checkbox" name="delivery[]" value="kuryer"><p>Курьером по Киеву</p>
           @endif
           <input type="checkbox" name="delivery[]" value="nova poshta"><p>Новой почтой</p>
           @if(!Auth::check() || (Auth::user()->role == 'retail' || Auth::user()->role == 'admin'))
           <input type="checkbox" name="delivery[]" value="ukr poshta"><p>Укрпочтой</p>
           @endif

           @if(Auth::check() && (Auth::user()->role == 'ander' || Auth::user()->role == 'wholesaler'))
            <input type="checkbox" name="delivery[]" value="autolux"><p>Автолюкс</p>
           @endif

         </div>
       </div>

     </div>
     <div class="cart-pay-del fr">
      <div class="cart-pay-del fl">
        <div class="cart-pay-del-head">
          Способ оплаты
        </div>
        <div class="cart-pay-del-cont payment-checboxes">
         <input type="checkbox" name="payment[]" disabled value="nal"><p>Наличными при получении</p>
         <input type="checkbox" name="payment[]" disabled value="privat"><p>На карту Приват Банка</p>
         <input type="checkbox" name="payment[]" disabled value="visa"><p>Оплата Visa/Mastercart</p>
         <input type="checkbox" name="payment[]" disabled value="nalog"><p>Наложенный платеж</p>
       </div>
     </div>

   </div>




 </div>
 <input type="submit" value="Оформить заказ" class="register-button">
</div>
</form>
<div class="clear"></div>
@stop