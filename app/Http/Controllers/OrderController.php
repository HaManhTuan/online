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
	public function changestatus(Request $req) {
		$orderStatus               = Order::find($req->order_id);
		$orderStatus->order_status = $req->status;
		if ($orderStatus->save()) {
			$msg = array(
				'status' => '_success',
				'msg'    => 'Bạn đã thay đổi trạng thái thành công.',
			);
			return json_encode($msg);
		} else {
			$msg = array(
				'status' => '_error',
				'msg'    => 'Có lỗi xảy ra. Vui lòng thử lại.',
			);
			return json_encode($msg);
		}

	}
	public function changecustomer(Request $req) {

		$customer          = Customers::find($req->id_cus);
		$customer->name    = $req->name;
		$customer->phone   = $req->phone;
		$customer->address = $req->address;
		if ($customer->save()) {
			$msg = array(
				'status' => '_success',
				'msg'    => 'Bạn đã thay đổi thành công.',
			);
			return json_encode($msg);
		} else {
			$msg = array(
				'status' => '_error',
				'msg'    => 'Có lỗi xảy ra. Vui lòng thử lại.',
			);
			return json_encode($msg);
		}

	}
	public function changeorder(Request $req) {
		$order          = Order::find($req->id_order);
		$order->name    = $req->name_order;
		$order->phone   = $req->phone_order;
		$order->address = $req->address_order;
		if ($order->save()) {
			$msg = array(
				'status' => '_success',
				'msg'    => 'Bạn đã thay đổi thành công.',
			);
			return json_encode($msg);
		} else {
			$msg = array(
				'status' => '_error',
				'msg'    => 'Có lỗi xảy ra. Vui lòng thử lại.',
			);
			return json_encode($msg);
		}
	}
}
