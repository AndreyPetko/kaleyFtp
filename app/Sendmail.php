<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class SendMail extends Model
{
	protected $table = 'sendmail';
	protected $fillable = ['email', 'user_id'];
	public $timestamps = false;


	public static function isSub($id) {
		$el = DB::table('sendmail')->where('user_id', $id)->get();

		if($el) {
			$sub = 1;
		} else {
			$sub = 0;
		}

		return $sub;
	}

	public static function deleteItem($field, $value) {
		DB::table('sendmail')->where($field, $value)->delete();
	}


	public static function getAllItems() {
		return DB::table('sendmail')->distinct()->where('email', '!=', '')->get();
	}

	public static function getAllEmails() {
		return DB::table('sendmail')->distinct()->where('email', '!=', '')->lists('email');
	}


	public static function subEmail($email, $user_id) {
		$item = DB::table('sendmail')->where('email', $email)->first();

		if(!$item) {
			SendMail::create(['email' => $email, 'user_id' => $user_id]);
		} else {

			if($item->user_id == '0' && $user_id != 0) {
				DB::table('sendmail')->where('email', $email)->update(['user_id' => $user_id]);
			}

		}

	}

}