<?php

namespace App\Http\Controllers;

use App\CartCus;
use App\Coupon;
use App\Product;
use App\ProductAttr;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
//use Cart;

class CartController extends Controller {
	public function addcart(Request $req) {
		Session::forget('CouponAmount');
		Session::forget('CouponCode');
		$session_id = Session::get('session_id');
		if (empty($session_id)) {
			$session_id = Str::random(30);
			Session::put('session_id', $session_id);
		}
		$countProduct = CartCus::where(['product_id' => $req->product_id, 'size' => $req->size_id, 'session_id' => $session_id])->count();
		if ($countProduct > 0) {
			$msg = [
				'status' => '_error',
				'msg'    => 'Sản phẩm này đã có trong giỏ hàng
				'
			];
			return response()->json($msg);
		} else {
			$cart               = new CartCus();
			$cart->product_id   = $req->product_id;
			$cart->size         = $req->size_id;
			$cart->price        = $req->price;
			$cart->quantity     = $req->quantity;
			$cart->total        = $req->price*$req->quantity;
			$cart->product_name = $req->product_name;
			$cart->user_email   = Auth::guard('customers')->user()->email;
			$cart->session_id   = $session_id;
			$query              = $cart->save();
			if ($query) {
				$msg = [
					'status' => '_success',
					'msg'    => '1 sản phẩm đã được thêm vào giỏ hàng'
				];
				return response()->json($msg);
			} else {
				$msg = [
					'status' => '_error',
					'msg'    => 'Size này không đủ số lượng. Vui lòng nhập số lượng ít hơn
					'
				];
				return response()->json($msg);
			}
		}
	}
	public function viewcart(Request $req) {

		$session_id = Session::get('session_id');
		if (Auth::guard('customers')->check()) {
			$user_email = Auth::guard('customers')->user()->email;
			$countCart  = CartCus::where(['user_email' => $user_email])->count();
			$cart       = CartCus::where(['user_email' => $user_email])->get();
		} else {
			$countCart = CartCus::where(['session_id' => $session_id])->count();
			$cart      = CartCus::where(['session_id' => $session_id])->get();
		}

		foreach ($cart as $key => $value) {
			$productDetail     = Product::where('id', $value->product_id)->first();
			$cart[$key]->image = $productDetail->image;
		}
		$data_send = [
			'cart'      => $cart,
			'countCart' => $countCart,
		];
		return view('home.cart')->with($data_send);
	}
	public function decart(Request $req) {
		Session::forget('CouponAmount');
		Session::forget('CouponCode');
		$delCart = CartCus::where(['id' => $req->id])->delete();
		if ($delCart) {
			$msg = [
				'status' => '_success',
				'msg'    => '1 sản phẩm đã được xoa'
			];
			return response()->json($msg);
		} else {
			$msg = [
				'status' => '_error',
				'msg'    => 'Error'
			];
			return response()->json($msg);
		}
	}
	public function updatecart($id, $quantity) {
		Session::forget('CouponAmount');
		Session::forget('CouponCode');
		$getCartDetails     = DB::table('cart')->where('id', $id)->first();
		$getAyytributeStock = ProductAttr::where(['product_id' => $getCartDetails->product_id, 'size_id' => $getCartDetails->size])->first();
		$update_quantity    = $getCartDetails->quantity+$quantity;
		//echo $getCartDetails->product_id;
		if ($getAyytributeStock->stock >= $update_quantity) {
			DB::table('cart')     ->where('id', $id)->increment('quantity', $quantity);
			return redirect('account/view-cart')->with('mess_success', 'Số lượng đã được thay đổi');
		} else {
			return redirect('account/view-cart')->with('mess_error', 'Sản phẩm trong kho không đủ. Vui lòng giảm số lượng sản phẩm!!!!');
		}
	}
	public function coupon(Request $req) {
		Session::forget('CouponAmount');
		Session::forget('CouponCode');
		$counponCount = Coupon::where('coupon_code', $req->coupon_code)->count();
		if ($counponCount == 0) {
			$msg = [
				'status' => '_error',
				'msg'    => 'Mã giảm giá không tồn tại'
			];
			return response()->json($msg);
		} else {
			$couponDetail = Coupon::where('coupon_code', $req->coupon_code)->first();
			$expiry_date  = $couponDetail->expiry_date;
			$current_date = date("d-m-Y");
			if ($expiry_date < $current_date) {
				$msg = [
					'status' => '_error',
					'msg'    => 'Mã giảm giá đã hết hạn'
				];
				return response()->json($msg);
			}
			$session_id = Session::get('session_id');
			if (Auth::guard('customers')->check()) {
				$user_email = Auth::guard('customers')->user()->email;
				//$countCart  = Cart::where(['user_email' => $user_email])->count();
				$cart = CartCus::where(['user_email' => $user_email])->get();
			} else {
				//$countCart = Cart::where(['session_id' => $session_id])->count();
				$cart = CartCus::where(['session_id' => $session_id])->get();
			}
			//$cart         = Cart::where(['session_id' => $session_id])->get();
			$total_amount = 0;
			foreach ($cart as $item) {
				$total_amount = $total_amount+($item->price*$item->quantity);
			}

			if ($couponDetail->amount_type == "Fixed") {
				$counponAmount = $couponDetail->amount;
			} else {
				$counponAmount = $total_amount*($couponDetail->amount/100);
			}
			Session::put('CouponAmount', $counponAmount);
			Session::put('CouponCode', $req->coupon_code);
			$msg = [
				'status' => '_success',
				'msg'    => 'Thành công. Bạn đã được giảm giá'
			];
			return response()->json($msg);
		}
	}
}
