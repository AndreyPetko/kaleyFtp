<?php

namespace App\cartClasses;
use DB;
use Cookie;
use App\MyCookie;
use App\Product;

class GuestCart extends \App\Cart {

	function add($product_id, $count) {
		$cookie_data = MyCookie::addCartitem($product_id,$count);
		$cookie = Cookie::make('cart', $cookie_data , '99999');
		Cookie::queue($cookie);
	}

	function getProductsAndTotal() {
		if(!Cookie::get('cart')) {
			return 0;
		}
		$productsAndTotal = Product::getProductsWithCountAndTotal(Cookie::get('cart'));

		return $productsAndTotal;
	}


	function deleteItem($product_id) {
		$cookie_data = MyCookie::deleteCartItem($product_id);
		$cookie = Cookie::make('cart', $cookie_data , '99999');
		Cookie::queue($cookie);
	}


	function changeCount($product_id, $count) {
		$cookie_data =  MyCookie::addCartitem($product_id,$count, 'change');
		$cookie = Cookie::make('cart', $cookie_data , '99999');
		Cookie::queue($cookie);
	}

	function clearCart() {
		MyCookie::clearCart();
	}
}