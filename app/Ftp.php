<?php

namespace App;
use App\Product;
use DB;

class Ftp {

	public static function getFile() {
		$local_file = 'file.xml';
		$server_file = 'file.xml';

		$ftp_server = 'streamla.ftp.ukraine.com.ua';
		$ftp_user_name = 'streamla_stream';
		$ftp_user_pass = 'bfg5035f';

		// установка соединения
		$conn_id = ftp_connect($ftp_server);

		// вход с именем пользователя и паролем
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		ftp_pasv($conn_id, TRUE);
		// попытка скачать $server_file и сохранить в $local_file
		if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) {
			echo "Произведена запись в $local_file\n";
		} else {
			echo "Не удалось завершить операцию\n";
		}
		ftp_close($conn_id);

		return 1;
	}


	public static function generateArrayFromXml($filename) {

		if(file_exists($filename)) {
			$xml = simplexml_load_file($filename);
		}

		$products = [];


		foreach ($xml as $product) {
			$newProduct = [
			'group' => strval($product->Group),
			'code' => strval($product->Code),
			'name' => strval($product->Name),
			'count' => strval($product->Count),
			'price' => intval($product->PriceRozn),
			'priceWholesale' => intval($product->PriceOpt),
			'article' => strval($product->attributes()->Art)
			];

			$products[] = $newProduct;
		}

		return $products;
	}


	public static function addItems() {
		$xml = new \DOMDocument(); 
		$xml->load('file.xml', LIBXML_NOBLANKS);

		$length = $xml->getElementsByTagName('Товар')->length;


		for ($i=0; $i < $length; $i++) { 
			$name = $xml->getElementsByTagName('Товар')->item($i)->getElementsByTagName('Имя')->item(0)->nodeValue;
			$price = $xml->getElementsByTagName('Товар')->item($i)->getElementsByTagName('Цена')->item(0)->nodeValue;

			$item = DB::select("SELECT id FROM products WHERE name = :name", array('name' => $name));

			if(!$item) {
				Product::create(array(
					'name' => $name,
					'price' => $price
					));
			}

		}


	}
}