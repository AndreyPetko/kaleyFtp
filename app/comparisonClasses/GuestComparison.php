<?php

namespace App\comparisonClasses;
use DB;
use Cookie;

class GuestComparison extends \App\Comparison {

	function add($productId) {
		if($cookie_data = Cookie::get('complist')) {
			if(in_array($productId, $cookie_data)) {
				return 0;
			}

			if(count($cookie_data) == 4) {
				return 3;
			}


			$cookie_data[] = $productId;
		} else {
			$cookie_data = [];
			$cookie_data[] = $productId;
		}

		$cookie = Cookie::make('complist', $cookie_data , '99999');
		Cookie::queue($cookie);

		return 2;
	}

	public function get() {
		$wishIds = Cookie::get('complist');
		return DB::table('products')->leftjoin('images', 'images.product_id', '=', 'products.id')
		->select('products.*', 'images.url as image')
		->whereIn('products.id',$wishIds)->groupBy('products.id')->get();
	}

	public function getIds() {
		if($cookie_data = Cookie::get('complist')) {
			return $cookie_data;
		} else {
			return false;
		}
	}

	public function delete($productId) {
		if($cookie_data = Cookie::get('complist')) {
			if(in_array($productId, $cookie_data)) {
				unset($cookie_data[array_search($productId,$cookie_data)]); 
			}
		} else {
			$cookie_data = [];
		}

		$cookie = Cookie::make('complist', $cookie_data , '99999');
		Cookie::queue($cookie);
	}


	public static function clearList() {
		$cookie = Cookie::make('complist', [], '99999');
		Cookie::queue($cookie);
	}


	public function check($productId) {
		if($cookie_data = Cookie::get('complist')) {
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

		if($cookie_data = Cookie::get('complist')) {
			if(in_array($productId, $cookie_data)) {
				$this->delete($productId);
				return 1;
			} else {
				return $this->add($productId);

			}
		} else {
			return $this->add($productId);
		}
	}

}