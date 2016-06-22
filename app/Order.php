<?php

namespace App;
use DB;
use App\MyDate;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Order extends Model {

	public static function getInstance($type) {
		// 0 = обычный заказ
		// 1 = быстрый заказ
		if($type == 0) {
			return new BasicOrder();
		}

		if($type == 1) {
			return new FastOrder();
		}
	}




	public static function getItem($id) {
		$order =  DB::table('orders')->where('orders.id', $id)->first();

		// $order = self::changePaymentAndDelivery($order);
		// $order->delivery_dt = MyDate::change($order->delivery_dt);
		$order->human_dt  = MyDate::change($order->delivery_dt);

		return $order;
	}


	public static function getByFilter($get) {
		$query = DB::table('orders')->select('orders.*')->orderBy('orders.id', 'desc')->where('status', '!=', 'Выполнен');

		if(isset($get['status']) && $get['status'] != 'Все статусы') {
			$query->where('status', $get['status']);
		}

		if(isset($get['type']) && $get['type'] != 2) {
			$query->where('fast', $get['type']);
		}

		$query->leftjoin('users', 'users.id', '=', 'orders.user_id');


		if(Auth::user()->role == 'ander') {
			$query->where('users.role', '=', 'wholesaler');
			$query->orWhere('users.role', '=', 'ander');
		} else {
			$query->whereRaw("users.role != 'wholesaler' && users.role != 'ander' OR orders.user_id = 0");
		}

		$orders = $query->paginate(20);

		foreach ($orders as $order) {
			$order->delivery_dt = MyDate::historyPageDt($order->delivery_dt);
		}

		return $orders;
	}


	public static function changePaymentAndDelivery($order) {

		if($order->delivery_type == 'nova poshta') {
			$order->delivery_type = 'Новая почта';
		}

		if($order->delivery_type == 'sam') {
			$order->delivery_type = 'Самовывоз';
		}

		if($order->delivery_type == 'kuryer') {
			$order->delivery_type = 'Курьер';
		}

		if($order->delivery_type == 'ukr poshta') {
			$order->delivery_type = 'Укрпочтой';
		}

		if($order->delivery_type == 'empty') {
			$order->delivery_type = 'Не указано';
		}


		if($order->payment_type == 'empty') {
			$order->payment_type = 'Не указано';
		}

		if($order->payment_type == 'privat') {
			$order->payment_type = 'На карту Приват Банка';
		}

		if($order->payment_type == 'nal') {
			$order->payment_type = 'Наличными курьеру';
		}

		if($order->payment_type == 'visa') {
			$order->payment_type = 'Оплата Visa/Mastercart';
		}

		return $order;
	}


	public static function getItemProducts($id) {
		return DB::table('orders_products')->where('order_id', $id)
		->select('orders_products.*', 'products.url','products.article', 'images.url as image')
		->leftjoin('products', 'orders_products.product_id', '=', 'products.id')
		->leftjoin('images', 'images.product_id', '=' , 'products.id')
		->groupBy('products.id')
		->get();
	}


	public static function getTotalPrice($id) {
		$orderProducts = DB::table('orders_products')->where('order_id', $id)->get();

		$total = 0;
		foreach ($orderProducts as $orderProduct) {
			$total += $orderProduct->product_price * $orderProduct->product_count;
		}

		return $total;
	}

	public static function changeStatus($orderId, $orderStatus) {
		DB::table('orders')->where('id', $orderId)->update(['status' => $orderStatus]);
	}

	public static function getArchive() {
		$query = DB::table('orders')->select('orders.*')->where('status', 'Выполнен');

		$query->leftjoin('users', 'users.id', '=', 'orders.user_id');


		if(Auth::user()->role == 'ander') {
			$query->where('users.role', '=', 'wholesaler');
		} else {
			$query->whereRaw("users.role != 'wholesaler' OR orders.user_id = 0 AND orders.status = 'Выполнен'");
		}

		$orders = $query->paginate(10);

		return $orders;
	}

	public static function setDeclarationNumber($orderId, $declarationNumber) {
		DB::table('orders')->where('id', $orderId)->update(['declarationNumber' => $declarationNumber]);
	}

	public static function deleteItem($orderId) {
		// Удаляем все привязанные товары
		DB::table('orders_products')->where('order_id', $orderId)->delete();

		// Удаляем сам заказ
		DB::table('orders')->where('id', $orderId)->delete();
	}

	public static function deleteUserItems($userId) {
		$listIds = DB::table('orders')->where('user_id', $userId)->lists('id');
		foreach ($listIds as $id) {
			self::deleteItem($id);
		}
	}


	public static function setDeliveryLink($delivery_type, $declarationNumber) {
		if($delivery_type == 'nova poshta') {
			$link = "https://novaposhta.ua/tracking/?cargo_number=" . $declarationNumber;
		}

		if($delivery_type == 'ukr poshta') {
			$link = "http://otsledit.com.ua/index.php?co=ukrposhta&nomer_pos=" . $declarationNumber;
		}


		if(!isset($link)) {
			$link = "";
		}


		return $link;
	}


	public static function userOrders($userId) {
		$orders = DB::table('orders')->where('user_id', $userId)->orderBy('id', 'desc')->get();
		foreach ($orders as $order) {
			$order->delivery_dt = MyDate::historyPageDt($order->delivery_dt);
			$order->products = self::getProducts($order->id);


			if($order->declarationNumber) {
				$order->delivery_link = self::setDeliveryLink($order->delivery_type, $order->declarationNumber);
			}


			$order = self::changePaymentAndDelivery($order);

		}

		return $orders;
	}

	public static function getProducts($order_id) {
		return DB::table('orders_products')->select('orders_products.*', 'images.url as image', 'products.url')->leftjoin('images', 'images.product_id', '=', 'orders_products.product_id')->leftjoin('products', 'orders_products.product_id', '=', 'products.id')
		->where('order_id', $order_id)->get();
	}

	public static function userTotalPrice($userId) {
		return DB::table('orders')->where('user_id', $userId)->sum('totalprice');
	}

	public static function userCurrentOrders($userId) {
		$orders =  DB::table('orders')->where('user_id', $userId)->get();

		foreach ($orders as $order) {
			$order->delivery_dt = MyDate::historyPageDt($order->delivery_dt);
			$order = self::changePaymentAndDelivery($order);
		}

		return $orders;
	}

	public static function getItemsWithPaymentStatus($userId) {
		$orders = DB::table('orders')->where('user_id', $userId)->get();


		foreach ($orders as $order) {
			$order->delivery_dt = MyDate::historyPageDt($order->delivery_dt);
			$order->payment_dt = MyDate::historyPageDt($order->payment_dt);
			$order = self::changePaymentAndDelivery($order);
		}

		return $orders;
	}

	public static function setPaymentDt($orderId) {
		//Если мы не меняем с Отправлен оплачен на Выполнен
		$status = DB::table('orders')->where('id', $orderId)->value('status');

		if($status == 'Отправлен(Оплачен)') {
			return false;
		}

		// Установить payment_dt на текущее время
		DB::statement('UPDATE orders SET payment_dt = NOW() WHERE id = :orderId', [$orderId]);
	}

	public static function updateItem($request) {
		$update = $request;
		$update['address'] = $update['adress'];
		unset($update['count']);
		unset($update['adress']);
		DB::table('orders')->where('id', $update['id'])->update($update);

		foreach ($request['count'] as $product_id => $product_count) {
			if($product_count == 0) {
				DB::table('orders_products')->where('order_id', $request['id'])->where('product_id', $product_id)
				->delete();
			} else {
				DB::table('orders_products')->where('order_id', $request['id'])->where('product_id', $product_id)
				->update(['product_count' => $product_count]);
			}

		}
	}

	public static function resetTotalPrice($order_id) {
		$list = DB::table('orders_products')->where('order_id', $order_id)->lists('product_price','product_count');
		$discount = DB::table('orders')->where('id', $order_id)->value('discount');

		$totalprice = 0;
		foreach ($list as $count => $price) {
			$totalprice += $count*$price;
		}

		$totalprice  = $totalprice - $totalprice*$discount/100;

		DB::table('orders')->where('id', $order_id)->update(['totalprice' => $totalprice]);
	}

	public static function getNamesCount($id) {
		$list = DB::table('orders_products')->where('order_id', $id)->lists('product_count');

		$total = 0;
		foreach ($list as $count) {
			$total += $count;
		}

		return $total;
	}


	public static function addProductToOrder($request) {
		$count = DB::table('orders_products')->where('order_id', $request['order_id'])->where('product_id', $request['product_id'])->value('product_count');

		if($count) {
			$count = $count + $request['count'];
			DB::table('orders_products')->where('order_id', $request['order_id'])->where('product_id', $request['product_id'])->update(['product_count' => $count]);
		} else {
			$product = DB::table('products')->where('id', $request['product_id'])->first();
			DB::table('orders_products')->insert(
				[
				'product_name' => $product->name, 'product_count' => $request['count'],
				'order_id' => $request['order_id'],'product_price' => $product->price,
				'product_id' => $request['product_id'] 
				]
				);
		}
	}


	public static function getTotalForUser($user_id) {
		return DB::table('orders')->where('user_id', $user_id)->sum('totalprice');
	}

	public static function setReaded($type) {
		if($type == 'retail') {
			DB::table('orders')->where('readed', 0)
			->leftjoin('users', 'users.id', '=', 'orders.user_id')
			->whereRaw("orders.readed = 0 AND (orders.user_id = 0  OR users.role = 'retail' OR users.role = 'admin')")
			->update(['readed' => 1]);
		} else {
			DB::table('orders')->where('readed', 0)
			->leftjoin('users', 'users.id', '=', 'orders.user_id')
			->whereRaw("orders.readed = 0 AND ( users.role = 'wholesaler' OR users.role = 'ander')")
			->update(['readed' => 1]);
		}
	}

	public static function getNotReaded($type) {
		if($type == 'retail') {
			return DB::table('orders')
			->leftjoin('users', 'users.id', '=', 'orders.user_id')
			->whereRaw("orders.readed = 0 AND (orders.user_id = 0  OR users.role = 'retail' OR users.role = 'admin')")
			->count();
		} else {
			return DB::table('orders')
			->leftjoin('users', 'users.id', '=', 'orders.user_id')
			->whereRaw("orders.readed = 0 AND ( users.role = 'wholesaler' OR users.role = 'ander')")
			->count();
		}
	}


	public static function getLast() {
		return self::orderBy('id', 'desc')->first();
	}

}