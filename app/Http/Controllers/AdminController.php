<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class AdminController extends Controller
{
        public function login(Request $req){
    	if ($req->isMethod('post')) {
    	  $data = $req->input();
    	  if (Auth::attempt(['email' =>$data['email'], 'password' => $data['password'], 'admin' => '1'])) {
            //echo "Hello";
    	  	 return redirect('admin/dashboard');
    	  }
    	  else {
    	  	 return redirect('admin/login')->with('error_msg','Tài khoản hoặc mật khẩu sai');
    	  }
    	
    	}
      return view('admin.login');
    }
    public function logout(){
        Auth::logout();
        return redirect('admin/login');
    }
    public function dashboard(){
    	/*return view('layouts.admin.admin_layout');*/
        return view('admin.dashboard');
    }
}
