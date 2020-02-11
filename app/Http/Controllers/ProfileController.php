<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller {
	public function view() {
		return view('admin.profile.view');
	}
	public function changePwd(Request $req) {
		$pwd        = $req->retypeNewPwd;
		$pwd_bcrypt = Hash::make($pwd);
		$id         = $req->id;
		$query      = User::where("id", $id)->update(['password' => $pwd_bcrypt]);
		if (!$query || $query == false) {
			$msg = [
				'status' => '_error',
				'msg'    => 'Có lỗi xảy ra. Vui lòng thử lại'
			];
			return response()->json($msg);
		} else {
			Auth::logout();
			$msg = [
				'status' => '_success',
				'msg'    => 'Mật khẩu đã được thay đổi thành công'
			];
			return response()->json($msg);
		}
	}
}
