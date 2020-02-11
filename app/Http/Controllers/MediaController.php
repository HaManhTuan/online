<?php

namespace App\Http\Controllers;
use App\Discount;
use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MediaController extends Controller {
	public function view() {
		$media = Media::orderBy('id', 'asc')->get();

		return view('admin.media.list')->with(['media' => $media]);
	}
	public function add(Request $req) {
		if ($req->isMethod('post')) {
			$media       = new Media();
			$media->name = $req->name;
			$target_save = "public/uploads/images/sliders/";
			if ($req->hasFile('image')) {
				$file  = $req->file('image');
				$name  = $file->getClientOriginalName();
				$image = Str::random(4)."_".$name;
				while (file_exists("public/uploads/images/sliders/".$image)) {
					$image = Str::random(4)."_".$name;
				}
				$file->move("public/uploads/images/sliders", $image);
				$req->image = $image;
			} else {
				$req->image = "";
			}
			$media->image  = $req->image;
			$media->h6     = $req->h6;
			$media->h2     = $req->h2;
			$media->button = $req->button;

			if ($media->save()) {
				$msg = array(
					'status' => '_success',
					'msg'    => 'Một slide đã được thêm',
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
		return view('admin.media.add');
	}
	public function editModal(Request $req) {
		$id         = $req->id;
		$media_edit = Media::find($id);
		$data       = '<div class="form-group">
      <input type="hidden" name="id" value="'.$media_edit->id.'" />
      <label for="category_name_input" class="control-label">Tên<font color="#a94442">(*)</font></label>
      <input type="text" class="form-control" value="'.$media_edit->name.'" name="name" placeholder="Hãy nhập slide."/>
      </div>
      <div class="form-group">
      <label for="category_name_input" class="control-label">Ảnh<font color="#a94442">(*)</font></label>
      <input type="file" id="input-file-now" name="image" class="dropify" data-rule-required="true" data-default-file="'.asset('uploads/images/sliders/').'/'.''.$media_edit->image.'" >
      <input type="hidden" name="old_file" value="'.$media_edit->image.'" />
      </div>
      <div class="form-group">
      <label for="category_name_input" class="control-label">Mô tả 1<font color="#a94442">(*)</font></label>
      <input type="text" class="form-control" name="h6" value="'.$media_edit->h6.'">
      </div>
      <div class="form-group">
      <label for="category_name_input" class="control-label">Mô tả 2<font color="#a94442">(*)</font></label>
      <input type="text" class="form-control" name="h2" value="'.$media_edit->h2.'">
      </div>
      <div class="form-group">
      <label for="category_name_input" class="control-label">Nút<font color="#a94442">(*)</font></label>
      <input type="text" class="form-control" name="button" value="'.$media_edit->button.'" style="width: 30%;">
      </div>';
		$msg = array(
			'name' => $media_edit->name,
			'body' => $data,
		);

		return json_encode($msg);
	}
	public function edit(Request $req) {
		$id          = $req->id;
		$media       = Media::where('id', $id)->first();
		$media->name = $req->name;
		$old_file    = $req->old_file;
		$target_save = "public/uploads/images/sliders/";
		if ($req->hasFile('image')) {
			$file  = $req->file('image');
			$name  = $file->getClientOriginalName();
			$image = Str::random(4)."_".$name;
			while (file_exists("public/uploads/images/sliders/".$image)) {
				$image = Str::random(4)."_".$name;
			}
			$file->move("public/uploads/images/sliders", $image);
			$req->image = $image;
			if (trim($old_file) != "" && file_exists("public/uploads/images/sliders/".$old_file)) {
				unlink("public/uploads/images/sliders/".$old_file);
			}
		} else {
			$req->image = $old_file;
		}

		$media->image  = $req->image;
		$media->h6     = $req->h6;
		$media->h2     = $req->h2;
		$media->button = $req->button;

		if ($media->save()) {
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
	public function delete(Request $req) {
		$id         = $req->id;
		$length     = $req->length;
		$media_data = Media::where(['id' => $id])->get();
		foreach ($media_data as $row) {
			$image_del = $row->image;
			unlink("public/uploads/images/sliders/".$image_del);

		}
		if (Media::destroy($id)) {

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
	public function discount(Request $req) {
		$discount = Discount::find(1);
		if ($req->isMethod('post')) {
			$discount->discount1 = $req->discount1;
			$discount->discount2 = $req->discount2;
			$discount->discount3 = $req->discount3;
			$discount->status    = $req->has('status')?$req->status:0;
			//$request['status']   = $req->has('status')?$req->status:0;
			$query = $discount->save();
			if ($query) {
				$msg = array(
					'status' => '_success',
					'msg'    => 'Discount đã được cập nhật',
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
		return view('admin.media.discount')->with(['discount' => $discount]);
	}
}
