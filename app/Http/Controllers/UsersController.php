<?php

namespace App\Http\Controllers;


use App\User;
use Request;
use Redirect;
use App\Wishlist;
use App\Comparison;
use App\Order;
use App\Cart;
use Auth;

class UsersController extends Controller {

	public function __construct() {
		$this->middleware('isAdmin');
	}

	public function getIndex() {
		$users = User::getRetail();
		return view('admin.users.usersList')->with('users', $users);
	}

	public function postIndex() {
		$query = Request::input('query');

		$users = User::getByQuery($query,  'retail');

		return view('admin.users.usersList')->with('users', $users);
	}


	public function postDelete() {
		$request = Request::all();
		$id = $request['userId'];
		User::deleteItem($id);

		//Очистить список желаний
		Wishlist::clearUserList($id);

		//Очистить список сравнений
		Comparison::clearUserList($id);

		//Очистить заказы
		Order::deleteUserItems($id);

		//Очистить корзину
		Cart::clearUserList($id);

		return Redirect::back();
	}


	public function getWholesalers() {
		$users = User::getWholesalers();
		return view('admin.users.wholesalers')->with('users', $users);
	}


	public function postWholesalers() {
		$query = Request::input('query');
		$users = User::getByQuery($query, 'wholesaler');

		return view('admin.users.wholesalers')->with('users', $users);
	}


	public function getMakeWholesaler($id) {
		User::makeWholesaler($id);
		return Redirect::back();
	}

	public function getSingleEdit($id) {
		$user = User::find($id);
		return view('admin.users.userEdit')->with('user', $user);
	}

	public function postSingleEdit($id) {
		$request = Request::all();
		unset($request['_token']);

		$user = User::find($id);
		$user->update($request);

		if($user->role == 'wholesaler') {
			return Redirect::to('admin/users/wholesalers');
		}

		return Redirect::to('/admin/users');
	}
}
