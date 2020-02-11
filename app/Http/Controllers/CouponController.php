<?php

namespace App\Http\Controllers;
use App\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller {
	public function viewcoupon(Request $req) {
		$coupon    = Coupon::get();
		$data_send = ['coupon' => $coupon];
		return view('admin..coupon.list')->with($data_send);
	}
	public function addcoupon(Request $req) {
		//print_r($req->coupon_name);
		$coupon              = new Coupon();
		$coupon->coupon_code = $req->coupon_name;
		$coupon->expiry_date = $req->expiry_date;
		$coupon->amount      = $req->amount;
		$coupon->amount_type = $req->amount_type;
		if ($coupon->save()) {
			$msg = array(
				'status' => '_success',
				'msg'    => 'Thêm mới thành công',
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
	public function editmodal(Request $req) {
		$detailCoupon = Coupon::find($req->id);
		$data         = '<div class="form-group">
		<input type="hidden" name="id" value="'.$detailCoupon->id.'" />
		<label for="category_name_input" class="control-label">Mã code <font color="#a94442">(*)</font></label>
		<input type="text" class="form-control" id="coupon_name" name="coupon_name" value="'.$detailCoupon->coupon_code.'" data-rule-required="true" data-msg-required="Vui lòng nhập code."/>
		</div>
		<div class="form-group">
		<label for="category_name_input" class="control-label">Ngày hết hạn<font color="#a94442">(*)</font></label>
		<input type="text" class="form-control" id="expiry_date" name="expiry_date" value="'.$detailCoupon->expiry_date.'" data-rule-required="true" data-msg-required="Vui lòng nhập ngày.">
		</div>
		<div class="form-group">
		<label class="control-label">Số lượng</label>
		<input type="number" class="form-control" id="amount" name="amount" value="'.$detailCoupon->amount.'" data-rule-required="true" data-msg-required="Vui lòng nhập số lượng."/>
		</div>
		<div class="form-group">
		<label for="category_name_input" class="control-label">Loại mã giảm giá <font color="#a94442">(*)</font></label>
		<select name="amount_type" id="amount_type" class="form-control amount_type">
		<option value="Persentage">Persentage</option>
		<option value="Fix">Fix</option>
		</select>
		</div>';
		$msg = array(
			'name'        => $detailCoupon->coupon_code,
			'amount_type' => $detailCoupon->amount_type,
			'body'        => $data,
		);

		return json_encode($msg);
	}
	public function editcoupon(Request $req) {
		$id                  = $req->id;
		$coupon              = Coupon::where('id', $id)->first();
		$coupon->coupon_code = $req->coupon_name;
		$coupon->amount      = $req->amount;
		$coupon->expiry_date = $req->expiry_date;
		$coupon->amount_type = $req->amount_type;
		if ($coupon->save()) {
			$msg = array(
				'status' => '_success',
				'msg'    => 'Cập nhật thành công',
			);
			return json_encode($msg);
		} else {
			$msg = array(
				'status' => '_error',
				'msg'    => 'Có lỗi xảy ra. Vui lòng thử lại',
			);
			return json_encode($msg);
		}
	}
	public function deletecoupon(Request $req) {
		$id     = $req->id;
		$length = $req->length;
		$coupon = Coupon::where(['id' => $id])->get();
		if (Coupon::destroy($id)) {
			$msg = array(
				'status' => '_success',
				'msg'    => $length.' mục đã được xóa',
			);
			return json_encode($msg);
		} else {
			$msg = array(
				'status' => '_error',
				'msg'    => 'Có lỗi xảy ra. Vui lòng thử lại',
			);
			return json_encode($msg);
		}
	}
}
