<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAttr extends Model {
	protected $table   = 'product_attr';
	public $timestamps = false;
	public function size() {
		return $this->belongsTo('App\ProductSize', 'size_id', 'id');
	}
}
