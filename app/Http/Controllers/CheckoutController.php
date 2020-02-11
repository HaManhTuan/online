<?php

namespace App\Http\Controllers;
use App\Cart;
use App\Order;
use App\OrderDetail;
use App\Product;
use Auth;
use DB;
use Illuminate\Http\Request;
use Session;

class CheckoutController extends Controller {
	public function GetTableOrderDetail($id) {
		$orderDetails = Order::with('orders')->where('id', $id)->first();
		//$orderDetails = json_decode(json_encode($orderDetails));
		$data_table = "";
		$data_table .= '<table class="table table-bordered">
		<tr>
		<td>STT</td>
		<td>SP</td>
		<td>Size</td>
		<td>Giá</td>
		<td>SL</td>
		<td>TT</td>
		</tr>';
		$stt = 0;
		foreach ($orderDetails->orders as $orderDetails) {
			$size = DB::table('product_size')->where('id', $orderDetails['size'])->value('size');
			$stt++;
			$data_table .= '<tr>';
			$data_table .= '<td>'.$stt.'</td>';
			$data_table .= '<td>'.$orderDetails['product_name'].'</td>';
			$data_table .= '<td>'.$size.'</td>';
			$data_table .= '<td>'.number_format($orderDetails['price']).'</td>';
			$data_table .= '<td>'.$orderDetails['quantity'].'</td>';
			$data_table .= '<td>'.number_format($orderDetails['quantity']*$orderDetails['price']).'</td>';
			$data_table .= '</tr>';
		}
		$data_table .= '</table>';
		return $data_table;
	}
	public function checkout(Request $req) {
		$session_id = Session::get('session_id');
		DB::table('cart')->where('session_id', $session_id)->update(['user_email' => Auth::guard('customers')->user()->email]);
		$countCart = Cart::where(['session_id'                                    => $session_id])->count();
		if ($countCart == 0) {
			return redirect('view-cart')->with('mess_error', 'Giỏ hàng đang trống');
		} else {
			$cart = Cart::where(['session_id' => $session_id])->get();
			foreach ($cart as $key            => $value) {
				$productDetail     = Product::where('id', $value->product_id)->first();
				$cart[$key]->image = $productDetail->image;
			}
			$data_send = [
				'cart' => $cart
			];
			return view('home.checkout')->with($data_send);
		}

	}
	public function placeorder(Request $req) {
		$order                = new Order();
		$order->customer_id   = Auth::guard('customers')->user()->id;
		$order->email         = $req->email;
		$order->total_price   = $req->total_price;
		$order->name          = $req->name;
		$order->phone         = $req->phone;
		$order->note          = $req->note;
		$order->address       = $req->address;
		$order->coupon_code   = Session::get('CouponCode');
		$order->coupon_amount = Session::get('CouponAmount');
		if ($order->save()) {
			$order_id     = DB::getPdo()->lastInsertId();
			$cartProducts = DB::table('cart')->where(['user_email' => Auth::guard('customers')->user()->email])->get();
			Session::put('order_id', $order_id);
			Session::put('total_price', $req->total_price);
			foreach ($cartProducts as $value) {
				$orderdetail           = new OrderDetail();
				$orderdetail->order_id = $order_id;

				$orderdetail->customer_id  = Auth::guard('customers')->user()->id;
				$orderdetail->product_name = $value->product_name;

				$orderdetail->size     = $value->size;
				$orderdetail->price    = $value->price;
				$orderdetail->quantity = $value->quantity;
				$query                 = $orderdetail->save();
			}
			if ($query) {
				$msg = [
					'status' => '_success',
					'msg'    => 'Loading..'
				];
				return response()->json($msg);
			} else {
				$msg = [
					'status' => '_error',
					'msg'    => 'Error
					'
				];
				return response()->json($msg);
			}
		}

	}
	public function thank(Request $req) {
		$customer_email = Auth::guard('customers')->user()->email;
		//Mail::to(Auth::guard('customers')->user()->email)->send(new Email);
		DB::table('cart')->where('user_email', $customer_email)->delete();
		return view('home.thanks');
	}
	public function historyorder(Request $req) {
		$customer_id = Auth::guard('customers')->user()->id;
		$order       = Order::with('orders')->where('customer_id', $customer_id)->orderBy('id', 'DESC')->get();
		return view('home.account.historyorder', compact('order'));
	}
	public function historyorderdetail(Request $req) {
		//$orderDetails = Order::with('orders')->where('id', $req->id)->first();
		$body = $this->GetTableOrderDetail($req->id);
		$msg  = [
			'body' => $body,
		];
		return response()->json($msg);
	}
}
