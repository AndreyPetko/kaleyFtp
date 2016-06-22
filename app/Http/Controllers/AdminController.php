<?php

namespace App\Http\Controllers;

use Request;
use App\Product;
use App\Menu;
use Redirect;
use Session;
use DB;
use App\Feedback;
use App\MyDate;
use App\Category;
use App\Subcategory;
use App\Helper;
use App\Attribute;
use Input;
use App\Image;
use App\Brend;
use App\Intake;
use App\Paginate;
use Mail;
use Auth;
use App\Review;
use App\SendMail;
use App\User;
use App\Order;

class AdminController extends Controller {

	public function __construct() {
		$this->middleware('isAdmin');
		$this->request = Request::all();
		unset($this->request['_token']);
	}

	public function getIndex() {
		if(Auth::user()->role == 'admin') {
			$type = 'retail';
		} else {
			$type = 'wholesaler';
		}

		$countNewCallbacks = Feedback::getNotReadedCallbacks();
		$countNewOrders = Order::getNotReaded($type);

		$countUsers= User::getCount(Auth::user()->role);


		return view('admin.index', compact('countNewCallbacks', 'countNewOrders', 'countUsers'));
	}

	public function getProducts(){
		$filter = $_GET;

		if(isset($_GET['search'])) {
			$name = strip_tags($_GET['search']);
			$brendId = strip_tags($_GET['brendId']);
			$categoryId = strip_tags($_GET['categoryId']);
			$group = strip_tags($_GET['group']);
			$products = Product::searchAdmin($name, $brendId, $categoryId, $group);
		} else {
			$products = Product::orderBy('group')->paginate(20);
		}


		$products = Product::hasProductsImages($products);

		$brends = Brend::all();
		$categories = Category::all();

		$groups = Product::groups();

		return view('admin.products.productsList', compact('products', 'brends', 'categories', 'groups', 'filter'));
	}

	public function getProductAdd() {
		$brends = Brend::all();
		$categories = Category::all();
		return view('admin.products.product-add')->with('categories', $categories)->with('brends', $brends);
	}

	public function postProductDelete() {
		$id = Request::input('product_id');
		Product::deleteById($id);
		return Redirect::to('/admin/products');
	}

	public function getProductUpdate($id) {
		$data['url'] =  Request::server('HTTP_REFERER');
		$data['brends'] = Brend::all();
		$data['product'] = Product::where('id', $id)->first();
		$data['subcategories'] = Product::getSubcategoriesWithMark($id);

		if($data['product']->category_id != 0) {
			$data['attributes'] = Attribute::getCategoryItemsWithProductValues($data['product']);
		} else {
			$data['attributes'] = Product::getProductAttributes($data['product']->id);
		}

		$data['categories'] = Category::all();
		$data['images'] = Product::getImagesById($id);

		return view('admin.products.product-edit', $data);
	}

	public function postProductUpdate($id) {
		$url = $this->request['redirect_url'];
		unset($this->request['redirect_url']);
		if(isset($this->request['active'])) {
			$this->request['active'] = 1;
		} else {
			$this->request['active'] = 0;
		}

		if(isset($this->request['active_wholesale'])) {
			$this->request['active_wholesale'] = 1;
		} else {
			$this->request['active_wholesale'] = 0;
		}

		if(isset($this->request['no1c'])) {
			$this->request['no1c'] = 1;
		} else {
			$this->request['no1c'] = 0;
		}

		Product::updateItem($this->request, $id);
		return Redirect::to($url);
	}


	public function postProductAdd() {


		if(isset($this->request['active'])) {
			$this->request['active'] = 1;
		} else {
			$this->request['active'] = 0;
		}


		if(isset($this->request['active_wholesale'])) {
			$this->request['active_wholesale'] = 1;
		} else {
			$this->request['active_wholesale'] = 0;
		}

		if(isset($this->request['no1c'])) {
			$this->request['no1c'] = 1;
		} else {
			$this->request['no1c'] = 0;
		}

		Product::addItem($this->request);

		return redirect('/admin/products')->with('name', $this->request['name']);
	}

	public function getSearchProduct() {
		$name =  strip_tags($_GET['name']);
		$brend_id =  strip_tags($_GET['brendId']);
		$category_id =  strip_tags($_GET['categoryId']);
		$group =  strip_tags($_GET['group']);

		$products = Product::searchAdmin($name, $brend_id, $category_id, $group);

		$json_products = json_encode($products);
		return $json_products;
	}

	public function getFeedback() {

		if(Auth::user()->role == 'admin') {
			$type = 'retail';
		} else {
			$type = 'wholesaler';
		}

		$feedbackList = Feedback::getFeedbacks($type);
		$countFeedbacks = Feedback::getCountFeedback($type);


		$paginateInfo = Paginate::getInfo($feedbackList);

		foreach ($feedbackList as $feedbackItem) {
			$feedbackItem->date = MyDate::change($feedbackItem->created_at);
		}
		return view('admin.feedback.feedback')->with('feedbackList', $feedbackList)
		->with('countFeedbacks', $countFeedbacks)->with('paginateInfo', $paginateInfo);
	}


	public function getFeedbackAnswer($id) {
		$feedback = Feedback::find($id);
		return view('admin.feedback.answer')->with('feedback', $feedback);
	}

	public function postFeedbackAnswer($id) {
		$feedback = Feedback::find($id);

		$email = $feedback->email;


		if($feedback->user_type == 'retail') {
			$fromEmail = 'petko00@mail.ua';
		} else {
			$fromEmail = 'ander@admin.com';
		}

		Mail::send('emails.empty', ['text' => $this->request['message']], function($message) use ($email,$fromEmail)
		{
			$message->from($fromEmail, 'kaleydoskop@admin.com');
			$message->to($email, 'kaleydoskop@admin.com')->subject('Ответ на обратную связь');
		});


		return Redirect::to('/admin/feedback');
	}


	public function getCommentAnswer($id) {
		$review = Review::find($id);
		return view('admin.feedback.comment-answer')->with('review', $review);
	}


	public function postCommentAnswer() {
		$this->request['name'] = Auth::user()->name;

		Review::create($this->request);

		return Redirect::to('/admin/reviews');
	}

	public function getCallbacks() {
		Feedback::setCallbacksReaded();
		$feedbackList = Feedback::getCallbacks();

		$paginateInfo = Paginate::getInfo($feedbackList);

		$countFeedbacks = Feedback::getCountCallbacks();

		foreach ($feedbackList as $feedbackItem) {
			$feedbackItem->date = MyDate::change($feedbackItem->created_at);
		}
		return view('admin.feedback.feedback')->with('feedbackList', $feedbackList)
		->with('countFeedbacks', $countFeedbacks)->with('paginateInfo', $paginateInfo)
		->with('callbacks', 1);
	}


	public function getCallbackDone($callback_id) {
		Feedback::setCalled($callback_id);
		return Redirect::back();
	}

	public function postFeedbackDelete() {
		Feedback::deleteItem($this->request['review_id']);

		return Redirect::back();
	}

	public function getSitemenu() {
		$menu = Menu::all();
		return view('admin.other.sitemenu')->with('menu', $menu);
	}

	public function postInsertMenuItem(Menu $menuItem) {
		$menuItem->create($this->request);
	}

	public function getCategories() {
		$categories = Category::all();
		return view('admin.categories.categoryList')->with('categories', $categories);
	}


	public function getSubcategories() {
		$categories = Category::all();
		$subcategories = DB::select("SELECT `subcategories`.*,`categories`.name as catName
			FROM `subcategories` LEFT JOIN `categories` ON `subcategories`.category_id = `categories`.id");
		return view('admin.categories.subcategoryList')->with('subcategories', $subcategories)->with('categories', $categories);
	}



	public function postAdd($name,$redirect = 'back') { 
		DB::table($name)->insert($this->request);

		if($redirect == 'back') {
			return Redirect::back();
		} else {
			return Redirect::to('admin/' . $redirect);
		}
	}

	public function getCategorySubcats() {
		$subcategories =  Subcategory::where('category_id', $_GET['id'])->orderBy('name')->get();
		return json_encode($subcategories);
	}

	public function getCategoryAttributes() {
		$category_id = (int)$_GET['id'];
		$attributes =  Attribute::getAttributesByCategory($category_id);
		return json_encode($attributes);
	}


	public function getAttributes() {
		$attributes = Attribute::all();

		return view('admin.categories.attributeList')->with('attributes', $attributes);
	}


	public function getCategoryAdd() {
		$attributes = Attribute::all();
		return view('admin.categories.category-add')->with('attributes', $attributes);
	}


	public function postCategoryAdd(Category $category) {
		if(!empty($this->request['image'])) {
			$this->request['image'] = Image::addImagesToFolder($this->request['image'], 'category');
		} else {
			$this->request['image'] = '';
		}

		$insert = $this->request;
		unset($insert['_token']);
		unset($insert['attributes']);
		$category_id = $category->create($insert)->id;


		if(isset($this->request['attributes'])) {
			foreach ($this->request['attributes'] as $value) {
				DB::table('category_attr')->insert(
					['category_id' => $category_id, 'attribute_id' => $value]
					);
			}
		}
		return Redirect::to('/admin/categories');
	}

	public function postDeleteImage(){
		$success = 0;
		$id = (int)$_POST['id'];
		$del = Image::deleteItem($id);

		if($del) {
			$success = 1;
		}

		return $success;
	}


	public function getSetBrendThread($brend_id,$value) {
		Brend::setThread($brend_id,$value);
		return Redirect::back();
	}

	public function getBrends() {
		$brends = Brend::all();
		return view('admin.brends.list')->with('brends', $brends);
	}

	public function getBrendAdd() {
		return view('admin.brends.add');
	}

	public function postBrendAdd() {
		if(!empty($this->request['logo'])) {
			$this->request['logo'] = Image::addImagesToFolder($this->request['logo'], 'brends');
		}
		Brend::create($this->request);
		return Redirect::to('/admin/brends');
	}

	public function postBrendDelete() {
		$brend_id = $_POST['brend_id'];
		Brend::find($brend_id)->delete();
		return Redirect::back();
	}

	public function getUpdateBrend($brend_id) {
		$brend = Brend::find($brend_id);
		return view('admin.brends.edit')->with('brend', $brend);
	}

	public function postUpdateBrend($brend_id) {
		if(isset($this->request['logo'])) {
			$this->request['logo'] = Image::addImagesToFolder($this->request['logo'], 'brends');
		}
		Brend::Where('id', $brend_id)->update($this->request);
		return Redirect::to('/admin/brends');
	}


	public function postDeleteAttr($attributeId) {
		Attribute::deleteItem($attributeId);
		return Redirect::back();
	}

	public function getChangeAttribute(){
		Attribute::updateItem($this->request);
		return Redirect::back();
	}

	public function postSubcategoryDelete($subcategoryId) {
		Subcategory::deleteById($subcategoryId);
		return Redirect::back();
	}

	public function getAjaxSubcategoryByIdAndCatlist() {
		$id = (int)$_GET['subcatid'];
		$subcategory = Subcategory::find($id);

		return $subcategory;
	}

	public function getChangeSubcategory() {
		Subcategory::updateItem($this->request);
		return Redirect::back();
	}

	public function getCategoryEdit($category_id) {
		$category = Category::find($category_id);
		$attributes = Attribute::getWithCategoryMark($category_id);

		return view('admin.categories.category-edit')->with('category', $category)->with('attributes', $attributes);
	}

	public function postCategoryEdit($category_id) {


		if(isset($this->request['image'])) {
			$category = Category::find($category_id);
			Image::deleteCategoryImage($category);
			$this->request['image'] = Image::addImagesToFolder($this->request['image'], 'category');
		}



		$result = Category::updateItem($category_id, $this->request);

		if(!$result) {
			echo "Ошибка при обновлении";
			die();
		}

		return Redirect::to('/admin/categories');
	}


	public function postDeleteCategory($category_id) {
		Category::deleteItem($category_id);
		return Redirect::back();
	}

	public function getWithProduct($product_id) {
		$currentProduct = Product::find($product_id);
		$withIds = Product::getWithIds($product_id);

		if(!$withIds) {
			$products = [];
			$notWithProducts = Product::allWithOutOne($product_id);
		} else {
			$products = Product::getByArrayId($withIds);
			$withIds[] = $product_id; // Чтобы текущий товар нельзя было добавить самому себе
			$notWithProducts = Product::getWithOut($withIds);
		}

		return view('admin.products.product-with')
		->with('products', $products)
		->with('notWithProducts', $notWithProducts)
		->with('currentProduct', $currentProduct);
	}


	public function postWithAdd() {
		$product_id = Request::input('product_id');
		$with_product_id = Request::input('with_product_id');

		$count = Product::withCount($product_id);

		if($count == 4) {
			return redirect()->back()->with('status', 'error');
		}

		Product::withAdd($product_id, $with_product_id);
		return redirect()->back()->with('status', 'success');
	}

	public function postWithDelete() {
		$product_id = Request::input('product_id');
		$with_product_id = Request::input('with_product_id');
		Product::withDelete($product_id, $with_product_id);
		return Redirect::back();
	}

	public function getIntake() {
		$intakes = Intake::getAll();
		return view('admin.intake.list')->with('intakes', $intakes);
	}


	public function getIntakeSingle($product_id) {

		$intake = Intake::getSingle($product_id);
		$product = Product::find($product_id);

		return view('admin.intake.single')->with('intake', $intake)->with('product', $product);
	}


	public function postIntakeDelete() {
		$product_id = Request::input('id');
		$intake = Intake::deleteItemsByProductId($product_id);

		return Redirect::back();
	}

	public function getIntakeEmailDelete($id) {
		$intake = Intake::find($id);
		$intake->delete();

		return Redirect::back();
	}

	public function getIntakeReport($product_id) {
		$intake = Intake::getSingle($product_id);
		$product = Product::find($product_id);

		foreach ($intake as $intakeItem) {
			$email = $intakeItem->email;

			Mail::send('emails.report', ['name' => $product['name']], function($message) use ($email)
			{
				$message->to($email, 'Kaleydoskop')->subject('Товар появился на сайте!');
			});
		}

		Intake::deleteItemsByProductId($product_id);

		return Redirect::back();
	}


	public function getDistribution() {
		return view('admin.distribution');
	}

	public function postDistribution() {
		$emailMessage = Request::input('message');


		$subscribers = Sendmail::getAllItems();

		foreach ($subscribers as $subscriber) {
			$email = $subscriber->email;
			$sub_id = $subscriber->id;

			Mail::send('emails.send', ['emailMessage' => $emailMessage, 'sub_id' => $sub_id], function($message) use ($email)
			{
				$message->to($email, 'Kaleydoskop')->subject('Рассылка');
			});
		}


		return Redirect::to('/admin/message/sendEmail');

	}


	public function postWholesalerDistribution() {
		$emailMessage = Request::input('message');

		$wholesalers = User::getWholesalers();

		foreach ($wholesalers as $wholesaler) {
			$email = $wholesaler->email;

			Mail::send('emails.sendWholesaler', ['emailMessage' => $emailMessage], function($message) use ($email)
			{
				$message->to($email, 'Kaleydoskop')->subject('Рассылка оптовым представителям');
			});
		}

		return Redirect::to('/admin/message/sendEmail');
	}


	public function getMessage($type) {
		if($type == 'sendEmail') {
			$message = "Вы успешно сделали рассылку сообщения";
		}

		return view('admin.message')->with('message', $message);
	}


	public function getProductSearch($product_id) {
		$search = Product::find($product_id)->search;
		return view('admin.products.product-search', compact('search'));
	}


	public function postProductSearch($product_id) {
		Product::find($product_id)->update($this->request);
		return Redirect::to('admin/products');
	}

}