<?php

namespace App\Http\Controllers;

use App\Order;
use Request;
use App\Product;
use Redirect;
use Mail;
use Auth;



class OrdersController extends Controller {

	public function __construct() {
	}


	public function postAdd() {
		$request = Request::all();
		unset($request['_token']);


		$order = Order::getInstance($request['type']);
		$result = $order->add($request);

		if(!$result) {
			return Redirect::back()->with('emptyCartError', 1);
		}


		if(!Auth::check() || Auth::user()->role == 'retail') {
			$email = 'andreypetko3@gmail.com';


			if($request['type']) { // быстрый
				Mail::send('emails.orderFast', ['name' => $request['name'], 'phone' => $request['phone']], function($message) use ($email)
				{
					$message->to($email, 'Kaleydoskop')->subject('На сайте новый заказ');
				});
			} else {
				Mail::send('emails.order', ['name' => $request['name'], 'phone' => $request['phone'], 'email' => $request['email'], 'dt' => $request['delivery_dt']], function($message) use ($email)
				{
					$message->to($email, 'Kaleydoskop')->subject('На сайте новый заказ');
				});
			}


		}

		if($request['email']) {
			$email = $request['email'];
			$order = Order::getLast();

			$order = Order::changePaymentAndDelivery($order);
			$products = Order::getItemProducts($order->id);
			$namesCount  = Order::getNamesCount($order->id);

			Mail::send('print.order', ['order' => $order,'products' =>  $products,'namesCount' => $namesCount], function($message) use ($email)
			{
				$message->to($email, 'Kaleydoskop')->subject('Ваша накладная');
			});
		}



		return Redirect::to('/')->with('orderSuccess', true);
	}

}