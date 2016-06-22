<?php

namespace App;
use DB;
use Cookie;
use Auth;
use App\MyCookie;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model {
	protected $table = 'carts';
	protected $fillable = ['user_id', 'product_id', 'count'];


	public static function getInstance() {
		if(Auth::check()) {
			return new \App\cartClasses\AuthCart;
		} else {
			return new \App\cartClasses\GuestCart;
		}
	}

	public static function clearUserList($user_id) {
		DB::table('carts')->where('user_id', $user_id)->delete();
	}

	public static function cookieToCart() {
		$cart = Cookie::get('cart');
		if($cart) {
			foreach ($cart as $product_id => $count) {
				if($product_id != 0) {
					$cartObj = self::getInstance();
					$cartObj->add($product_id, $count);
				}
			}
		}

		MyCookie::clearCart();
	}

}