<?php

namespace App\BreadcrumbsClasses;
use DB;

class ProductBreadcrumbs extends \App\Breadcrumbs {

	function generate($product) {
		if($product->category_id) {
			$category = DB::table('categories')->where('id', $product->category_id)->first();
			$this->addParam('/category/' . $category->url, $category->name);
		}

		$subcatId = DB::table('product_subcat')->where('product_id', $product->id)->value('subcat_id');

		if($subcatId) {
			$subcatName = DB::table('subcategories')->where('id', $subcatId)->value('name');
			$this->addParam('/category/Schetnyj-krest?subcategory=' . $subcatId, $subcatName);
		}

		$this->addParam('/product/' . $product->url, $product->name);

		return $this->params;
	}
}