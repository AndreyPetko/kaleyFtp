<?php

namespace App;
use DB;
use Auth;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
	protected $table = 'attributes';
	protected $fillable = ['name'];


	public static function getAttributesByCategory($category_id) {
		$attributes = DB::select("SELECT `attributes`.* FROM `attributes` LEFT JOIN `category_attr`
			ON `attributes`.id = `category_attr`.attribute_id WHERE `category_attr`.`category_id` = :id ORDER BY attributes.name", array('id' => $category_id));
		return $attributes;
	}


	public static function getValues($type, $id) {
		if(Auth::check() && (Auth::user()->role == 'wholesaler' || Auth::user()->role = 'ander' )) {
			$values =  DB::select('SELECT DISTINCT product_attrs_value.value, attributes.name FROM attributes
				LEFT JOIN product_attrs_value ON attributes.id = product_attrs_value.attribute_id
				LEFT JOIN products ON product_attrs_value.product_id = products.id
				WHERE products.' . $type . '_id = :id
				AND product_attrs_value.value != "" AND products.active_wholesale = 1', array($id));
		} else {
			$values =  DB::select('SELECT DISTINCT product_attrs_value.value, attributes.name FROM attributes
				LEFT JOIN product_attrs_value ON attributes.id = product_attrs_value.attribute_id
				LEFT JOIN products ON product_attrs_value.product_id = products.id
				WHERE products.' . $type . '_id = :id
				AND product_attrs_value.value != "" AND products.active = 1', array($id));
		}


		$arr = [];

		foreach ($values as  $value) {
			$arr[$value->name][] = $value->value;
		}

		return $arr;
	}


	public static function getSubcategoryValues($subcategoryId) {
		$values = DB::select('SELECT DISTINCT pav.value, a.name FROM attributes as a
			LEFT JOIN product_attrs_value as pav ON a.id = pav.attribute_id
			LEFT JOIN products as p ON pav.product_id = p.id
			LEFT JOIN product_subcat as ps ON ps.product_id = p.id
			WHERE pav.value != ""
			AND ps.subcat_id = :subcategoryId', array($subcategoryId));

		$arr = [];

		foreach ($values as  $value) {
			$arr[$value->name][] = $value->value;
		}

		return $arr;
	}


	public static function deleteItem($id) {
		//Удаляем привязку атрибута к категории
		DB::table('category_attr')->where('attribute_id', $id)->delete();

		//Удаляем значение атрибута у товаров
		DB::table('product_attrs_value')->where('attribute_id', $id)->delete();

		//Удаляем атрибут
		DB::table('attributes')->where('id', $id)->delete();
	}


	public static function updateItem($request) {
		return DB::table('attributes')->where('id', $request['attribute_id'])->update(['name' => $request['name']]);
	}

	public static function getWithCategoryMark($category_id) {
		return DB::select('SELECT *, IF((SELECT id FROM category_attr WHERE category_id = :category_id AND attribute_id = attributes.id), 1,0) as hasAttr
			FROM attributes', array($category_id));
	}


	public static function updateCategoryItems($category_id, $attributes) {
		$category_attrs = DB::table('category_attr')->where('category_id', $category_id)->get();
		$delete_attrs = [];


		foreach ($category_attrs as $category_attr) {
			if(!in_array($category_attr->attribute_id, $attributes)) {
				$delete_attrs[] = $category_attr->attribute_id;
			}
		}


		//Удаляем значение удаленных атрибутов у товаров этой категории
		DB::table('product_attrs_value')->leftjoin('products', 'products.id', '=', 'product_attrs_value.product_id')
		->whereIn('product_attrs_value.attribute_id', $delete_attrs)
		->where('products.category_id', $category_id)
		->delete();

		//Удаляем все атрибуты у категории
		DB::table('category_attr')->where('category_id', $category_id)->delete();

		//Добавляем атрибуты из массива $attributes
		foreach ($attributes as $attribute) {
			DB::table('category_attr')->insert(['category_id' => $category_id, 'attribute_id' => $attribute]);
		}

		return true;
	}


	public static function getCategoryItemsWithProductValues($product) {
		$attributes = DB::table('attributes')->select('attributes.*')->leftjoin('category_attr', 'attributes.id', '=', 'category_attr.attribute_id')
		->where('category_attr.category_id', $product->category_id)->get();

		$pr_attributes = Product::getProductAttributes($product->id);


		foreach ($attributes as $attribute) {
			foreach ($pr_attributes as $pr_attribute) {
				if($attribute->id == $pr_attribute->id) {
					$attribute->value = $pr_attribute->value;
				}
			}
		}

		return $attributes;
	}


	public static function getByProductsIds($arrId) {
		return DB::table('product_attrs_value')->leftjoin('attributes', 'attributes.id', '=', 'product_attrs_value.attribute_id')
		->whereIn('product_attrs_value.product_id', $arrId)->distinct()->lists('product_attrs_value.attribute_id');
	}


	public static function getByNamesByProductsIds($arrId) {
		return DB::table('attributes')->whereIn('id', $arrId)->get();
	}

}