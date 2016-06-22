<?php


namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class File extends Model {
	protected $table = 'files';
	protected $fillable = ['url', 'name'];
	public $timestamps = false;


	public static function deleteItem($fileId) {
		$file = self::find($fileId);

		unlink(public_path() .  $file->url);

		DB::table('files')->where('id', $fileId)->delete();
	}

}