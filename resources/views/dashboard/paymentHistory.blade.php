
@extends('dashboard.dashboardLayout')




@section('dashboardContent')

    <div class="register-content fl">
        
       <div class="account-center-title">
           Статусы заказов
       </div>

        @foreach($orders as $order)
         <div class="account-order-item-status">
             <div class="account-oder-item-txt fl">№ заказа: {{$order->id}}</div>
             <div class="account-oder-item-txt fl">Оплата:{{$order->payment}}</div>
             <div class="account-oder-item-txt account-oder-item-txt-2 fl">Дата оплаты: {{$order->payment_dt}}</div>
         </div>
          <div class="account-order-item-contain-status">
            <div class="account-order-item-contain-txt fl">Способ оплаты: {{$order->payment_type}}<br></div>
          <div class="account-order-item-contain-txt fl"> Дата заказа: {{$order->delivery_dt}}</div>
           <div class="account-order-item-contain-txt fl">Сумма: {{$order->totalprice}} грн </div>
            <div class="account-order-item-contain-txt fl">Статус заказа: {{$order->status}} </div>
             <div class="account-order-item-contain-txt fl">Скидка:{{$order->discount}}%</div>
         </div>
         @endforeach
    </div>
    <script>
        var accountOrder = document.getElementsByClassName("account-order-item-status");
         var accountOrderInfo = document.getElementsByClassName("account-order-item-contain-status");
        function clear(){
            for(i=0; i < accountOrderInfo.length; i++){
                accountOrderInfo[i].style.height ="0";
            };
            for(i=0; i < accountOrder.length; i++){
                accountOrder[i].style.cssText = "border-color:#e8e8e8";
            }
            
        }
        for(i=0; i < accountOrder.length; i++){
             
            accountOrder[i].addEventListener("click", function(){
                clear();
                
                this.nextSibling.nextSibling.style.height = "100px";
                this.style.cssText = "border-color:#616161";
                
            })
        }
    
    </script>

@stop


@section('dashboardMobile')
<a href='/dashboard' class="account-section-mobile">
  Назад в личный кабинет
</a>

<div class="account-center-title" style="text-align:center">
          Статус заказов
       </div>
@foreach($orders as $order)
         <div class="account-order-item-status">
             <div class="account-oder-item-txt fl">№ заказа: {{$order->id}}</div>
             <div class="account-oder-item-txt account-oder-item-txt-2 fl">Оплата:{{$order->payment}}</div>
           
         </div>
          <div class="account-order-item-contain-status">
            <div class="account-order-item-contain-txt-mob fl">Способ оплаты: {{$order->payment_type}}<br></div>
          <div class="account-order-item-contain-txt-mob fl"> Дата заказа: {{$order->delivery_dt}}</div>
          <div class="account-order-item-contain-txt-mob fl"> Дата оплаты: {{$order->payment_dt}}</div>
           <div class="account-order-item-contain-txt-mob  fl">Сумма: {{$order->totalprice}} грн </div>
            <div class="account-order-item-contain-txt-mob  fl">Статус заказа: {{$order->status}} </div>
             <div class="account-order-item-contain-txt-mob  fl">Скидка:{{$order->discount}}%</div>
         </div>
         @endforeach

          <script>
        var accountOrder = document.getElementsByClassName("account-order-item-status");
         var accountOrderInfo = document.getElementsByClassName("account-order-item-contain-status");
        function clear(){
            for(i=0; i < accountOrderInfo.length; i++){
                accountOrderInfo[i].style.height ="0";
            };
            for(i=0; i < accountOrder.length; i++){
                accountOrder[i].style.cssText = "border-color:#e8e8e8";
            }
            
        }
        for(i=0; i < accountOrder.length; i++){
             
            accountOrder[i].addEventListener("click", function(){
                clear();
                
                this.nextSibling.nextSibling.style.height = "140px";
                this.style.cssText = "border-color:#616161";
                
            })
        }
    
    </script>
@stop