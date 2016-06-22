<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Keyval extends Model {
	public $timestamps = false;
	protected $table = 'keyval';
	protected $fillable = ['key', 'value'];



	public static function findByKey($key) {
		return self::where('key', $key)->value('value');
	}


	public static function getWholesaleContacts() {
		$contacts = [];

		$contacts['phone1'] = self::findByKey('w_phone_1');
		$contacts['phone2'] = self::findByKey('w_phone_2');
		$contacts['email'] = self::findByKey('w_email');

		return $contacts;
	}

	public static function getRetailContacts() {
		$contacts = [];

		$contacts['phone1'] = self::findByKey('r_phone_1');
		$contacts['phone2'] = self::findByKey('r_phone_2');
		$contacts['email'] = self::findByKey('r_email');

		return $contacts;
	}

	public static function updateContacts($request, $type) {
		DB::table('keyval')->where('key', $type . '_phone1')->update(['value' => $request['phone1']]);
		DB::table('keyval')->where('key', $type . '_phone2')->update(['value' => $request['phone2']]);
		DB::table('keyval')->where('key', $type . '_email')->update(['value' => $request['email']]);
	}

	public static function getDeliveryPrices() {
		$prices = ['sam', 'kuryer', 'novaposhta', 'ukrposhta', 'autolux', 'novanal', 'ukrnal'];
		return self::whereIn('key', $prices)->lists('value', 'key');
	}

	public static function updatePrices($prices) {
		foreach ($prices as $name => $price) {
			self::where('key', $name)->update(['value' => $price]);
		}
	}


}