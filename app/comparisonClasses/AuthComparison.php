<?php

namespace App\comparisonClasses;
use DB;
use Auth;

class AuthComparison extends \App\Comparison {

	function add($productId) {
		$item =  DB::table('comparison')->where('user_id', Auth::user()->id)->where('product_id', $productId)->get();
		if($item) return 0;

		$count = DB::table('comparison')->where('user_id', Auth::user()->id)->count();


		if($count == 4) {
			return 3;
		}


		DB::table('comparison')->insert(['product_id' => $productId, 'user_id' => Auth::user()->id]);
		return 2;
	}


	function getIds() {
		return DB::table('comparison')->where('user_id', Auth::user()->id)->lists('product_id');
	}


	function delete($productId) {
		DB::table('comparison')->where('user_id', Auth::user()->id)->where('product_id', $productId)->delete();
		return 1;
	}

	public function check($productId) {
		$elem = DB::table('comparison')->where('user_id', Auth::user()->id)->where('product_id', $productId)->count('id');

		return $elem;
	}

	public function clearList() {
		DB::table('comparison')->where('user_id', Auth::user()->id)->delete();
	}


	public function change($productId) {
		$elem = DB::table('comparison')->where('user_id', Auth::user()->id)->where('product_id', $productId)->count('id');
		if($elem) {
			$this->delete($productId);
			return 1;
		} else {
			return $this->add($productId);
		}
	}


}