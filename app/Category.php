<?php

namespace App;
use DB;
use App\Attribute;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categories';
	protected $fillable = array('name','url','description', 'image');

	public function Subcategories() {
		return $this->hasMany('App\Subcategory');
	}

	public function Product() {
		return $this->hasMany('App\Product');
	}


	public static function getAttributesById($id) {
		return DB::select("SELECT * FROM category_attr LEFT JOIN attributes ON category_attr.attribute_id = attributes.id
			WHERE category_id = :id", array('id' => $id));
	}

	public static function getByUrl($url) {
		$category =  DB::select("SELECT * FROM categories WHERE url = :url", array($url));
		return $category[0];
	}



	public static function getUrlBySubcatId($subcategoryId) {
		return DB::table('categories as c')->join('subcategories as s', 's.category_id', '=', 'c.id')
		->where('s.id',$subcategoryId)->value('c.url');
	}

	public static function getByProductId($productId) {
		return DB::table('categories as c')->join('products as p', 'p.category_id', '=', 'c.id')->select('c.name', 'c.url' ,'c.id')->where('p.id', $productId)->first();
	}


	public static function updateItem($category_id, $request) {
		unset($request['_token']);
		$update = $request;
		unset($update['attributes']);
		$result = self::updateFields($category_id, $update);

		if(!isset($request['attributes'])) {
			$request['attributes'] = [];
		}

		$result = Attribute::updateCategoryItems($category_id, $request['attributes']);

		if(!$result) {
			return false;
		}

		return true;

	}

	public static function updateFields($category_id, $update) {
		self::where('id', $category_id)->update($update);
	}


	public static function deleteItem($category_id) {
		//Удалить привязку атрибутов к этой категории
		DB::table('category_attr')->where('category_id', $category_id)->delete();

		//Поменять всем товарам id категории на 0 ( без категории )
		DB::table('products')->where('category_id', $category_id)->update(['category_id' => 0]);

		//Удалить категорию
		DB::table('categories')->where('id', $category_id)->delete();
	}


	public static function getCatalog() {
		$categories = DB::select("SELECT `categories`.*,
		(SELECT MAX(products.price) FROM products WHERE products.category_id = categories.id) as maxPrice,
		(SELECT COUNT(products.id) FROM products WHERE products.category_id = categories.id) as countProducts
		FROM categories");

		return $categories;
	}


	public static function getCategoriesUrls() {
		$url = self::getUrlById(39);
		$categoriesUrls = [];
		$categoriesUrls['threads'] = $url;
		return $categoriesUrls;
	}


	public static function getUrlById($id) {
		return DB::table('categories')->where('id', $id)->value('url');
	}
}
