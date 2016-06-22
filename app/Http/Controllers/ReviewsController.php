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


class ReviewsController extends Controller {

	public function __construct() {
		$this->middleware('isAdmin');
	}


	public function getIndex() {
		$reviews = Review::getItems();
		$paginateInfo = Paginate::getInfo($reviews);

		Review::setReaded();
		return view('admin.feedback.reviews.reviewsList')->with('reviews', $reviews)->with('paginateInfo', $paginateInfo);
	}

	public function postReviewDelete() {
		$id = Request::input('review_id');
		$review = Review::find($id);
		$review->delete();
		return Redirect::back();
	}

}