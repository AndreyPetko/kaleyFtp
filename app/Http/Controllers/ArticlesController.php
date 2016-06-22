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

class ArticlesController extends Controller {

	public function index() {
		$articles = Article::getItems();
		$breadcrumbs = ['/articles' => 'Статьи'];
		return view('site.articles.list')->with('articles', $articles)->with('breadcrumbs', $breadcrumbs);
	}

	public function getArticle($url) {
		$article = Article::getByUrl($url);
		$otherArticles = Article::getOther();
		$breadcrumbs = ['/articles' => 'Статьи', '/article' => $article->name];
		return view('site.articles.single')->with('article', $article)->with('otherArticles', $otherArticles)->with('breadcrumbs', $breadcrumbs);
	}
}