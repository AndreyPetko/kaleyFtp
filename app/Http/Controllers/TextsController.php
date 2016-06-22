<?php

namespace App\Http\Controllers;

use Request;
use App\Product;
use App\Menu;
use Redirect;
use Session;
use App\Review;
use DB;
use Input;
use App\Paginate;
use App\Text;


class TextsController extends Controller {

	public function __construct() {
		$this->middleware('isAdmin');
	}


	public function getIndex() {
		$texts = Text::all();
		return view('admin.siteComponents.texts.textsList')->with('texts', $texts);
	}

	public function getTextAdd() {
		return view('admin.siteComponents.texts.textAdd');
	}

	public function postTextAdd() {
		$request = Request::all();
		unset($request['_token']);
		Text::create($request);
		return Redirect::to('/admin/texts');
	}

	public function postDelete() {
		$text_id = Request::input('text_id');
		Text::deleteItem($text_id);
		return Redirect::back();
	}

	public function getEdit($text_id) {
		$text = Text::find($text_id);
		return view('admin.siteComponents.texts.textEdit')->with('text', $text);
	}

	public function postEdit($text_id) {
		$request = Request::all();
		unset($request['_token']);
		Text::updateItem($request, $text_id);
		return Redirect::to('/admin/texts');
	}

}