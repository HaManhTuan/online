<?php

namespace App\Http\Controllers;

use App\Category;
use DB;
use Illuminate\Http\Request;

class CategoryController extends Controller {
	// Đệ quy tuyến tính menu đa cấp dạng danh sách
	public function getDataList($parent_id = 0) {
		$category_data = Category::orderBy('arrange', 'asc')->get();
		$cate_child    = array();
		$data_ol       = "";
		$label         = "";
		foreach ($category_data as $category_item) {
			if ($category_item['parent_id'] == $parent_id) {
				$cate_child[] = $category_item;
			}
		}
		if ($cate_child) {
			$data_ol .= '<ol class="dd-list list-group">';
			foreach ($cate_child as $key => $item) {

				// Hiển thị tiêu đề chuyên mục
				$data_ol .= '<li class="dd-item" data-id="'.$item['id'].'" id="dd-item-'.$item['id'].'">
                     <div class="icheck-primary d-inline">
                         <input type="checkbox" class="checkone d-none" data-action="checkone" id="checkboxPrimary-'.$item['id'].'" data-id="'.$item['id'].'">
                        <label for="checkboxPrimary-'.$item['id'].'" style="position:absolute;top:12px;left: 15px;"></label>
                    </div>
                    <div class="dd-handle" style="padding-left:40px">'.$item['name'].'';

				$data_ol .= '

                    </div>
                ';
				$data_ol .= '<div class="dd-status">';

				if ($item['status'] == 1) {
					$data_ol .= '<label class="badge badge-warning change-status" id="change-status" data-id="'.$item['id'].'" data-status="'.$item['status'].'" style="margin-left: 20px;margin-top: -5px;position: absolute;cursor: pointer;">Hiện</label>';
				}

				if ($item['status'] == 0) {
					$data_ol .= '<label class="badge badge-danger change-status" id="change-status" data-id="'.$item['id'].'" data-status="'.$item['status'].'" style="margin-left: 20px;margin-top: -5px;position: absolute;cursor: pointer;">Ẩn</label>';
				}
				$data_ol .= '</div>';

				$data_ol .= '
                    <div class="dd-actions">
                        <a class="btn-show-edit-modal d-none" data-toggle="modal" data-target="#edit-category-modal">Sửa</a>
                        <a href="" data-id="'.$item['id'].'" class="btn btn-sm btn-success btn-edit-category" data-toggle="tooltip" title="Sửa"><i class="fas fa-edit"></i></a>';

				$data_ol .= '<a href="" data-id="'.$item['id'].'" class="btn btn-sm btn-danger btn-del-category ml-1" data-toggle="tooltip" title="Xóa"><i class="fas fa-trash"></i></a>';

				$data_ol .= '</div>';
				// Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
				$data_ol .= $this->getDataList($item['id']);
				$data_ol .= '</li>';
			}

			$data_ol .= '</ol>';
		}
		return $data_ol;
	}
	// Đệ quy tuyến tính menu đa cấp dạng droplist
	public function getDataSelect($parent_id = 0, $char = '', $current_id = '') {
		$category_data = Category::orderBy('arrange', 'asc')->get();
		$data_select   = "";
		foreach ($category_data as $category_item) {
			if ($category_item['parent_id'] == $parent_id) {
				if ($current_id != "") {
					if ($category_item['id'] == $current_id || $category_item['parent_id'] == $current_id) {
						$selected = "selected='selected'";
					} else {
						$selected = "";
					}
				} else {
					$selected = "";
				}
				$data_select .= '<option value="'.$category_item['id'].'" '.$selected.'>';
				$data_select .= $char.$category_item['name'];
				$data_select .= '</option>';
				// Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
				$data_select .= $this->getDataSelect($category_item['id'], $char."|---", $current_id);
			}
		}
		return $data_select;
	}
	public function viewcate() {
		$data_ol       = $this->getDataList(0);
		$data_select   = $this->getDataSelect(0);
		$category_data = Category::orderBy('created_at', 'asc')->get();
		$data_send     = [
			'category_data' => $category_data,
			'data_ol'       => $data_ol,
			'data_select'   => $data_select,
		];
		return view('admin.categories.list')->with($data_send);
	}
	public function add(Request $req) {
		$data = $req->all();
		if (empty($data['status_cate'])) {
			$data['status_cate'] = '0';
		} else {
			$data['status_cate'] = '1';
		}
		if (empty($data['status'])) {
			$data['status'] = '0';
		} else {
			$data['status'] = '1';
		}
		$category              = new Category();
		$category->name        = $data['name'];
		$category->parent_id   = $data['parent_id'];
		$category->url         = $data['url'];
		$category->description = $data['description'];
		$category->status      = $data['status'];
		$category->status_cate = $data['status_cate'];
		if ($category->save()) {
			$msg = array(
				'status' => '_success',
				'msg'    => 'Một danh mục đã được thêm.',
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
	public function delete(Request $req) {
		$id         = $req->id;
		$length     = $req->length;
		$id_array   = explode(",", $id);
		$img_del_qr = Category::whereIn('id', $id_array)->get();
		if (Category::destroy($id_array)) {
			$msg = [
				'status' => '_success',
				'msg'    => $length.' mục đã được xóa.'
			];
			return response()->json($msg);
		} else {
			$msg = [
				'status' => '_error',
				'msg'    => 'Có lỗi xảy ra. Vui lòng thử lại.'
			];
			return response()->json($msg);
		}
	}
	public function editModal(Request $req) {
		$id            = $req->id;
		$data_select   = $this->getDataSelect(0, '', $id);
		$category_data = Category::where('id', $id)->first();
		/*echo "<pre>";
		print_r ($category_data);
		echo "</pre>";
		die;*/
		$data = '
               <div class="form-group">
                <label class="control-label">Chọn danh mục cha <font color="#a94442">(*)</font></label>
                <select class="form-control custom-select" name="parent_id" id="parent_id" data-rule-required="true" data-msg-required="Vui lòng chọn danh mục cha.">
                    <option value="" disabled="disabled">--- Chọn danh mục cha ---</option>
                    <option value="0">Không có</option>
                    '.$data_select.'
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="category_name_input" class="control-label">Tên danh mục <font color="#a94442">(*)</font></label>
                <input type="hidden" name="id" value="'.$category_data->id.'" />
                <input type="text" class="form-control" id="name_edit" name="name" onkeyup="ChangeToSlug_Edit();" placeholder="Nhập tên danh mục tại đây." data-rule-required="true" data-msg-required="Vui lòng nhập tên danh mục." value="'.$category_data->name.'" />

            </div>
                   <div class="form-group mb-3">
                                <label for="category_name_input" class="control-label">Url <font color="#a94442">(*)</font></label>
                                <input type="text" class="form-control" id="url_edit" name="url" value="'.$category_data->url.'" readonly=""  />

                            </div>

     ';
		$data .= '
            <div class="form-group">
                <label class="control-label">Chi tiết danh mục</label>';
		$data .= '<textarea rows="5" cols="2" name="description" class="form-control">'.$category_data->description.'</textarea>';
		$data .= '</div>
               <div class="form-group clearfix">
                    <div class="icheck-primary d-inline">
                      <input type="checkbox" id="checkboxPrimaryStatus" class="status" name="status">
                      <label for="checkboxPrimaryStatus">
                      </label>
                    </div>
                    <label class="control-label font-weight-bold ml-2" for="status1">Hiển thị trên menu chính</label>
                </div>
                 <div class="form-group clearfix">
                    <div class="icheck-primary d-inline">
                      <input type="checkbox" id="checkboxPrimaryStatus1" class="status" name="status_cate">
                      <label for="checkboxPrimaryStatus1">
                      </label>
                    </div>
                    <label class="control-label font-weight-bold ml-2" for="status2">Hiển thị trên menu chính</label>
                </div>
        ';
		$msg = array(
			'status_data'    => $category_data->status,
			'status_cate'    => $category_data->status_cate,
			'parent_id_data' => $category_data->parent_id,
			'category_name'  => $category_data->name,
			'body'           => $data,
		);

		return json_encode($msg);
	}
	// Edit data
	public function edit(Request $req) {
		$data = $req->all();
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
		sleep(1);
		$id                    = $req->id;
		$category              = Category::where('id', $id)->first();
		$category->name        = $req->name;
		$category->url         = $req->url;
		$category->parent_id   = $req->parent_id;
		$category->description = $req->description;
		if (empty($req->status)) {
			$category->status = '0';
		} else {
			$category->status = '1';
		}
		if (empty($req->status_cate)) {
			$category->status_cate = '0';
		} else {
			$category->status_cate = '1';
		}
		if ($category->save()) {
			$msg = array(
				'status' => '_success',
				'msg'    => 'Bạn đã sửa thành công danh mục này.',
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
	public function changestatus(Request $req) {

		sleep(1);
		$id              = $req->id;
		$category_status = Category::where('id', $id)->value('status');
		if ($category_status == 1) {

			$changestatus = DB::table('categories')->where('id', $id)->update(['status' => 0]);

		}
		if ($category_status == 0) {
			$changestatus = DB::table('categories')->where('id', $id)->update(['status' => 1]);
		}

		if ($changestatus) {
			$msg = array(
				'status' => '_success',
				'msg'    => 'Thay đổi trạng thái thành công.',
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
	// Sort data
	public function sort_data($data, $parent_id = 0) {
		static $result = array();
		foreach ($data as $key => $item) {
			if (array_key_exists('children', $item) == true) {
				$result[] = array(
					'id'        => $item['id'],
					'parent_id' => $parent_id,
				);
				$this->sort_data($item['children'], $item['id']);
			} else {
				$result[] = array(
					'id'        => $item['id'],
					'parent_id' => $parent_id,
				);
			}
		}
		return $result;
	}
	// Change sort
	public function changeSort(Request $req) {
		sleep(1);
		$dataJson      = $req->dataJson;
		$data          = json_decode($dataJson, true);
		$dataSortArray = $this->sort_data($data);
		$idArray       = array();
		$sortArray     = array();
		$parentArray   = array();
		foreach ($dataSortArray as $key => $value) {
			array_push($idArray, $value['id']);
			array_push($sortArray, $key);
			array_push($parentArray, $value['parent_id']);
		}
		$idstr     = implode(',', $idArray);
		$sortstr   = implode(',', $sortArray);
		$parentstr = implode(',', $parentArray);
		$sql       = "
            UPDATE categories SET
            arrange = ELT(field(id, {$idstr}), {$sortstr}),
            parent_id = ELT(field(id, {$idstr}), {$parentstr})
            WHERE id IN({$idstr})
";
		if (DB::update(DB::raw($sql))) {
			$msg = [
				'status' => '_success',
				'msg'    => 'Cập nhật thành công.'
			];
			return response()->json($msg);
		} else {
			$msg = [
				'status' => '_error',
				'msg'    => 'Có lỗi xảy ra. Vui lòng thử lại.'
			];
			return response()->json($msg);
		}
	}
}
