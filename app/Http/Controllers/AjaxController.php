<?php

namespace App\Http\Controllers;
use DB;
use App\Product;
use Session;
use Cookie;
use App\MyCookie;
use App\Cart;
use App\Wishlist;
use App\Comparison;
use App\Subcategory;
use App\Order;
use App\Feedback;
use Auth;

class AjaxController extends Controller {

	public function getRecommended() {
		$click = (int)$_GET['click'];
		$recProducts = Product::getRecommended(4 + 8*$click,8);
		$recProducts = Product::setWholesalePrice($recProducts, 1);
		return json_encode($recProducts);
	}

	public function getNew() {
		$click = (int)$_GET['click'];
		$newProducts = Product::getNew(4 + 8*$click,8);
		$newProducts = Product::setWholesalePrice($newProducts, 1);
		return json_encode($newProducts);
	}



	public function getBrendProducts() {
		foreach ($_GET as $key => $value) {
			if($value  !== $_GET['brendUrl']) {
				Session::put($key, $value);
			}
		}

		return Product::getBySessionBrendFilter($_GET['brendUrl']);
	}



	public function getBrendCheckboxAdd() {
		if(!isset($_GET['attr']) || !isset($_GET['value']) ) {
			return false;
		}

		$attr = strip_tags($_GET['attr']);
		$value = strip_tags($_GET['value']);

		$attrArr = Session::get('brendFilter.' . $attr);

		if(empty($attrArr) || !in_array($value, $attrArr)) {
			Session::push('brendFilter.' . $attr, $value);
		}

		return Product::getBySessionBrendFilter($_GET['brendUrl']);
	}

	public function getBrendCheckboxDelete() {
		if(!isset($_GET['attr']) || !isset($_GET['value']) ) {
			return false;
		}

		$attr = strip_tags($_GET['attr']);
		$value = strip_tags($_GET['value']);

		$attrArr = Session::get('brendFilter.' . $attr);
		$index = array_search($value, $attrArr);

		Session::forget('brendFilter.' . $attr .'.' . $index);

		return Product::getBySessionBrendFilter($_GET['brendUrl']);
	}


	public function getCategoryProducts() {
		foreach ($_GET as $key => $value) {
			if($value  !== $_GET['categoryUrl']) {
				Session::put($key, $value);
			}
		}

		if(isset($_GET['page'])) {
			$page = (int)$_GET['page'];
		} else {
			$page = false;
		}

		return Product::getBySessionFilter($_GET['categoryUrl'],1,$page);

	}


	public function getFilterCheckboxAdd() {
		if(!isset($_GET['attr']) || !isset($_GET['value']) ) {
			return false;
		}

		$attr = strip_tags($_GET['attr']);
		$value = strip_tags($_GET['value']);

		$attrArr = Session::get('filter.' . $attr);

		if(empty($attrArr) || !in_array($value, $attrArr)) {
			Session::push('filter.' . $attr, $value);
		}

		return Product::getBySessionFilter($_GET['categoryUrl']);
	}


	public function getFilterCheckboxDelete() {
		if(!isset($_GET['attr']) || !isset($_GET['value']) ) {
			return false;
		}

		$attr = strip_tags($_GET['attr']);
		$value = strip_tags($_GET['value']);

		$attrArr = Session::get('filter.' . $attr);
		$index = array_search($value, $attrArr);

		Session::forget('filter.' . $attr .'.' . $index);

		return Product::getBySessionFilter($_GET['categoryUrl']);
	}

	public function getBrendClear() {
		Session::forget('brendFilter');
		Session::forget('aval');
		return Product::getBySessionBrendFilter($_GET['brendUrl']);
	}

	public function getFilterClear() {
		Session::forget('filter');
		Session::forget('aval');
		return Product::getBySessionFilter($_GET['categoryUrl']);
	}

	public function getAddToCart() {
		if(isset($_GET['id'])) {
			$id = (int)$_GET['id'];
		} else {
			return 0;
		}


		if(isset($_GET['count'])) {
			$count = (int)$_GET['count'];
		} else {
			$count = 1;
		}

		$cart = Cart::getInstance();
		$cart->add($id, $count);

		$product = Product::find($id);
		$name  =  $product->name;
		return json_encode($name);
	}

	public function getCartProductsAndTotal() {
		$cart = Cart::getInstance();
		$cartInfo = $cart->getProductsAndTotal();
		return $cartInfo;
	}


	public function getProductImages() {
		$id = (int)$_GET['id'];
		$images = Product::getImagesById($id);
		$productName = Product::getNameById($id);
		return [$images, $productName];
	}

	public function getDeleteCartItem() {
		if(!$_GET['id']) {
			return false;
		}

		$product_id = (int)$_GET['id'];

		$cart = Cart::getInstance();
		$cart->deleteItem($product_id);

		return 1;
	}

	public function getChangeCount() {
		$count = (int)$_GET['count'];
		$product_id =  (int)$_GET['productid'];
		$cart = Cart::getInstance();
		$cart->changeCount($product_id, $count);
		return 1;
	}


	public function getAddWish() {
		$productId = (int)$_GET['productid'];
		$wishlistObj = Wishlist::getInstance();
		$result = $wishlistObj->change($productId);
		return $result;
	}

	public function getDeleteWish() {
		$productid = (int)$_GET['productid'];
		$wishlistObj = Wishlist::getInstance();
		$result = $wishlistObj->delete($productid);
		return 1;
	}

	public function getChangeComparison() {
		$id = (int)$_GET['productid'];
		$compObj = Comparison::getInstance();
		$result = $compObj->change($id);
		return $result;
	}

	public function getSubcategoriesByCategoryId() {
		$id = (int)$_GET['id'];
		$subcategories = Subcategory::getByCategoryId($id);

		return $subcategories;
	}

	// На странице категории делает фильтрацию по бренду
	public function getFilterBrendAdd() {
		$id = (int)$_GET['id'];
		Session::push('brends', $id );

		return Product::getBySessionFilter($_GET['categoryUrl']);
	}

	public function getFilterBrendDelete() {
		$id = (int)$_GET['id'];
		$brends = Session::get('brends');
		$key = array_search($id, $brends);
		Session::forget('brends.' . $key);


		return Product::getBySessionFilter($_GET['categoryUrl']);

	}

	public function getFilterSubcatAdd() {
		$id = (int)$_GET['id'];
		Session::push('subcat', $id );

		return Product::getBySessionBrendFilter($_GET['brendUrl']);
	}

	public function getFilterSubcatDelete() {
		$id = (int)$_GET['id'];
		$brends = Session::get('subcat');
		$key = array_search($id, $brends);
		Session::forget('subcat.' . $key);

		return Product::getBySessionBrendFilter($_GET['brendUrl']);

	}

	public function getNewEvents() {
		$newCallbacks = Feedback::getNotReadedCallbacks();
		$newOrders = Order::getNotReaded(Auth::getRole());

		return [$newCallbacks, $newOrders];
	}

	public function getChangeAval() {
		if(!isset($_GET['aval'])) {
			return false;
		}

		Session::put('aval', $_GET['aval']);

		return Product::getBySessionFilter($_GET['categoryUrl']);
	}

}