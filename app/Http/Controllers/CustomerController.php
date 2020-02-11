<?php

namespace App\Http\Controllers;
use App\Customers;
use Auth;
use Hash;
use Illuminate\Http\Request;

class CustomerController extends Controller {
	public function register(Request $req) {
		return view('home.register');
	}
	public function login(Request $req) {
		if (Auth::guard('customers')->attempt(['email' => $req->email_login, 'password' => $req->password_login])) {
			$msg = [
				'status' => '_success',
				'msg'    => 'Loading .....'

			];
			return response()->json($msg);
		} else {
			$msg = [
				'status' => '_error',
				'msg'    => 'Tài khoản hoặc mật khẩu sai
				'
			];
			return response()->json($msg);
		}
	}
	public function registation(Request $req) {
		$checkEmail = Customers::where('email', $req->email)->count();
		if ($checkEmail > 0) {
			$msg = [
				'status' => '_error',
				'msg'    => 'Email này đã tồn tại. Vui lòng nhập email khác
				'
			];
			return response()->json($msg);
		} else {
			$customer           = new Customers();
			$customer->name     = $req->name;
			$customer->email    = $req->email;
			$customer->address  = $req->address;
			$customer->phone    = $req->phone;
			$customer->password = Hash::make($req->password);
			if ($customer->save()) {
				$msg = [
					'status' => '_success',
					'msg'    => 'Đăng kí tài khoản thành công
					'
				];
				return response()->json($msg);
			} else {
				$msg = [
					'status' => '_error',
					'msg'    => 'Lỗi
					'
				];
				return response()->json($msg);
			}
		}
	}
	public function logout() {
		Auth::guard('customers')->logout();
		return redirect('/');
	}
	public function viewaccount(Request $req) {
		return view('home.account.account');
	}
	public function editaccount(Request $req) {
		if (Auth::guard('customers')->check()) {
			$idAccount              = Auth::guard('customers')->user()->id;
			$accountUpdate          = Customers::find($idAccount);
			$accountUpdate->name    = $req->name;
			$accountUpdate->address = $req->address;
			$accountUpdate->phone   = $req->phone;
			if ($accountUpdate->save()) {
				$msg = [
					'status'  => '_success',
					'name'    => $req->name,
					'address' => $req->address,
					'msg'     => 'Thay đổi tài khoản thành công
					'
				];
				return response()->json($msg);
			} else {
				$msg = [
					'status' => '_error',
					'msg'    => 'Lỗi
					'
				];
				return response()->json($msg);
			}

		}
	}
	public function editpassword(Request $req) {
		$pwd        = $req->retypeNewPwd;
		$pwd_bcrypt = Hash::make($pwd);
		$id         = $req->id;
		$query      = Customers::where("id", $id)->update(['password' => $pwd_bcrypt]);
		if (!$query || $query == false) {
			$msg = [
				'status' => '_error',
				'msg'    => 'Có lỗi xảy ra. Vui lòng thử lại'
			];
			return response()->json($msg);
		} else {
			Auth::guard('customers')->logout();
			$msg = [
				'status' => '_success',
				'msg'    => 'Mật khẩu đã được thay đổi thành công'
			];
			return response()->json($msg);
		}
	}
}
