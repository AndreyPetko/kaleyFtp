<?php

namespace App\wishlistClasses;
use DB;
use Auth;


class AuthWishlist extends \App\Wishlist {

	public function get() {
		return DB::table('products')->leftjoin('wishlist', 'wishlist.product_id', '=', 'products.id')
		->leftjoin('images', 'images.product_id', '=', 'products.id')
		->select('products.*', 'images.url as image')
		->groupBy('products.id')
		->where('wishlist.user_id', Auth::user()->id)
		->orderBy('id', 'desc')
		->get();
	}


	public function check($productId) {
		$elem = DB::table('wishlist')->where('user_id', Auth::user()->id)->where('product_id', $productId)->count('id');

		return $elem;
	}

	public function change($productId) {
		$elem = DB::table('wishlist')->where('user_id', Auth::user()->id)->where('product_id', $productId)->count('id');
		if($elem) {
			$this->delete($productId);
			return 1;
		} else {
			$this->add($productId);
			return 2;
		}
	}

	public function add($productId) {
		$item =  DB::table('wishlist')->where('user_id', Auth::user()->id)->where('product_id', $productId)->get();
		if($item) return 0;

		DB::table('wishlist')->insert(['product_id' => $productId, 'user_id' => Auth::user()->id]);
		return 1;
	}

	public function delete($productId) {
		DB::table('wishlist')->where('user_id', Auth::user()->id)->where('product_id', $productId)->delete();
	}
}