<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
	protected $table = 'slides';
	protected $fillable = ['image', 'text', 'position', 'sliderName'];
	public $timestamps = false;

	public static function getMainSlides() {
		return DB::select("SELECT * FROM `slides` WHERE sliderName = 'main'");
	}

	public static function getOrderMainSlides() {
		return DB::select("SELECT * FROM `slides` WHERE sliderName = 'main' ORDER BY position");
	}

	public static function addItem($slide, $sliderName) {
		$slide['sliderName'] = $sliderName;

		if(isset($slide['image'])) {
			$name = self::changeImage($slide['image']);
			$slide['image'] = $name;
		}

		self::create($slide);
	}

	public static function deleteItem($slide_id) {
		self::where('id', '=', $slide_id)->delete();
	}

	public static function updateItem($slide, $slide_id) {
		if(isset($slide['image'])) {
			$name = self::changeImage($slide['image']);
			$slide['image'] = $name;
		}
		self::where('id', '=', $slide_id)->update($slide);
	}


	public static function changeImage($image) {
		if(method_exists($image, 'getClientmimeType')) {
			$name = $image->getClientOriginalName();
			$image->move('slides_images', $name);
			return $name;
		}
	}

}