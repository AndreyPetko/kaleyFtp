<?php

namespace App;
use DB;
use App\Image;
use Session;
use App\Helper;
use Cookie;
use Illuminate\Pagination\Paginator;
use App\Attribute;
use Auth;
use Cache;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $table = 'products';
	protected $fillable = array('name', 'article', 'description', 'price', 'wholesale_price' , 'url', 'category_id', 'brend_id', 'quantity', 'active', 'active_wholesale', 'search', 'code', 'group');

	public function images() {
		return $this->hasMany('App\Image');
	}

	public function Category() {
		return $this->belongsTo('App\Category');
	}

	public static function getSubcategories($id) {
		return DB::select("SELECT `s`.*  FROM `subcategories` as s LEFT JOIN `product_subcat` as ps ON s.id = ps.subcat_id
			WHERE ps.product_id = :id", array('id' => $id));
	}

	public static function getSubcategoriesWithMark($id) { // Возвращает подкатегории товара с отмеченными выбраными категориями
		$activeSubcategories = DB::select("SELECT `s`.*  FROM `subcategories` as s LEFT JOIN `product_subcat` as ps ON s.id = ps.subcat_id
			WHERE ps.product_id = :id", array('id' => $id));
		$subcategories = DB::select('SELECT * FROM `subcategories` WHERE category_id  = (SELECT category_id FROM products WHERE id = :id) ORDER BY name', array($id));

		foreach ($subcategories as $subcategory) {
			foreach ($activeSubcategories as $activeSubcategory) {
				if($subcategory->id === $activeSubcategory->id) {
					$subcategory->active = 1;
				}
			}
		}

		return $subcategories;
	}


	public static function getActive($products) {


		foreach ($products as $key => $product) {
			$final_active = 0;

			if(self::isWholesaler()) {
				if($product->active_wholesale) {
					$final_active = 1;
				}
			} else {
				if($product->active) {
					$final_active = 1;
				}
			}

			if(!$final_active) {
				unset($products[$key]);
			}

		}


		return $products;
	}


	public static function isWholesaler() {
		return Auth::check() && (Auth::user()->role == 'wholesaler' || Auth::user()->role == 'ander' );
	}

	public static function getProductAttributes($id) {
		return DB::select("SELECT `a`.*, `pav`.value FROM `attributes` as a LEFT JOIN `product_attrs_value` as pav ON a.id = pav.attribute_id
			WHERE pav.product_id = :id", array('id' => $id));
	}

	public static function deleteById($id) {
		// Удалить товар
		DB::statement('DELETE FROM `products` WHERE id = :id', array($id));
		// Удалить изображения
		DB::statement('DELETE FROM `images` WHERE product_id = :id', array($id));
		//	Удалить связи с подкатегориями
		DB::statement('DELETE FROM `product_subcat` WHERE `product_id` = :id', array($id));
		// Удалить связи с атрибутами
		DB::statement('DELETE FROM `product_attrs_value` WHERE `product_id` = :id', array($id));
		// Удалем товар со всех корзин пользователя
		DB::statement('DELETE FROM `carts` WHERE `product_id` = :id', array($id));
		DB::statement('DELETE FROM `wishlist` WHERE `product_id` = :id', array($id));
		DB::statement('DELETE FROM `comparison` WHERE `product_id` = :id', array($id));
		//Удалить все связанные товары ( с этим товаром берут)
		DB::statement('DELETE FROM `withproduct` WHERE `product_id` = :id', array($id));
	}

	public static function addItem($request) {

		$product_id = Product::create($request)->id;
		$product = Product::find($product_id);

		if($request['images'][0]) {
			Image::addImages($request['images'], $product_id, $product->url, 0);
		}



		if(isset($request['attributes'])) {
			foreach ($request['attributes'] as $attribute_id => $value) {
				DB::table('product_attrs_value')->insert(
					['product_id' => $product_id, 'attribute_id' => $attribute_id, 'value' => $value]
					);
			}
		}

		if(isset($request['subcats'])) {
			foreach ($request['subcats'] as $key => $value) {
				DB::table('product_subcat')->insert(
					['product_id' => $product_id, 'subcat_id' => $value]
					);
			}
		}

		self::setNewProducts();
	}

	public static function getById($id) {
		return DB::table("products")->where('id', $id)->first();
	}

	public static function getImagesById($id) {
		return DB::select("SELECT id,url FROM images WHERE product_id = :id", array($id));
	}

	public static function getNameById($id) {
		return DB::table("products")->where('id', $id)->value('name');
	}


	public static function updateItem($request, $id) {
		if(!isset($request['category_id'])) {
			$request['category_id'] = 0;
		}

		// Обновляем поля в таблице table
		$update = $request;


		unset($update['images']);
		unset($update['categories']);
		unset($update['attributes']);
		unset($update['subcats']);


		self::where('id', $id)
		->update($update);

		// Удаляем все записи подкатегории для данного товара
		DB::statement("DELETE FROM product_subcat WHERE product_id = :id", array($id));

		//Вставляем в бд все выбранные подкатегории
		if(isset($request['subcats'])) {
			foreach ($request['subcats'] as $subcat_id) {
				DB::statement("INSERT INTO product_subcat SET product_id = :id, subcat_id = :subcat_id",
					array($id, $subcat_id));
			}
		}


		// Удалем все значения атрибутов для данного товара
		DB::statement("DELETE FROM product_attrs_value WHERE product_id = :id", array($id));

		// Обновляем значение атрибутов
		if(isset($request['attributes'])) {
			foreach ($request['attributes'] as $attribute_id => $value) {
				DB::statement("INSERT INTO `product_attrs_value` SET value = :value, attribute_id = :attribute_id, product_id = :id",
					array($value,$attribute_id, $id));
			}
		}





		// Добавляем новые картинки
		if($request['images'][0]) {
			$startIndex = DB::table('images')->where('product_id', $id)->count();
			Image::addImages($request['images'], $id, $request['url'], $startIndex);
		}

	}


	public static function setWholesalePrice($products, $array = 0) {

		if(!Auth::check() || !(Auth::user()->role == 'wholesaler' || Auth::user()->role == 'ander')) {
			return $products;
		}


		if($array) {
			foreach ($products as $product) {
				if($product->wholesale_price) {
					$product->price = $product->wholesale_price;
				}
			}
		} else {
			if($products->wholesale_price) {
				$products->price = $products->wholesale_price;
			}
		}



		return $products;
	}


	public static function getFirstImages($products) {
		foreach ($products as $product) {
			foreach ($product->images as $image) {
				$product->image = $image->url;
				break;
			}
		}

		return $products;
	}


	public static function getRecommended($limit = 0, $limit2 = 0) {
		if(self::isWholesaler()) {
			if($limit2 != 0) {
				$recProducts = DB::select('SELECT products.*, images.url as image FROM products LEFT JOIN images ON products.id =  images.product_id WHERE products.active_wholesale = 1 AND recommended = 1 GROUP BY (products.id) LIMIT :limit, :limit2', array($limit, $limit2));
			} else {
				if($limit != 0) {
					$recProducts = DB::select('SELECT products.*, images.url as image FROM products LEFT JOIN images ON products.id =  images.product_id WHERE products.active_wholesale = 1 AND recommended = 1 GROUP BY (products.id) LIMIT :limit', array($limit));
				} else {
					$recProducts = DB::select('SELECT products.*, images.url as image FROM products LEFT JOIN images ON products.id =  images.product_id WHERE products.active_wholesale = 1 AND recommended = 1 GROUP BY (products.id)');
				}
			}
		} else {
			if($limit2 != 0) {
				$recProducts = DB::select('SELECT products.*, images.url as image FROM products LEFT JOIN images ON products.id =  images.product_id WHERE products.active = 1 AND recommended = 1 GROUP BY (products.id) LIMIT :limit, :limit2', array($limit, $limit2));
			} else {
				if($limit != 0) {
					$recProducts = DB::select('SELECT products.*, images.url as image FROM products LEFT JOIN images ON products.id =  images.product_id WHERE products.active = 1 AND recommended = 1 GROUP BY (products.id) LIMIT :limit', array($limit));
				} else {
					$recProducts = DB::select('SELECT products.*, images.url as image FROM products LEFT JOIN images ON products.id =  images.product_id WHERE products.active = 1 AND recommended = 1 GROUP BY (products.id)');
				}
			}
		}

		return $recProducts;
	}


	public static function getNotRecommended() {
		return DB::select("SELECT name,id FROM products WHERE recommended = 0");
	}

	public static function setRecommended($product_id, $value) {
		DB::statement("UPDATE products SET recommended = :value WHERE id = :product_id", array($value, $product_id));
	}

	public static function getNew($limit = 0, $limit2 = 0) {
		// if(self::isWholesaler()) {
		// 	if($limit2 != 0) {
		// 		$recProducts = DB::select('SELECT products.*, images.url as image FROM products LEFT JOIN images ON products.id =  images.product_id WHERE active_wholesale = 1  GROUP BY (products.id) ORDER BY products.id DESC LIMIT :limit, :limit2', array($limit, $limit2));
		// 	} else {
		// 		if($limit != 0) {
		// 			$recProducts = DB::select('SELECT products.*, images.url as image FROM products LEFT JOIN images ON products.id = images.product_id WHERE active_wholesale = 1  GROUP BY (products.id) ORDER BY products.id DESC LIMIT :limit', array($limit));
		// 		} else {
		// 			$recProducts = DB::select('SELECT products.*, images.url as image FROM products LEFT JOIN images ON products.id =  images.product_id  WHERE active_wholesale = 1 GROUP BY (products.id)');
		// 		}
		// 	}
		// } else {
		// 	if($limit2 != 0) {
		// 		$recProducts = DB::select('SELECT products.*, images.url as image FROM products LEFT JOIN images ON products.id =  images.product_id WHERE active = 1  GROUP BY (products.id) ORDER BY products.id DESC LIMIT :limit, :limit2', array($limit, $limit2));
		// 	} else {
		// 		if($limit != 0) {
		// 			$recProducts = DB::select('SELECT products.*, images.url as image FROM products LEFT JOIN images ON products.id = images.product_id WHERE active = 1  GROUP BY (products.id) ORDER BY products.id DESC LIMIT :limit', array($limit));
		// 		} else {
		// 			$recProducts = DB::select('SELECT products.*, images.url as image FROM products LEFT JOIN images ON products.id =  images.product_id  WHERE active = 1 GROUP BY (products.id)');
		// 		}
		// 	}

		// }


		if(self::isWholesaler()) {
			$recProducts = self::where('active_wholesale', 1)->skip($limit2)->take($limit)->get();
		} else {
			$recProducts = self::where('active', 1)->skip($limit2)->take($limit)->get();
		}


		return $recProducts;
	}

	public static function getByCategoryId($id, $sortType = 'name') {
		$products =  DB::table('products')->join('images', 'products.id', '=', 'images.product_id')
		->select('products.*', 'images.url as image')
		->where('products.category_id' , $id)
		->orderBy($sortType)
		->groupBy('products.id')
		->paginate(3);

		return $products;
	}


	public static function getBySubcategoryId($subcategory_id) {
		return DB::select("SELECT products.*,images.url as image FROM products LEFT JOIN product_subcat ON products.id = product_subcat.product_id LEFT JOIN images ON products.id = images.product_id
			WHERE subcat_id = :subcategory_id", array($subcategory_id));
	}


	public static function getByCategoryWithSort($categoryUrl, $sortType) {
		return DB::table('products')->join('images', 'products.id', '=', 'images.product_id')
		->join('categories', 'products.category_id', '=', 'categories.id')
		->select('products.*', 'images.url as image')
		->where('categories.url', $categoryUrl)
		->groupBy('products.id')
		->orderBy($sortType)
		->paginate(3);
	}


	public static function getBySessionBrendFilter($brendUrl, $returnType = 1) {
		$query = self::where('brends.url', $brendUrl)
		->leftjoin('product_subcat', 'products.id', '=', 'product_subcat.product_id')
		->leftjoin('categories', 'products.category_id', '=', 'categories.id')
		->leftjoin('brends', 'products.brend_id', '=', 'brends.id')
		->leftjoin('product_attrs_value', 'product_attrs_value.product_id', '=', 'products.id')
		->leftjoin('attributes', 'product_attrs_value.attribute_id', '=', 'attributes.id')
		->select('products.name', 'products.price', 'products.id', 'products.wholesale_price', 'products.quantity','products.url')
		->groupBy('products.id');

		if(!empty(Session::get('brendFilter'))) {
			$filter = Session::get('brendFilter');
			$empty = Helper::isFilterEmpty($filter);
			if(!$empty) {
				$whereRaw = '';
				foreach ($filter as $key => $value) {
					if(!empty($value)) {
						$imArr = [];
						foreach ($value as  $valueItem) {
							$imArr[] = '"' . $valueItem . '"';
						}

						$values = implode(',', $imArr);
						$whereRaw .= '(`attributes`.`name` = "' . $key . '" AND `product_attrs_value`.`value` IN (' . $values . ')) OR ';
					}

				}
				$whereRaw = substr($whereRaw, 0, -3);
				$query->whereRaw($whereRaw);
			}

		}


		if(Session::get('brendMinPrice')) {
			$query->where('price', '>', Session::get('brendMinPrice'));
		}

		if(Session::get('brendMaxPrice')) {
			$query->where('price', '<', Session::get('brendMaxPrice'));
		}

		if(Session::get('brendsShowType')) {
			$showType = Session::get('brendsShowType');
		} else {
			$showType = 'table';
		}

		if(Session::get('brendOrderType')) {
			$query->orderBy(Session::get('brendOrderType'));
		}

		if(Session::get('subcat')) {
			$query->whereIn('product_subcat.subcat_id', Session::get('subcat'));
		}


		if(self::isWholesaler()) {
			$query->where('active_wholesale', 1);
		} else {
			$query->where('active', 1);
		}


		if(Session::get('brendsShowCount')) {
			$products = $query->paginate((int)Session::get('brendsShowCount'));
		} else {
			$products = $query->paginate(9);
		}


		$wishObj = Wishlist::getInstance();
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


		foreach ($products as $product) {
			foreach ($product->images as $image) {
				$product->image = $image->url;
				break;
			}
		}

		$products = self::setWholesalePrice($products, 1);

		if($returnType == 1) {
			$pagination = $products->render();
			$retProducts = [];
			foreach ($products as $product) {
				$retProducts[] = $product;
			}
			$return = [$retProducts,$pagination, $showType];
		}

		if($returnType == 2) {
			$return = $products;
		}


		return $return;
	}


	public static function getBySessionFilter($categoryUrl, $returnType = 1, $currentPage = false) {

		if($currentPage) {
			Paginator::currentPageResolver(function() use ($currentPage) {
				return $currentPage;
			});
		}

		// $products = Cache::remember('products' . $currentPage, 10, function() use ($categoryUrl)
		// {

		$query = self::where('categories.url', $categoryUrl)
		// ->leftjoin('images', 'products.id', '=', 'images.product_id')
		->leftjoin('product_subcat', 'products.id', '=', 'product_subcat.product_id')
		->leftjoin('categories', 'products.category_id', '=', 'categories.id')
		->leftjoin('product_attrs_value', 'product_attrs_value.product_id', '=', 'products.id')
		->leftjoin('attributes', 'product_attrs_value.attribute_id', '=', 'attributes.id')
		->select('products.name', 'products.price', 'products.id', 'products.wholesale_price', 'products.quantity','products.url')
		->groupBy('products.id');

		if(Session::get('startPrice'))
			$query->where('price', '>=', Session::get('startPrice'));

		if(Session::get('stopPrice'))
			$query->where('price', '<=', Session::get('stopPrice'));

		if(Session::get('sortType')) {
			$query->orderBy(Session::get('sortType'));
		} else {
			$query->orderBy('name');
		}

		if(Session::get('subcatId')) {
			$query->where('product_subcat.subcat_id', Session::get('subcatId'));
		}


		if(Session::get('aval')) {
			if(Session::get('aval') == 1) {
				$query->where('products.quantity', '>', 0);
			}
		}


		if(Session::get('brends')) {
			$query->whereIn('products.brend_id', Session::get('brends'));
		}


		if(self::isWholesaler()) {
			$query->where('active_wholesale', 1);
		} else {
			$query->where('active', 1);
		}

		if(!empty(Session::get('filter'))) {
			$filter = Session::get('filter');
			$empty = Helper::isFilterEmpty($filter);
			if(!$empty) {
				$whereRaw = '';
				foreach ($filter as $key => $value) {
					if(!empty($value)) {
						$imArr = [];
						foreach ($value as  $valueItem) {
							$imArr[] = '"' . $valueItem . '"';
						}

						$values = implode(',', $imArr);
						$whereRaw .= '(`attributes`.`name` = "' . $key . '" AND `product_attrs_value`.`value` IN (' . $values . ')) OR ';
					}

				}
				$whereRaw = substr($whereRaw, 0, -3);
				$query->whereRaw($whereRaw);
			}

		}


		if(Session::get('showCount')) {
			$products = $query->paginate((int)Session::get('showCount'));
		} else {
			$products = $query->paginate(9);
		}


		// $products = $query->take(9)->get();

		$products = Wishlist::setWishToProducts($products);

		if(Session::get('showType')) {
			$showType = Session::get('showType');
		} else {
			$showType = 'table';
		}

		$products = self::setWholesalePrice($products, 1);


		foreach ($products as $product) {
			foreach ($product->images as $image) {
				$product->image = $image->url;
				break;
			}
		}


			// return $products;
		// });

		if($returnType == 1) {
			$pagination = $products->render();
			$retProducts = [];
			foreach ($products as $product) {
				$retProducts[] = $product;
			}
			$return = [$retProducts,$pagination, $showType];
		}

		if($returnType == 2) {
			$return = $products;
		}
		return $return;
	}

	public static function getMaxCategoryPrice($categoryId) {
		$price = DB::table('products')->where('category_id', $categoryId)->max('price');
		return $price;
	}

	public static function getByUrl($url) {
		$product =  DB::select("SELECT `products`.*,`brends`.name as brendName FROM products LEFT JOIN brends ON products.brend_id = brends.id WHERE `products`.url = :url", array($url));

		$product = self::getFinalActive($product[0]);

		return $product;
	}


	public static function getFinalActive($product) {
		$product->final_active = 0;
		if(self::isWholesaler()) {
			if($product->active_wholesale) {
				$product->final_active = 1;
			}
		} else {
			if($product->active) {
				$product->final_active = 1;
			}
		}

		return $product;
	}


	public static function getWatched($product_id) {
		$watched = Cookie::get('watched');

		if(!$watched) {
			return false;
		}


		if(in_array($product_id, $watched)) {
			$key = array_search($product_id, $watched);
			unset($watched[$key]);
		}

		if(empty($watched)) {
			return false;
		}

		$reverseWatched = array_reverse($watched);

		$sliceWatched = array_slice($reverseWatched, 0, 4 );

		$watchedProducts = self::getByArrayId($sliceWatched);

		return $watchedProducts;
	}


	public static function getByArrayId($array) {
		$arrayStr = implode(',', $array);

		$products = DB::table('products')->leftjoin('images','products.id', '=', 'images.product_id')
		->select('products.*', 'images.url as image')
		->groupBy('products.id')
		->whereIn('products.id', $array)
		->orderByRaw(DB::raw("FIELD(product_id, $arrayStr)"))
		->get();

		return $products;
	}

	public static function getWithIds($product_id) {
		return DB::table('withproduct')->where('product_id', $product_id)->lists('with_product_id');
	}

	public static function getWithOut($withoutIds) {
		return DB::table('products')->whereNotIn('id', $withoutIds)->get();
	}

	public static function getWith($product_id) {
		$arrIds = self::getWithIds($product_id);
		if(!$arrIds) {
			return false;
		}

		$products = self::getByArrayId($arrIds);
		$products = self::getActive($products);
		return $products;
	}

	public static function withAdd($product_id, $with_product_id) {
		return DB::table('withproduct')->insert([
			'product_id' => $product_id,
			'with_product_id' => $with_product_id
			]);
	}


	public static function withDelete($product_id, $with_product_id) {
		return DB::table('withproduct')
		->where('product_id', $product_id)
		->where('with_product_id', $with_product_id)
		->delete();
	}

	public static function withCount($product_id) {
		return DB::table('withproduct')->where('product_id', $product_id)->count();
	}

	public static function allWithOutOne($product_id) {
		return DB::table('products')->where('id', '!=', $product_id)->get();
	}

	public static function search($query) {
		$query = htmlspecialchars($query);
		$dbQuery = DB::table('products')->select('products.*', 'images.url as image')
		->leftjoin('images','images.product_id', '=', 'products.id')
		->groupBy('products.id');


		if(self::isWholesaler()) {
			$dbQuery->whereRaw(" active_wholesale = 1 AND (name LIKE '%" . $query . "%' OR description LIKE '%" . $query . "%' OR search LIKE '%" . $query . "%')");
		} else {
			$dbQuery->whereRaw(" active = 1 AND (name LIKE '%" . $query . "%' OR description LIKE '%" . $query . "%' OR search LIKE '%" . $query . "%')");
		}

		$items = $dbQuery->paginate(10);

		return $items;
	}

	public static function getProductsWithCountAndTotal($array, $wholesale = 0) {
		$keys = array_keys($array);

		$products = DB::table('products')->leftjoin('images', 'products.id', '=', 'images.product_id')
		->select('products.*', 'images.url as image')
		->whereIn('products.id', $keys)
		->groupBy('products.id')
		->get();


		$total = 0;


		foreach ($products as $product) {
			if($wholesale == 1) {
				$product->price = $product->wholesale_price;
			}

			foreach ($array as $id => $count) {
				if($product->id == $id) {
					$product->count = $count;
					$total += $product->price*$product->count;
				}
			}
		}

		return [$products, $total];
	}


	public static function getMaxBrendPrice($brendId) {
		return DB::table('products')->where('brend_id', $brendId)->max('price');
	}



	public static function getAvailByQuantity($quantity) {

		if($quantity == 0) {
			$result = "Нет в наличии";
		}

		if($quantity == 1 || $quantity == 2) {
			$result = "Заканчивается";
		}


		if($quantity > 2) {
			$result = "Есть в наличии";
		}


		return $result;

	}

	public static function getAttributesComp($compProductIds) {
		$products = DB::table('products')
		->select('products.*', 'images.url as image')
		->leftjoin('images', 'images.product_id', '=', 'products.id')
		->groupBy('products.id')
		->whereIn('products.id', $compProductIds)->get();


		$attrsIds = Attribute::getByProductsIds($compProductIds); // Все аттрибуты, которые используются в сравнении

		foreach ($products as $product) {
			$prAttrs = DB::table('product_attrs_value')->where('product_id', $product->id)->get(); // атрибуты текущего продукта

			$product->avail = self::getAvailByQuantity($product->quantity);

			foreach ($attrsIds as  $attrId) {
				$flag = 0;
				foreach ($prAttrs as $prAttr) { // атрибуты текущего продукта
					if($prAttr->attribute_id == $attrId) {
						$flag = 1;
					}
				}

				if($flag == 1) {
					$value = DB::table("product_attrs_value")
					->where('attribute_id', $attrId)->where('product_id', $product->id)->value('value');

					$product->attrs[$attrId] = $value;
				} else {
					$product->attrs[$attrId] = '-';
				}
			}

		}

		return $products;
	}

	public static function setComp($products, $compListIds) {
		if(empty($compListIds)) {
			foreach ($products as $product) {
				$product->comp = 0;
			}
		} else {
			foreach ($products as $product) {
				if(in_array($product->id, $compListIds)) {
					$product->comp = 1;
				} else {
					$product->comp = 0;
				}

			}
		}

		return $products;
	}

	public static function searchAdmin($name, $brend_id, $category_id, $group) {
		if($name == '') {
			$query = DB::table('products')->select('products.*', 'categories.name as category')
			->leftjoin('categories', 'products.category_id', '=', 'categories.id');
		} else {
			$query = Product::where('products.name', 'LIKE', '%' . $name .'%')->select('products.*', 'categories.name as category')
			->leftjoin('categories', 'products.category_id', '=', 'categories.id');
		}


		if($brend_id) {
			$query->where('products.brend_id', $brend_id);
		}


		if($category_id) {
			$query->where('products.category_id', $category_id);
		}

		if($group) {
			$query->where('products.group', $group);
		}

		$query->orderBy('group');

		$products = $query->paginate(50);

		return $products;
	}


	public static function updateByArray($products) {

		foreach ($products as $product) {
			$item = DB::table('products')->where('code', $product['code'])->first();

			if($item) { // Если товар уже есть то обновляем его
				if($item->no1c) {
					DB::table('products')->where('code', $product['code'])->update([
						'price' => $product['price'],
						'group' => $product['group'],
						'article' => $product['article'],
						'quantity' => $product['count'],
						'wholesale_price' => $product['priceWholesale'],
						'url' => $product['url']
						]);
				} else {
					DB::table('products')->where('code', $product['code'])->update([
						'name' => $product['name'],
						'article' => $product['article'],
						'group' => $product['group'],
						'price' => $product['price'],
						'quantity' => $product['count'],
						'wholesale_price' => $product['priceWholesale'],
						'url' => $product['url']
						]);
				}

			} else { // Если нету то создаем новый
				DB::table('products')->insert([
					'article' => $product['article'],
					'code' => $product['code'],
					'name' => $product['name'],
					'price' => $product['price'],
					'no1c' => 1,
					'quantity' => $product['count'],
					'group' => $product['group'],
					'wholesale_price' => $product['priceWholesale'],
					'active' => 1,
					'active_wholesale' => 1,
					'url' => $product['url']
					]);
			}
		}


		return 1;
	}


	public static function setNewProducts() {
		DB::table('products')->update(['new' => 0]);
		DB::statement('UPDATE products SET new = 1 ORDER BY id  DESC LIMIT 56');
	}

	public static function hasProductsImages($products) {
		foreach ($products as $product) {
			$has = DB::table('images')->where('product_id', $product->id)->count();

			if($has) {
				$product->hasImage = 1;
			} else {
				$product->hasImage = 0;
			}
		}

		return $products;
	}


	public static function groups() {
		return DB::select('SELECT DISTINCT `group` FROM products');
	}


}
