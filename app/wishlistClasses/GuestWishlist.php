<?php

namespace App\wishlistClasses;
use DB;
use Auth;
use Cookie;


class GuestWishlist extends \App\Wishlist {

	public function get() {
		$wishIds = Cookie::get('wishlist');
		return DB::table('products')->leftjoin('images', 'images.product_id', '=', 'products.id')
		->select('products.*', 'images.url as image')
		->whereIn('products.id',$wishIds)->groupBy('products.id')->get();
	}


	public function check($productId) {
		if($cookie_data = Cookie::get('wishlist')) {
			if(in_array($productId, $cookie_data)) {
				return 1;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}


	public function change($productId) {

		if($cookie_data = Cookie::get('wishlist')) {
			if(in_array($productId, $cookie_data)) {
				$this->delete($productId);
				return 1;
			} else {
				$this->add($productId);
				return 2;
			}
		} else {
			$this->add($productId);
			return 2;
		}
	}

	public function add($productId) {
		if($cookie_data = Cookie::get('wishlist')) {
			if(in_array($productId, $cookie_data)) return 0;
			$cookie_data[] = $productId;
		} else {
			$cookie_data = [];
			$cookie_data[] = $productId;
		}

		$cookie = Cookie::make('wishlist', $cookie_data , '99999');
		Cookie::queue($cookie);

		return 1;
	}


	public function delete($productId) {
		if($cookie_data = Cookie::get('wishlist')) {
			if(in_array($productId, $cookie_data)) {
				unset($cookie_data[array_search($productId,$cookie_data)]); 
			}
		} else {
			$cookie_data = [];
		}

		$cookie = Cookie::make('wishlist', $cookie_data , '99999');
		Cookie::queue($cookie);
	}

	public static function clearList() {
		$cookie = Cookie::make('wishlist', [], '99999');
		Cookie::queue($cookie);
	}
}