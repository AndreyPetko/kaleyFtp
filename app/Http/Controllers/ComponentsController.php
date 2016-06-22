<?php

namespace App\Http\Controllers;
use DB;
use App\Slide;
use Request;
use Redirect;
use App\Product;
use App\File;
use App\Keyval;

class ComponentsController extends Controller {

	public function __construct() {
		$this->middleware('isAdmin');
		$this->request = Request::all();
		unset($this->request['_token']);
	}

	public function getIndex() {
		return view('admin.siteComponents.componentsList');
	}

	public function getMainSlider() {
		$slides = Slide::getMainSlides();
		return view('admin.siteComponents.mainSlider.slidesList')->with('slides', $slides);
	}

	public function getSlideAdd($sliderName) {
		return view('admin.siteComponents.mainSlider.slideAdd')->with('sliderName', $sliderName);
	}

	public function postSlideAdd($sliderName) {
		$request = Request::all();
		unset($request['_token']);
		Slide::addItem($request, $sliderName);
		return Redirect::to('/admin/components/main-slider');
	}

	public function postSlideDelete() {
		$slide_id = Request::input('slide_id');
		Slide::deleteItem($slide_id);
		return Redirect::back();
	}

	public function getSlideEdit($slide_id) {
		$slide = Slide::find($slide_id);
		return view('admin.siteComponents.mainSlider.slideEdit')->with('slide', $slide);
	}

	public function postSlideEdit($slide_id) {
		$request = Request::all();
		unset($request['_token']);
		Slide::updateItem($request, $slide_id);
		return Redirect::to('/admin/components/main-slider');
	}


	public function getFiles() {
		$files = File::All();
		return view('admin.files')->with('files', $files);
	}

	public function postFiles() {
		$request = Request::all();

		if(isset($request['file'])) {
			$name = $request['file']->getClientOriginalName();
			$request['file']->move('download', $name);
			File::create(['url' => '/download/' . $name, 'name' => $name]);
		}

		return Redirect::back();
	}

	public function getFileDelete($fileId) {
		File::deleteItem($fileId);

		return Redirect::back();
	}




	public function getRecommendedList() {
		$products = Product::getRecommended();
		$notRecProducts = Product::getNotRecommended();
		return view('admin.siteComponents.recommended.list')->with('products', $products)->with('notRecProducts', $notRecProducts);
	}

	public function postRecommendedAdd() {
		$product_id = Request::input('product_id');
		Product::setRecommended($product_id, 1);
		return Redirect::back();
	}

	public function postRecommendedDelete() {
		$product_id = Request::input('product_id');
		Product::setRecommended($product_id, 0);
		return Redirect::back();
	}


	public function getContactsWholesales() {
		$contacts = Keyval::getWholesaleContacts();
		return view('admin.siteComponents.contacts.contacts', compact('contacts'));
	}

	public function postContactsWholesales() {
		Keyval::updateContacts($this->request, 'w');
		return Redirect::to('/admin/components');
	}


	public function getContactsRetails() {
		$contacts = Keyval::getRetailContacts();
		return view('admin.siteComponents.contacts.contacts', compact('contacts'));
	}


	public function postContactsRetails() {
		Keyval::updateContacts($this->request, 'r');
		return Redirect::to('/admin/components');
	}

	public function getDeliveryPrices() {
		$prices = Keyval::getDeliveryPrices();
		return view('admin.siteComponents.delivery-prices', compact('prices'));
	}

	public function postDeliveryPrices() {
		Keyval::updatePrices($this->request);
		return Redirect::to('/admin/components');
	}



}