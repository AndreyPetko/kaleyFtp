<?php

namespace App;
use App\SimpleImage;
use DB;
use URL;


use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
	protected $table = 'images';
	protected $fillable = ['url', 'product_id'];

	public function Product() {
		return $this->belongsTo('App\Product');
	}

	public static function deleteItem($id) {
		return DB::statement("DELETE FROM images WHERE id = :id", array($id));
	}


	public static function deleteCategoryImage($category) {
		if($category->image != '' && file_exists(public_path() . '/category_images/' . $category->image)) {
			unlink(public_path() . '/category_images/' . $category->image);
		}

		DB::table('categories')->where('id', $category->id)->update(['image' => '']);
	}

	public static function addImages($images, $product_id, $product_url, $startIndex) {


		// Переносим файлы картинок
		if(isset($images)) {
			foreach ($images as $key => $image) {
				$key = $key + $startIndex;

				if(method_exists($image, 'getClientmimeType')) {

					$name = $product_url . '_' .  $key . '.jpg';
					$images_names[] = $name;
					$image->move('product_images', $name);

					$file =  URL::to('/') . '/product_images/' . $name;

					$img = \Intervention\Image\Facades\Image::make($file);

					$x = $img->width();
					$y = $img->height();


					if($x > 900) {
						$newY = 900*$y/$x;
						$img->resize(900, $newY);
						$img->insert('../public/watermark.png', 'bottom-right', 10, 10);
					} else {
						$file =  URL::to('/') . '/watermark.png';
						$watermark = \Intervention\Image\Facades\Image::make($file);
						$waterX = ceil($x/2);
						$waterY = ceil($x/5);

						if($watermark->width() < $waterX) {
							$waterX = $watermark->width();
						}


						if($watermark->height() < $waterY) {
							$waterY = $watermark->height();
						}

						$watermark->resize($waterX, $waterY);
						$img->insert($watermark, 'bottom-right', 10, 10);
					}

					$img->save('./product_images/' . $name);

				}
			}
		}

		// Создаем запись в бд
		foreach ($images_names as $item) {
			self::create(array(
				'product_id' => $product_id,
				'url' => $item
				));
		}
	}

	public static function addImagesToFolder($image, $folder) {
		if(method_exists($image, 'getClientmimeType')) {
			$name = $image->getClientOriginalName();
			$image->move($folder . '_images', $name);
			return $name;
		}
	}
}
