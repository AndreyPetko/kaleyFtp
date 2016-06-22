<?php

namespace App\cartClasses;
use DB;
use Auth;
use App\Cart;
use App\Product;

class AuthCart extends \App\Cart {

	function add($product_id, $count) {
		if(!Auth::check()) {
			return 0;
		}

		$cart = Cart::where('product_id','=',$product_id)->where('user_id', '=', Auth::user()->id)->first();
		if(isset($cart)){
			$user_id = Auth::user()->id;
			DB::statement('UPDATE carts SET count = count + :count WHERE user_id = :user_id AND product_id = :product_id',
				array($count, $user_id, $product_id));
		} else {
			Cart::create(array(
				'product_id' => $product_id,
				'user_id' => Auth::user()->id,
				'count' => $count,
				));
		}

		return 1;
	}

	function getProductsAndTotal() {
		$result = DB::table('carts')->where('user_id', Auth::user()->id)->lists('count', 'product_id');


		if(Auth::user()->role ==  'wholesaler' || Auth::user()->role == 'ander') {
			$productsAndTotal = Product::getProductsWithCountAndTotal($result, 1);
		} else {
			$productsAndTotal = Product::getProductsWithCountAndTotal($result);
		}

		return $productsAndTotal;
	}

	function deleteItem($product_id) {
		DB::table('carts')->where('user_id', Auth::user()->id)->where('product_id', $product_id)->delete();
	}

	function changeCount($product_id, $count) {
		DB::table('carts')->where('user_id', Auth::user()->id)->where('product_id', $product_id)->update(['count' => $count]);
	}


	function clearCart() {
		DB::table('carts')->where('user_id', Auth::user()->id)->delete();
	}
}