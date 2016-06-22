<?php

namespace App;
use Auth;
use Cookie;
use DB;

class Wishlist {


	public static function getInstance() {
		if(Auth::check()) {
			return new \App\wishlistClasses\AuthWishlist();
		} else {
			return new \App\wishlistClasses\GuestWishlist();
		}
	}

	public static function cookieToWishlist() {
		$wishlist = Cookie::get('wishlist');
		if($wishlist) {
			foreach ($wishlist as $product_id) {
				if($product_id != 0) {
					$wishlistObj = self::getInstance();
					$wishlistObj->add($product_id);
				}
			}
		}
		\App\wishlistClasses\GuestWishlist::clearList();
	}

	public static function getLastWish($count) {
		return DB::table('products')->leftjoin('wishlist', 'wishlist.product_id', '=', 'products.id')
		->leftjoin('images', 'images.product_id', '=', 'products.id')
		->select('products.*', 'images.url as image')
		->groupBy('products.id')
		->where('wishlist.user_id', Auth::user()->id)
		->orderBy('id', 'desc')
		->take($count)
		->get();
	}


	public static function clearUserList($id) {
		DB::table('wishlist')->where('user_id', $id)->delete();
	}


	public static function setWishToProducts($products) {
		$wishObj = self::getInstance();
		$wishList = $wishObj->get();

		foreach ($products as $product) {
			foreach ($wishList as $wishItem) {
				$flag = 0;
				if($wishItem->id == $product->id) {
					$flag = 1;
				}
				if($flag) {
					$product->wish = 1;
				} 
			}
		}

		return $products;
	}

}