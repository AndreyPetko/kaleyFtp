<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
	protected $table = 'feedbacks';
	protected $fillable = array('name','phone', 'email', 'comment', 'type', 'user_type');


	public static function getCallbacks() {
		return DB::table('feedbacks')->where('type', 'callback')->orderBy('id', 'desc')->paginate(10);
	}


	public static function getCountCallbacks() {
		return DB::table('feedbacks')->where('type', 'callback')->count();
	}



	public static function getCountFeedback($type) {
		return DB::table('feedbacks')->where('type', 'feedback')->where('user_type', $type)->count();
	}

	public static function getFeedbacks($type) {
		return self::where('type', 'feedback')->where('user_type', $type)->orderBy('id', 'desc')->paginate(10);
	}

	public static function deleteItem($id) {
		DB::table('feedbacks')->where('id', $id)->delete();
	}


	public static function setCalled($callback_id) {
		DB::table('feedbacks')->where('id', $callback_id)->update(['called' => 1]);
	}

	public static function setCallbacksReaded() {
		DB::table('feedbacks')->where('type', 'callback')->update(['readed' => 1]);
	}


	public static function getNotReadedCallbacks() {
		return DB::table('feedbacks')
		->where('type', 'callback')
		->where('readed', 0)
		->count();
	}
}
