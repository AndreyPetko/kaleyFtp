<?php


namespace App;
use Auth;
use Cookie;
use DB;


class Comparison {

	public static function getInstance() {
		if(Auth::check()) {
			return new \App\comparisonClasses\AuthComparison();
		} else {
			return new \App\comparisonClasses\GuestComparison();
		}
	}

	public static function clearUserList($id) {
		DB::table('comparison')->where('user_id', $id)->delete();
	}


	public static function cookieToComparison() {
		$wishlist = Cookie::get('complist');

		if($wishlist) {
			foreach ($wishlist as $product_id) {
				if($product_id != 0) {
					$wishlistObj = self::getInstance();
					$wishlistObj->add($product_id);
				}
			}
		}

		\App\comparisonClasses\GuestComparison::clearList();
	}
}