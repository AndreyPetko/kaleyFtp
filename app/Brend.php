<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Brend extends Model
{
	protected $table = 'brends';
	protected $fillable = ['name', 'created_at', 'logo', 'url', 'preview', 'description'];

	public static function getItemsWithLogo() {
		return DB::select("SELECT * FROM brends WHERE logo IS NOT NULL AND thread = 0");
	}

	public static function getByUrl($url) {
		return DB::table('brends')->where('url', $url)->first();
	}

	public static function getByCategoryId($category_id) {
		return DB::select('SELECT DISTINCT brends.id, brends.name FROM brends LEFT JOIN products ON products.brend_id = brends.id WHERE products.category_id = :category_id', [$category_id]);
	}

	public static function setThread($brend_id,$value) {
		DB::table('brends')->where('id', $brend_id)->update(['thread' => $value]);
	}


	public static function getNotThreads() {
		return DB::table('brends')->where('thread', 0)->get();
	}

}
