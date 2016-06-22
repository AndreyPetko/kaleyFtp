<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
	protected $table = 'subcategories';
	protected $fillable = array('name','url');

	public function Category() {
		return $this->belongsTo('App\Category');
	}


	public static function getByCategoryId($id) {
		return DB::select("SELECT * FROM subcategories WHERE category_id = :id ORDER BY name", array($id));
	}

	public static function getByUrl($url) {
		$subcategories = DB::select("SELECT subcategories.*, categories.name as categoryName, categories.url as categoryUrl FROM subcategories LEFT JOIN categories ON categories.id = subcategories.category_id WHERE subcategories.url = :url", array($url));
		return $subcategories[0];
	}

	public static function getSameCateogoryByUrl($url) {
		return DB::select("SELECT * FROM subcategories WHERE category_id = (SELECT category_id FROM subcategories WHERE url = :url)", array($url));
	}

	public static function deleteById($subcategoryId) {
		//Удаляем все товары этой подкатегории
		DB::table('product_subcat')->where('subcat_id', $subcategoryId)->delete();

		//Удаляем подкатегорию
		DB::table('subcategories')->where('id', $subcategoryId)->delete();
	}

	public static function getById($id) {
		return DB::table('subcategories')->where('id', $id)->first();
	}

	public static function updateItem($request) {
		DB::table('subcategories')->where('id', $request['subcategory_id'])
		->update(['name' => $request['name'], 'category_id' => $request['category_id']]);
	}


	public static function getBrendItems($brend_id) {
		return DB::select("SELECT DISTINCT product_subcat.subcat_id as id, subcategories.name FROM product_subcat LEFT JOIN products ON products.id = product_subcat.product_id LEFT JOIN subcategories ON subcategories.id = product_subcat.subcat_id WHERE products.brend_id = :brend_id", [$brend_id]);
	}
}
