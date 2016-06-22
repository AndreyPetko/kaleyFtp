<?php

namespace App\Http\Controllers;

use App\Order;
use App\MyDate;
use Request;
use Redirect;
use App\Product;
use App\User;
use Auth;

class AdminOrdersController extends Controller {

	public function __construct() {
		$this->middleware('isAdmin');
		$this->request = Request::all();
		unset($this->request['_token']);
	}


	public function getIndex() {
		$type = Auth::getRole();
		Order::setReaded($type);
		$orders = Order::getByFilter($_GET);
		return view('admin.orders.allList')->with('orders', $orders);
	}

	public function getFast(){
		$ordersObj = Order::getInstance(1);
		$fastOrders = $ordersObj->get();


		return view('admin.orders.fastList')->with('fastOrders', $fastOrders);
	}

	public function getBasic() {
		$ordersObj = Order::getInstance(0);
		$basicOrders = $ordersObj->get();

		return view('admin.orders.basicList')->with('basicOrders', $basicOrders);
	}

	public function getSingle($id) {
		$order = Order::getItem($id);
		$products = Order::getItemProducts($id);
		$totalprice = Order::getTotalPrice($id);
		$allProducts = Product::all();

		return view('admin.orders.single')->with('order', $order)->with('products', $products)->with('totalprice', $totalprice)->with('allProducts', $allProducts);
	}

	public function postChangeStatus() {
		$request = Request::all();
		if($request['order_status'] == 'Отправлен(Оплачен)' || $request['order_status'] == 'Выполнен') {
			Order::setPaymentDt($request['order_id']);
		}

		Order::changeStatus($request['order_id'], $request['order_status']);
		return Redirect::back();
	}

	public function getArchive() {
		$orders = Order::getArchive();
		return view('admin.orders.archive')->with('orders', $orders);
	}

	public function postSetDeclarationNumber() {
		$request = Request::all();
		Order::setDeclarationNumber($request['order_id'], $request['number']);
		return Redirect::back();
	}

	public function postDelete() {
		$request = Request::all();
		Order::deleteItem($request['orderId']);
		return Redirect::back();
	}

	public function postEditItem() {
		Order::updateItem($this->request);
		Order::resetTotalPrice($this->request['id']);

		if($this->request['status'] == 'Выполнен') {
			$order = Order::find($this->request['id']);
			if($order->user_id != 0) {
				$total = Order::getTotalForUser($order->user_id);
				// User::setDiscount($total,$user_id);
				User::find($order->user_id)->setDiscount($total);
			}
		}

		return Redirect::back();
	}


	public function getPrint($id) {
		$order = Order::find($id);
		$order = Order::changePaymentAndDelivery($order);
		$products = Order::getItemProducts($id);
		$namesCount  = Order::getNamesCount($id);

		return view('print.order')->with('order', $order)->with('products', $products)->with('namesCount', $namesCount);
	}

	public function postAddProductToOrder() {
		$request = Request::all();
		unset($request['_token']);
		Order::addProductToOrder($request);

		return Redirect::back();
	}

	public function getNewOrder() {
		$products = Product::all();
		$users = User::all();

		return view('admin.orders.new')->with('products', $products)->with('users', $users);
	}


	public function postNewOrder() {
		$request = Request::all();



		if($request['user_id'] != 0) {
			$user = User::find($request['user_id']);

			if($request['name'] == '') {
				$request['name'] = $user->name;
			}

			if($request['phone'] == '') {
				$request['phone'] = $user->phone;
			}

			if($request['email'] == '') {
				$request['email'] = $user->email;
			}

			if($request['address'] == '') {
				$request['address'] = $user->address;
			}
		}






		for ($i=0; $i < count($request['products_ids']); $i++) {

			if($request['count'][$i] != 0) {
				$request['product'][$request['products_ids'][$i]] = $request['count'][$i];
			}

		}

		unset($request['count']);
		unset($request['products_ids']);
		unset($request['_token']);



		$order = Order::getInstance(0);
		$result = $order->add($request);

		return Redirect::to('/admin/orders/single/' . $result);
	}

}