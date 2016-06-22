@extends('dashboard.dashboardLayout')




@section('dashboardContent')


<div class="register-content fl">

   <div class="account-center-title">
       История заказов
   </div>
   @if($orders)
   @foreach($orders as $order)
   <div class="account-order-item">
     <div class="account-oder-item-txt fl">№ заказа: {{$order->id}}</div>
     <div class="account-oder-item-txt fl">Дата: {{$order->delivery_dt}}</div>
     <div class="account-oder-item-txt fl">Статус: {{$order->status}}</div>
 </div>
 <div class="account-order-item-contain">


    <div class="orders-info-block">
    <hr>
        <div class="account-order-item-contain-txt fl"> 
            Способ доставки: {{$order->delivery_type}}<br></div>
            <div class="account-order-item-contain-txt fl">Способ оплаты: {{$order->payment_type}}<br></div>
            <hr>
            <div class="account-order-item-contain-txt fl">Сумма: {{$order->totalprice}} грн  </div>
            <div class="account-order-item-contain-txt fl"> Скидка: {{$order->discount}}%</div>

            @if($order->declarationNumber && ($order->delivery_type == 'Новая почта' || $order->delivery_type == 'Укрпочтой'))
            <hr>
            <div class="account-order-item-contain-txt fl">№ декларации: {{$order->declarationNumber}}</div>
            <div class="account-order-item-contain-txt fl"><a href="{{$order->delivery_link}}" target="_blank"> Отследить посылку</a></div>
            @endif

            <hr>
        </div>


        <div class="account-order-history-content-title">
            <div class="account-order-history-img fl">Изображение</div>
            <div class="account-order-history-name fl">Наименование</div>
            <div class="account-order-history-txt fl">Цена</div>
            <div class="account-order-history-txt fl">Количество</div>
            <div class="account-order-history-txt fl">Сумма</div>
        </div>
        @foreach($order->products as $key => $product)
        <div class="account-order-history-content-txt">
            <a href="/product/{{$product->url}}">
                <div class="account-order-history-img his-img fl">
                    @if($product->image)
                    <img src="{{  url('product_images/' . $product->image) }}">
                    @else
                    <img src="{{  url('site/images/main-product.png') }}">
                    @endif
                </div>
                <div class="account-order-history-name fl">{{$product->product_name}}</div>
                <div class="account-order-history-txt fl">{{$product->product_price}} грн</div>
                <div class="account-order-history-txt fl">{{$product->product_count}}</div>
                <div class="account-order-history-txt fl">{{$product->product_price * $product->product_count}} грн</div>
            </a>

            @if($product != end($order->products) )
            <div class="hr"></div>
            @endif
        </div>
        @endforeach

    </div>
    @endforeach

    <!-- Если нету заказов -->
    @else
    <div class="empty-cart">Список заказов пуст</div>
    @endif

</div>
<script>
    var accountOrder = document.getElementsByClassName("account-order-item");
    var accountOrderInfo = document.getElementsByClassName("account-order-item-contain");
    var allNextSub1 = document.getElementsByClassName('account-order-history-content-txt');
    var allNextSub2 = document.getElementsByClassName('account-order-history-content-title');
    var ordersInfo = document.getElementsByClassName('orders-info-block');

    function clear(){

        for(i=0; i < allNextSub1.length; i++){
            allNextSub1[i].style.height = "0";
        };
        for(i=0; i < allNextSub2.length; i++){
            allNextSub2[i].style.height = "0";
        };
        for(i=0; i < accountOrder.length; i++){
            accountOrder[i].style.cssText = "border-color:#e8e8e8";
        }

        for (var i = ordersInfo.length - 1; i >= 0; i--) {
            ordersInfo[i].style.height = "0";
        }

    }

    for(i=0; i < accountOrder.length; i++){

        accountOrder[i].addEventListener("click", function(){
            clear();
            var actualNextSub = this.nextSibling.nextSibling.childNodes;



            for(i=0; i < actualNextSub.length; i++ ){
                if(actualNextSub[i].className == "account-order-history-content-txt"){
                    actualNextSub[i].style.height = "72px";
                }
                if(actualNextSub[i].className == "account-order-history-content-title"){
                    actualNextSub[i].style.height = "40px";
                }

                if(actualNextSub[i].className == "orders-info-block"){
                    actualNextSub[i].style.height = "120px";
                }
            }
            this.style.cssText = "border-color:#616161"

        })
    }
    
</script>


@stop


@section('dashboardMobile')


<a href='/dashboard' class="account-section-mobile">
  Назад в личный кабинет
</a>

<div class="account-center-title" style="text-align:center">
 История заказов
</div>
@foreach($orders as $order)
<div class="account-order-item">
 <div class="account-oder-item-txt-mobile fl">№ заказа: {{$order->id}}</div>
 <!--  <div class="account-oder-item-txt fl">Дата: {{$order->delivery_dt}}</div> -->
 <div class="account-oder-item-txt-mobile fl">Сумма: {{$order->totalprice}} грн</div>
</div>



<div class="account-order-item-contain">
    <div class="orders-info-block">
        <div class="account-order-item-contain-txt-mob fl"> 
            Способ доставки: {{$order->delivery_type}}<br></div>
            <div class="account-order-item-contain-txt-mob fl">Способ оплаты: {{$order->payment_type}}<br></div>
            <div class="account-order-item-contain-txt-mob fl">Сумма: {{$order->totalprice}} грн  </div>
            <div class="account-order-item-contain-txt-mob fl"> Скидка: {{$order->discount}}%</div>

            @if($order->declarationNumber && ($order->delivery_type == 'Новая почта' || $order->delivery_type == 'Укрпочтой'))
            <div class="account-order-item-contain-txt-mob fl">№ декларации: {{$order->declarationNumber}}</div>
            <div class="account-order-item-contain-txt-mob fl"><a href="https://novaposhta.ua/tracking/?cargo_number={{$order->declarationNumber}}" target="_blank"> Отследить посылку</a></div>
            @endif
        </div>

        <div class="account-order-history-content-title">
            <div class="account-order-history-img fl">Фото</div>
            <div class="account-order-history-name-mobile fl">Название</div>
            <div class="account-order-history-txt fl">Цена</div>
            <div class="account-order-history-txt fl">Кол-во</div>
            <!-- <div class="account-order-history-txt fl">Сумма</div> -->
        </div>
        @foreach($order->products as $product)
        <div class="account-order-history-content-txt">
        <a href="/product/{{$product->url}}">
            <div class="account-order-history-img his-img fl">
                @if($product->image)
                <img src="{{  url('product_images/' . $product->image) }}">
                @else
                <img src="{{  url('site/images/main-product.png') }}">
                @endif
            </div>
            <div class="account-order-history-name-mobile fl">{{$product->product_name}}</div>
            <div class="account-order-history-txt fl">{{$product->product_price}} грн</div>
            <div class="account-order-history-txt fl">{{$product->product_count}}</div>
            <!--  <div class="account-order-history-txt fl">{{$product->product_price * $product->product_count}} грн</div> -->
            </a>
        </div>
        @endforeach

    </div>
    @endforeach

    <script>
        var accountOrder = document.getElementsByClassName("account-order-item");
        var accountOrderInfo = document.getElementsByClassName("account-order-item-contain");
        var allNextSub1 = document.getElementsByClassName('account-order-history-content-txt');
        var allNextSub2 = document.getElementsByClassName('account-order-history-content-title');
        function clear2(){
            for(i=0; i < allNextSub1.length; i++){
                allNextSub1[i].style.height = "0";
            };
            for(i=0; i < allNextSub2.length; i++){
                allNextSub2[i].style.height = "0";
            };
            for(i=0; i < accountOrder.length; i++){
                accountOrder[i].style.cssText = "border-color:#e8e8e8";
            }

        }
        for(i=0; i < accountOrder.length; i++){

            accountOrder[i].addEventListener("click", function(){
                clear2();
                var actualNextSub = this.nextSibling.nextSibling.childNodes;


                for(i=0; i < actualNextSub.length; i++ ){
                    if(actualNextSub[i].className == "account-order-history-content-txt"){
                        actualNextSub[i].style.height = "72px";
                    }
                    if(actualNextSub[i].className == "account-order-history-content-title"){
                        actualNextSub[i].style.height = "40px";
                    }

                    if(actualNextSub[i].className == "orders-info-block"){
                        actualNextSub[i].style.height = "120px";
                    }
                }
                this.style.cssText = "border-color:#616161"

            })
        }

    </script>
    @stop