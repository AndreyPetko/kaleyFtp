<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Text extends Model {
	protected $table = 'texts';
	protected $fillable = ['text', 'alias'];
	public $timestamps = false;


	public static function deleteItem($text_id) {
		DB::table('texts')->where('id', $text_id)->delete();
	}


	public static function getItem($alias) {
		return DB::table('texts')->where('alias', $alias)->value('text');
	}

	public static function updateItem($update, $text_id) {
		DB::table('texts')->where('id', $text_id)->update($update);
	}

}