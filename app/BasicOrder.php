<?php

namespace App;
use DB;
use Redirect;
use Auth;


class BasicOrder extends Order
{

	public function add($request) {

		if(!isset($request['product'])) {
			return false;
		}


		if(isset($request['delivery'])) {
			$deliveryType = $request['delivery'][0];
		} else {
			$deliveryType = 'empty';
		}


		if(isset($request['payment'])) {
			$paymentType = $request['payment'][0];
		} else {
			$paymentType = 'empty';
		}


		if(Auth::check() && (Auth::user()->role == 'wholesaler' || Auth::user()->role == 'ander')) {
			$productsAndTotal = Product::getProductsWithCountAndTotal($request['product'], 1);
		} else {
			$productsAndTotal = Product::getProductsWithCountAndTotal($request['product']);
		}



		if($request['user_id'] != 0) {
			$discount = DB::table('users')->where('id', $request['user_id'])->value('discount');
			$totalprice = $productsAndTotal[1] - $discount * $productsAndTotal[1]/100;
		} else {
			$totalprice = $productsAndTotal[1];
			$discount = 0;
		}



		$id = DB::table('orders')->insertGetId([
			'user_id' => $request['user_id'],'fio' => $request['name'],'fast' => 0,
			'phone' => $request['phone'], 'address' => $request['address'], 'delivery_dt' => $request['delivery_dt'],
			'email' => $request['email'], 'comment' => $request['comment'], 'delivery_type' => $deliveryType,
			'status' => 'Принят', 'payment_type' => $paymentType, 'totalprice' => $totalprice,
			'discount' => $discount, 'time_start' => $request['time_start'], 'time_end' => $request['time_end']
			]);

		foreach ($productsAndTotal[0] as $product) {
			DB::table('orders_products')->insert(['product_id' => $product->id, 'product_price' => $product->price,
				'product_count' => $product->count, 'order_id' => $id, 'product_name' => $product->name]);
		}

		$cart = Cart::getInstance();
		$cart->clearCart();

		return $id;
	}

	public function get() {
		return 1;
	}

}