<?php

namespace App;
use DB;
use App\MyDate;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
	protected $table = 'reviews';
	public $timestamps = true;
	protected $fillable = ['name', 'product_id', 'text', 'email', 'created_at', 'updated_at', 'readed'];


	public static function getProductReview($product_id, $withProductInfo = 0) {
		$query = DB::table('reviews')->where('product_id', $product_id);

		if($withProductInfo) {
			$query->leftjoin('products', 'reviews.product_id', '=', 'products.id');
			$query->select('reviews.*', 'products.name as productName', 'products.url as productUrl');
		}

		$reviews = $query->paginate(10);
		return $reviews;
	}


	public static function getItems() {
		$reviews =  DB::table('reviews')->select('reviews.*', 'products.name as productName', 'products.url as productUrl')
		->leftjoin('products', 'reviews.product_id', '=', 'products.id')->orderby('id','desc')->paginate(10);

		$reviews = MyDate::changeFormat($reviews);

		return $reviews;
	}

	public static function getCountByProductId($product_id) {
		return DB::table('reviews')->where('product_id', $product_id)->count();
	}

	public static function setReaded() {
		DB::table('reviews')->where('readed', 0)->update(['readed' => 1]);
	}

	public static function getCountNotReaded() {
		return DB::table('reviews')->where('readed', 0)->count();
	}

	public static function getNotReaded() {
		$reviews  = DB::table('reviews')->where('readed', 0)->get();

		$reviews = MyDate::changeFormat($reviews);

		return $reviews;
	}
}
