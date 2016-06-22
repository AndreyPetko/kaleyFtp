<?php

namespace App\BreadcrumbsClasses;
use DB;

class CategoryBreadcrumbs extends \App\Breadcrumbs {

	function generate($category) {

		$this->addParam('/category/' . $category->url, $category->name);

		return $this->params;
	}
}