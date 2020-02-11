<?php

namespace App\Http\Controllers;
use App\Customers;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller {
	public function vieworder() {
		$orders = Order::with('orders')->get();
		return view('admin.order.list')->with(compact('orders'));
	}
	public function vieworderdetail(Request $req, $id) {
		$orderDetail    = Order::with('orders')->find($id);
		$customerDetail = Customers::find($orderDetail->customer_id);
		$data_send      = [
			'id'             => $id,
			'orderDetail'    => $orderDetail,
			'customerDetail' => $customerDetail,
		];
		return view('admin.order.view')->with($data_send);
	}
}
