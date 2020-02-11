<?php

namespace App\Http\Controllers;

use App\Category;
use App\Media;
use App\Product;
use App\ProductAttr;
use App\ProductColor;
use App\ProductImg;
use App\ProductSize;
use Illuminate\Http\Request;

class HomeController extends Controller {
	public function addcart(Request $req) {
		print_r($_POST);
	}
	public function home() {
		$media       = Media::orderBy('id', 'asc')->get();
		$product_new = Product::orderBy('created_at', 'asc')->get();
		$data_send   = [
			'media'       => $media,
			'product_new' => $product_new
		];
		return view('home.home')->with($data_send);
	}
	public function getColor($id) {
		$product_color = ProductColor::where(['product_id' => $id])->get()->toArray();
		$data_color    = '';
		$data_color .= '<div class="widget-desc"><ul>';
		foreach ($product_color as $product_color) {
			$data_color .= '<li ><a href="" class="chossecolor" data-id="'.$product_color['id'].'" style="background-color:'.$product_color['class'].'"></a></li>';
		}
		$data_color .= '</ul></div>';
		return $data_color;
	}
	public function modalreview(Request $req) {

		$product_detail = Product::find($req->id);
		$idsize         = [];
		$data_size      = ProductAttr::where(['product_id' => $req->id])->get();
		foreach ($data_size as $item) {
			if (in_array($item->size_id, $idsize) == false) {
				$idsize[] = $item->size_id;
			}
		}
		$sizename = ProductSize::whereIn('id', $idsize)->get();
		$output   = '';
		if ($sizename->count() > 0) {
			$output .= ' <h6 class="widget-title">Size</h6>
			<div class="widget-desc">
			<ul>';
			foreach ($sizename as $value) {
				$output .= '<li style="width: 34.6px;height: 33px;"><a href="#" style="text-align:center" class="chossesize" data-id="'.$value['id'].'">'.$value['size'].'</a></li>';
			}
			$output .= '</ul></div>';
		} else {
			$output = '';
		}
		$pricenone    = $product_detail->price;
		$pricepronone = $product_detail->promotional_price;
		//$color          = $this->getColor($req->id);
		if ($product_detail->promotional_price > 0) {
			$price      = number_format($product_detail->price).' VNĐ';
			$sale_price = number_format($product_detail->promotional_price).' VNĐ';
		} else {
			$price      = number_format($product_detail->price).' VNĐ';
			$sale_price = '';
		}
		$msg = [
			'pricenone'      => $pricenone,
			'pricepronone'   => $pricepronone,
			'name_product'   => $product_detail->name,
			'price_product'  => $price,
			'body_size'      => $output,
			'sale_product'   => $sale_price,
			'des_product'    => $product_detail->description,
			'avatar_product' => 'uploads/images/products/'.$product_detail->image,
			'product_id'     => $product_detail->id
		];
		return response()->json($msg);

	}
	public function getProduct($slug) {
		$product_random = Product::all()->random(3);
		$data_send      = [
			'slug'           => $slug,
			'product_random' => $product_random
		];
		return view('home.category')->with($data_send);
	}
	public function filter(Request $req, $slug) {

		$idin      = [];
		$data      = $req->all();
		$cate_data = Category::where('url', $slug)->first();
		$idin[]    = $cate_data->id;
		$cate_in   = Category::where('parent_id', $cate_data->id)->get();
		foreach ($cate_in as $item) {
			if (in_array($item->id, $idin) == false) {
				$idin[] = $item->id;
			}
		}
		$min_price = $data['minimum_price'];
		$max_price = $data['maximum_price'];
		//$id_color  = $data['id_color'];
		// print_r($min_price);
		// print_r($max_price);
		$query = Product::whereIn('category_id', $idin);
		if (isset($min_price, $max_price) && !empty($min_price) && !empty($max_price)) {
			$query->whereBetween('price', [$min_price, $max_price]);
		} else {
			$query->paginate(9);
		}
		$product_data = $query->paginate(9);
		//$product_data = Product::whereIn('category_id', $idin)->paginate(9);
		$output = '';
		if ($product_data->count() > 0) {
			foreach ($product_data as $data) {
				$output .= '
				<div class="col-12 col-sm-6 col-lg-4 single_gallery_item wow fadeInUpBig" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUpBig;">';
				$output .= '
				<div class="product-img">
				<a href="../'.$data['url'].'"><img src="'.asset('uploads/images/products/').'/'.''.$data['image'].'" alt=""></a>
				<div class="pi-links">
				<a href="#" class="add-card"><i class="ti-bag"></i><span>ADD TO CART</span></a>
				<a href="#" class="wishlist-btn"><i class="ti-heart"></i></a>
				</div>
				</div>';
				$output .= '
				<div class="product-description">
				<div class="list-price d-flex justify-content-between">';

				if ($data['promotional_price'] > 0) {
					$output .= '<h4 class="product-price-promotional">'.number_format($data['promotional_price']).' </h4>
					<h4 class="product-price" style="color: #ff084e">'.number_format($data['price']).' </h4>';
				} else {
					$output .= '<h4 class="product-price">'.number_format($data['price']).' </h4>';
				}

				$output .= '</div>
				<a class="product-name" href="../'.$data['url'].'">'.$data['name'].'</a>
				</div>';
				$output .= '</div>
				';
			}
		} else {
			$output = '<h3 style="font-size: 16px;margin: 0 auto;">Không có sản phẩm nào.</h3>';
		}
		echo $output;
	}
	public function detail($slug) {
		$product_detail = Product::where(['url'           => $slug])->first();
		$product_img    = ProductImg::where(['product_id' => $product_detail->id])->get();
		$idsize         = [];
		$data_size      = ProductAttr::where(['product_id' => $product_detail->id])->get();
		$total_stock    = ProductAttr::where(['product_id' => $product_detail->id])->sum('stock');
		foreach ($data_size as $item) {
			if (in_array($item->size_id, $idsize) == false) {
				$idsize[] = $item->size_id;
			}
		}
		$sizename = ProductSize::whereIn('id', $idsize)->get();

		$data_send = [
			'product_detail' => $product_detail,
			'product_img'    => $product_img,
			'sizename'       => $sizename,
			'total_stock'    => $total_stock,
			'data_size'      => $data_size
		];
		return view('home.detail')->with($data_send);
	}
}
