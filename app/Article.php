<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	protected $table = 'articles';
	protected $fillable = ['name', 'description', 'url', 'text', 'created_at', 'image', 'previewText'];



	public static function deleteItem($id) {
		return DB::table('articles')->where('id', $id)->delete();
	}

	public static function updateItem($id, $request) {
		return DB::table('articles')->where('id', $id)->update($request);
	}

	public static function getItems() {
		return DB::table('articles')->orderBy('id', 'desc')->paginate(20);
	}

	public static function getByUrl($url) {
		return DB::table('articles')->where('url', $url)->first();
	}

	public static function getOther() {
		return DB::table('articles')->orderBy('id', 'desc')->get();
	}

}