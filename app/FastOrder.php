<?php

namespace App;
use DB;
use App\Product;
use Auth;

class FastOrder extends Order
{

	public function add($request) {

		$product = Product::getById($request['product_id']);


		if(Auth::check()) {
			$userId = Auth::user()->id;
		} else {
			$userId = 0;
		}

		$id = DB::table('orders')->insertGetId(
			array('fio' => $request['name'], 'fast' => 1, 'totalprice' => $product->price * $request['count'], 'phone' => $request['phone'],
				'status' => 'Принят', 'user_id' => $userId)
			);

		DB::table('orders_products')->insert(
			array('product_id' => $request['product_id'], 'product_name' => $product->name,
				'product_price' => $product->price, 'product_count' => $request['count'], 'order_id' => $id)
			);
		return true;
	}


	public function get() {
		return DB::table('orders')->leftjoin('orders_products', 'orders.id', '=', 'orders_products.order_id')
		->select('orders.*', 'orders_products.*', 'orders.id as orderId')
		->where('fast', 1)
		->where('status', '!=', 'Выполнен')
		->orderBy('orders.id', 'desc')
		->get();
	}

}