<?php

namespace App;

class Paginate {
	public static function getInfo($items) {
		$data['last'] = $items->lastItem();
		$data['first'] = $items->firstItem();
		$data['next'] = $items->nextPageUrl();
		$data['prev'] = $items->previousPageUrl();
		$data['total'] = $items->total();

		return $data;
	}
}