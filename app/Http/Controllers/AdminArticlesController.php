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
use App\Article;
use App\Image;

class AdminArticlesController extends Controller {

	public function __construct() {
		$this->middleware('isAdmin');
	}


	public function getIndex() {
		$articles = Article::getItems();
		return view('admin.articles.list')->with('articles', $articles);
	}

	public function getAdd() {
		return view('admin.articles.add');
	}

	public function postAdd() {
		$request = Request::all();
		unset($request['_token']);

		if(isset($request['image'])) {
			$request['image'] =  Image::addImagesToFolder($request['image'], 'articles');
		}

		Article::create($request);

		return Redirect::to('/admin/articles');
	}

	public function postDelete() {
		$id = Request::input('id');
		Article::deleteItem($id);
		return Redirect::back();
	}

	public function getEdit($id) {
		$article = Article::find($id);
		return view('admin.articles.edit')->with('article', $article);
	}

	public function postEdit($id) {
		$request = Request::all();
		unset($request['_token']);

		if(isset($request['image'])) {
			$request['image'] =  Image::addImagesToFolder($request['image'], 'articles');
		}

		Article::updateItem($id, $request);

		return Redirect::to('/admin/articles');
	}

}