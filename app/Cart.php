<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model {
	protected $table   = 'cart';
	public $timestamps = false;
	public function sizecart() {
		return $this->belongsTo('App\ProductSize', 'size', 'id');
	}

}
