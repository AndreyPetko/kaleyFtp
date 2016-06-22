@extends('dashboard.dashboardLayout')

@section('dashboardContent')

    <div class="register-content fl">
        
       <div class="account-center-title">
           Статусы заказов
       </div>
         @foreach($orders as $order)
         <div class="account-order-item-status">
             <div class="account-oder-item-txt fl">№ заказа: {{$order->id}}</div>
             <div class="account-oder-item-txt fl">Дата: {{$order->delivery_dt}}</div>
             <div class="account-oder-item-txt account-oder-item-txt-2  fl">Статус: {{$order->status}}</div>
         </div>
          <div class="account-order-item-contain-status">
            <div class="account-order-item-contain-txt fl"> 
            Способ доставки: {{$order->delivery_type}}<br></div>
            <div class="account-order-item-contain-txt fl">Способ оплаты: {{$order->payment_type}}<br></div>
            <div class="account-order-item-contain-txt fl">Сумма: {{$order->totalprice}} грн  </div>
           <div class="account-order-item-contain-txt fl"> Скидка: {{$order->discount}}%</div>

           @if($order->declarationNumber)
            <div class="account-order-item-contain-txt fl">№ декларации: {{$order->declarationNumber}}</div>
            <div class="account-order-item-contain-txt fl"><a href="https://novaposhta.ua/tracking/?cargo_number={{$order->declarationNumber}}" target="_blank"> Отследить посылку</a></div>
            @endif
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
             <div class="account-oder-item-txt fl">№ {{$order->id}} </div>
             <div class="account-oder-item-txt account-oder-item-txt-2-mob  fl">Статус: {{$order->status}}</div>
         </div>
          <div class="account-order-item-contain-status">
            <div class="account-order-item-contain-txt-mob fl"> 
            Способ доставки: {{$order->delivery_type}}<br></div>
            <div class="account-order-item-contain-txt-mob fl">Дата: {{$order->delivery_dt}}<br></div>
            <div class="account-order-item-contain-txt-mob fl">Способ оплаты: {{$order->payment_type}}<br></div>
            <div class="account-order-item-contain-txt-mob fl">Сумма: {{$order->totalprice}} грн  </div>
           <div class="account-order-item-contain-txt-mob fl"> Скидка: {{$order->discount}}%</div>

           @if($order->declarationNumber)
            <div class="account-order-item-contain-txt-mob fl">№ декларации: {{$order->declarationNumber}}</div>
            <div class="account-order-item-contain-txt-mob fl"><a href="https://novaposhta.ua/tracking/?cargo_number={{$order->declarationNumber}}" target="_blank"> Отследить посылку</a></div>
            @endif
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
                
                this.nextSibling.nextSibling.style.height = "160px";
                this.style.cssText = "border-color:#616161";
                
            })
        }
    </script>
@stop