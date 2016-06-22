<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	public $timestamps = false;
	protected $fillable = array('name', 'position', 'link', 'menuid');
	protected $table = 'menus';
}
