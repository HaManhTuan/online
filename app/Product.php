<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
	protected $table    = 'products';
	protected $fillable = ['name', 'url', 'color', 'category_id', 'description', 'status', 'image', 'price', 'promotional_price', 'sale', 'count'];
	public $timestamps  = false;
	public function attributes() {
		return $this->hasMany('App\ProductAttr', 'product_id');
	}
	public function category() {
		return $this->belongsTo('App\Category', 'category_id', 'id');
	}
}
