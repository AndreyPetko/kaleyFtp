<?php

namespace App\Http\Controllers;


use Request;

class FileController extends Controller {

	public function __construct() {
		$this->middleware('isAdmin');
	}

	public function upload() {
		$name = Request::file('upload')->getClientOriginalName();
		Request::file('upload')->move('editor_images', $name);
		$callback = $_GET['CKEditorFuncNum'];
		$error = '';

		$http_path = '/editor_images/'. $name;
		echo "<script type=\"text/javascript\">window.parent.CKEDITOR.tools.callFunction(".$callback.",  \"".$http_path."\", \"".$error."\" );</script>";
	}



}