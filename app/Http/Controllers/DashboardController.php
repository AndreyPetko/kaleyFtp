<?php

namespace App\Http\Controllers;


use Request;
use Redirect;
use Auth;
use App\Order;
use View;
use App\Wishlist;
use App\User;
use App\Sendmail;



class DashboardController extends Controller {

	public function __construct() {

		View::composer('dashboard.dashboardLayout', function($view){
			$userId = Auth::user()->id;
			$orders = Order::userOrders($userId);
			$userTotalPrice = Order::userTotalPrice($userId);
			$view->with('userTotalPrice', $userTotalPrice);

			$lastWish = Wishlist::getLastWish(2);
			$view->with('lastWish', $lastWish);
		});

		$this->middleware('auth');
	}

	public function getIndex() {
		$breadcrumbs = ['/dashboard' => 'Личный Кабинет'];
		$sub = Sendmail::isSub(Auth::user()->id);

		return view('dashboard.index')->with('breadcrumbs', $breadcrumbs)->with('sub', $sub);
	}

	public function getOrdersHistory() {
		$userId = Auth::user()->id;
		$orders = Order::userOrders($userId);
		$breadcrumbs = ['/dashboard' => 'Личный Кабинет', '/dashboard/orders-history' => 'История заказов'];
		return view('dashboard.ordersHistory')->with('orders', $orders)->with('breadcrumbs', $breadcrumbs);
	}


	public function getSubscribe() {
		$id = Auth::user()->id;
		$email = Auth::user()->email;


		Sendmail::subEmail($email, $id);

		return Redirect::back();
	}


	public function getUnsubscribe() {
		$user_id = Auth::user()->id;
		Sendmail::deleteItem('user_id', $user_id);

		return Redirect::back();
	}

	public function getOrdersStatus() {
		$userId = Auth::user()->id;
		$orders = Order::userCurrentOrders($userId);
		$breadcrumbs = ['/dashboard' => 'Личный Кабинет', '/dashboard/orders-status' => 'Статусы заказов'];
		return view('dashboard.ordersStatus')->with('orders', $orders)->with('breadcrumbs', $breadcrumbs);
	}

	public function getPaymentHistory() {
		$userId = Auth::user()->id;
		$orders = Order::getItemsWithPaymentStatus($userId);
		$breadcrumbs = ['/dashboard' => 'Личный Кабинет', '/dashboard/payment-history' => 'История платежей'];
		return view('dashboard.paymentHistory')->with('orders', $orders)->with('breadcrumbs', $breadcrumbs);
	}

	public function getEditAccount() {
		return view('dashboard.editAccount');
	}

	public function postEditAccount() {
		$request = Request::all();
		unset($request['_token']);
		User::editItem($request);
		return Redirect::back();
	}

	public function getChangePassword() {
		return view('dashboard.changePassword');
	}


}