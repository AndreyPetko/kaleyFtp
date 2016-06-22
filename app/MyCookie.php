<?php

namespace App;
use Cookie;

class MyCookie {

	public static  function addItem($id) {
		if ($cookie_data = Cookie::get('watched')) {
			if(!is_array($cookie_data))
			{
				$data = [];
				$data[] = $cookie_data;
			}else{
				$data = $cookie_data;
			}

			if(!in_array($id, $data)) {
				$data[] = $id;
			} else {
				$key = array_search($id,$data);
				unset($data[$key]);
				$data[] = $id;
			}

		} else {
			$data = [];
			$data[] = $id;
		}

		return $data;
	}


	public static function clearCart() {
		$cart = Cookie::make('cart', [] , '99999');
		Cookie::queue($cart);
	}


	public static function addCartItem($id, $count, $type = 'add') {
		if($cookie_data = Cookie::get('cart')) {

			if(isset($cookie_data[$id])) {
				if($type == 'add') {
					$cookie_data[$id] = $cookie_data[$id] + $count;
				}
				if($type == 'change') {
					$cookie_data[$id] = $count;
				}
				
			} else {
				$cookie_data[$id] = $count;
			}


		} else {
			$cookie_data = [];
			$cookie_data[$id] = $count;
		}

		return $cookie_data;
	}

	public static function deleteCartItem($id) {
		$cart = Cookie::get('cart');
		unset($cart[$id]);
		return $cart;
	}

}