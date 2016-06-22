<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Intake  extends Model {
	protected $table = 'intake_messages';

	public static function addItem($request) {
		DB::table('intake_messages')->insert($request);
	}


	public static function deleteItemsByProductId($product_id) {
		DB::table('intake_messages')->where('product_id', $product_id)->delete();
	}

	public static function getAll() {
		return DB::select("SELECT DISTINCT product_id, intake_messages.id, COUNT(intake_messages.id) as count, products.name FROM intake_messages LEFT JOIN products ON products.id = intake_messages.product_id GROUP BY product_id");
	}


	public static function getSingle($product_id) {
		$intake =  DB::table('intake_messages')->where('product_id', $product_id)->get();
		return $intake;
	}
}
