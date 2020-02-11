<?php

namespace App\Http\Controllers;
use App\Category;
use App\Product;
use App\ProductAttr;

use App\ProductColor;
use App\ProductImg;
use App\ProductSize;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller {
	public function getDataColor($current_id = '') {
		$color_data  = ProductColor::get();
		$data_select = "";
		foreach ($color_data as $color_data) {
			if ($current_id != "") {
				if ($color_data['id'] == $current_id) {
					$selected = "selected='selected'";
				} else {
					$selected = "";
				}
			} else {
				$selected = "";
			}
			$data_select .= '<option value="'.$color_data['id'].'" '.$selected.'>';
			$data_select .= $color_data['color'];
			$data_select .= '</option>';
		}
		return $data_select;
	}
	public function viewpro() {
		$products             = Product::orderBy('created_at', 'asc')->get();
		$product_status       = [];
		$product_class_status = [];
		foreach ($products as $key => $product) {

			$product_status[$key]       = parent::status_convert($product->status);
			$product_class_status[$key] = parent::status_format($product->status);

			$category_id    = $product->category_id;
			$category_name  = Category::where('id', $category_id)->value('name');
			$category[$key] = $category_name;

		}
		$size      = ProductSize::get();
		$data_send = [
			'products' => $products,
			//'category_name'         => $category,
			'product_status'       => $product_status,
			'product_class_status' => $product_class_status,
			'size'                 => $size
		];

		return view('admin.product.list')->with($data_send);
	}
	public function add() {
		$categoryController = new CategoryController();
		$data_select        = $categoryController->getDataSelect(0, '', '');
		$data_color         = $this->getDataColor();
		$data_send          = [
			'categoryData' => $data_select,
			'data_color'   => $data_color
		];
		return view('admin.product.add')->with($data_send);
	}
	public function addpro(Request $req) {
		$request = $req->all();
		//print_r($request);
		$request['name']              = $req->name;
		$request['url']               = $req->url;
		$request['category_id']       = $req->parent_id;
		$request['description']       = $req->description;
		$price                        = (int) preg_replace("/[\,\.]+/", "", $req->price);
		$promotional_price            = (int) preg_replace("/[\,\.]+/", "", $req->promotional_price);
		$request['sale']              = parent::sale($promotional_price, $price);
		$request['price']             = $price;
		$request['promotional_price'] = $promotional_price;
		$request['color']             = $req->color;
		$request['count']             = $req->count;
		$request['status']            = $req->has('status')?$req->status:0;
		$target_save                  = "public/uploads/images/products/";

		if ($req->hasFile('file')) {
			$file  = $req->file('file');
			$name  = $file->getClientOriginalName();
			$image = Str::random(4)."_".$name;
			while (file_exists("public/uploads/images/products/".$image)) {
				$image = Str::random(4)."_".$name;
			}
			$file->move("public/uploads/images/products", $image);
			$request['image'] = $image;
		} else {
			$request['image'] = "";
		}
		$query = Product::create($request);
		if (!$query) {
			$msg = array(
				'status' => "_error",
				'msg'    => "Có lỗi xảy ra. Vui lòng thử lại.",
			);
			return response()->json($msg);
		} else {
			$msg = array(
				'status' => "_success",
				'msg'    => "Sản phẩm của bạn đã được đăng.",
			);
			return response()->json($msg);
		}
	}
	public function delpro(Request $req) {
		$id          = $req->id;
		$img_product = ProductImg::where(['product_id' => $id])->get()->toArray();
		if (isset($img_product)) {
			$DeleteImages = ProductImg::where(['product_id' => $id])->delete();
			foreach ($img_product as $value) {
				unlink('public/uploads/images/products/'.$value['img']);
			}
		}
		$DelAttr = ProductAttr::where(['product_id' => $id])->delete();
		$avatar  = Product::where(['id'             => $id])->first();
		unlink('public/uploads/images/products/'.$avatar->image);
		if (Product::destroy($id)) {

			$msg = array(
				'status' => '_success',
				'msg'    => 'Một mục đã được xóa',
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
	public function addimg(Request $req, $url) {
		$product_detail = Product::where(['url' => $url])->first();
		$id             = $product_detail->id;
		if ($req->isMethod('post')) {
			$data = $req->all();
			if ($req->hasFile('file')) {
				$files = $req->file('file');
				foreach ($files as $file) {
					// Upload Images after Resize
					$image     = new ProductImg();
					$extension = $file->getClientOriginalExtension();
					$fileName  = rand(111, 99999).'.'.$extension;
					$file->move("public/uploads/images/products", $fileName);
					$image->img        = $fileName;
					$image->product_id = $id;
					$image->save();
				}
			}
			return redirect('admin/product/add-image/'.$url)->with('flash_message_success', 'Ảnh sản phẩm đã được thêm');
		}
		$product_img = ProductImg::where(['product_id' => $id])->orderBy('id', 'DESC')->get();
		$data_send   = [
			'product_detail' => $product_detail,
			'product_img'    => $product_img
		];
		return view('admin.product.img')->with($data_send);
	}
	public function editpro(Request $req, $url) {
		$product_detail     = Product::where(['url' => $url])->first();
		$categoryController = new CategoryController();
		$data_select        = $categoryController->getDataSelect(0, '', $product_detail->category_id);
		$category_detail    = Category::where(['id' => $product_detail->category_id])->first();
		$category_name      = $category_detail->name;
		$data_color         = $this->getDataColor($product_detail->color);
		$data_send          = [
			'product_detail' => $product_detail,
			'category_name'  => $category_name,
			'data_select'    => $data_select,
			'data_color'     => $data_color
		];
		if ($req->isMethod('post')) {
			//print_r($req->all());
			$request                      = $req->all();
			$request['name']              = $req->name;
			$request['url']               = $req->url;
			$request['category_id']       = $req->parent_id;
			$request['description']       = $req->description;
			$price                        = (int) preg_replace("/[\,\.]+/", "", $req->price);
			$promotional_price            = (int) preg_replace("/[\,\.]+/", "", $req->promotional_price);
			$request['sale']              = parent::sale($promotional_price, $price);
			$request['price']             = $price;
			$request['promotional_price'] = $promotional_price;
			$request['color']             = $req->color;
			$request['count']             = $req->count;
			$request['status']            = $req->has('status')?$req->status:0;
			$target_save                  = "public/uploads/images/products/";
			if ($req->hasFile('file')) {
				$file  = $req->file('file');
				$name  = $file->getClientOriginalName();
				$image = Str::random(4)."_".$name;
				while (file_exists("public/uploads/images/products/".$image)) {
					$image = Str::random(4)."_".$name;
				}
				$file->move("public/uploads/images/products", $image);
				$request['image'] = $image;
				unlink("public/uploads/images/products/".$req->old_file);
			} else {
				$request['image'] = $req->old_file;
			}
			$query = $product_detail->update($request);

			if (!$query) {
				$msg = array(
					'status' => "_error",
					'msg'    => "Có lỗi xảy ra. Vui lòng thử lại.",
				);
				return response()->json($msg);
			} else {
				$msg = array(
					'status' => "_success",
					'msg'    => "Cập nhật thành công",
				);
				return response()->json($msg);
			}

		}
		return view('admin.product.edit')->with($data_send);
	}
	public function deimg(Request $req) {
		$id         = $req->id;
		$length     = $req->length;
		$id_array   = explode(",", $id);
		$img_del_qr = ProductImg::whereIn('id', $id_array)->first();

		if (ProductImg::destroy($id_array)) {
			unlink("public/uploads/images/products/".$img_del_qr->img);
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
	/*GetTableColor*/
	public function GetTableColor($id) {
		$color_data = ProductColor::where('product_id', $id)->get();
		$data_table = "";
		$data_table .= '<table class="table table-bordered">
		<tr>
		<td>STT</td>
		<td>Name</td>
		<td>Color</td>
		<td>Action</td>
		</tr>';
		$stt = 0;
		foreach ($color_data as $color_data) {
			$stt++;
			$data_table .= '<tr>';
			$data_table .= '<td>'.$stt.'</td>';
			$data_table .= '<td>'.$color_data['color'].'</td>';
			$data_table .= '<td><span style="display: block;width: 50px;height: 50px;background-color:'.$color_data['class'].'"></span></td>';
			$data_table .= '<td>
			<a href="" data-id="'.$color_data['id'].'" class="btn btn-success btn-size" data-toggle="modal" data-target="#addsize"><i class="fas fa-plus"></i></a>
			<button data-id="'.$color_data['id'].'" class="btn btn-danger btn-del-color"><i class="fas fa-trash"></i></button>
			</td>';
			$data_table .= '</tr>';
		}
		$data_table .= '</table>';
		return $data_table;
	}
	/*Get table size*/
	public function GetTableSize($id) {
		$size_data  = ProductAttr::where('product_id', $id)->get();
		$data_table = "";
		$data_table .= '<table class="table table-bordered">
		<tr>
		<td>STT</td>
		<td>Size</td>
		<td>Stock</td>
		<td>Action</td>
		</tr>';
		$stt = 0;
		foreach ($size_data as $size_data) {
			$stt++;
			$name_size       = ProductSize::where(['id'         => $size_data['size_id']])->value('size');
			$stock_size_attr = ProductAttr::where(['product_id' => $id])->value('stock');
			$data_table .= '<tr>';
			$data_table .= '<td>'.$stt.'</td>';
			$data_table .= '<td>'.$name_size.'</td>';
			$data_table .= '<td>'.$stock_size_attr.'</td>';
			$data_table .= '<td>
			<button data-id="'.$size_data['id'].'" class="btn btn-danger btn-del-size"><i class="fas fa-trash"></i></button>
			</td>';
			$data_table .= '</tr>';
		}
		$data_table .= '</table>';
		return $data_table;
	}
	//Open Modal Color
	public function modalcolor(Request $req) {
		$id             = $req->id;
		$body           = $this->GetTableColor($req->id);
		$modalcolor     = Product::find($id);
		$modalcolorbody = ProductColor::where(['product_id' => $id])->first();
		if (isset($modalcolor)) {
			$msg = [
				'status'     => '_success',
				'body'       => $body,
				'name'       => $modalcolor->name,
				'product_id' => $modalcolor->id
			];
			return response()->json($msg);
		}
		if (isset($body)) {
			$msg = [
				'status' => '_success',
				'body'   => $body,
			];
			return response()->json($msg);
		}

	}
	public function addcolor(Request $req) {
		$data = $req->all();
		foreach ($data['color'] as $key => $val) {
			if (!empty($val)) {
				$attrCountColors = ProductColor::where(['product_id' => $data['product_id'], 'color' => $val])->count();
				if ($attrCountColors > 0) {
					$msg = [
						'status' => '_error',
						'msg'    => 'Màu này đã thực sự tồn tại. Vui lòng nhập từ khác'
					];
					return response()->json($msg);
				}

			}
			$color             = new ProductColor();
			$color->product_id = $data['product_id'];
			$color->color      = $val;
			$color->class      = $data['bgc'][$key];
			$query             = $color->save();
		}
		if ($query) {
			$msg = [
				'status' => '_success',
				'msg'    => 'Thêm màu thành công'
			];
			return response()->json($msg);
		} else {
			$msg = [
				'status' => '_error',
				'msg'    => 'Màu này đã thực sự tồn tại. Vui lòng nhập từ khác'
			];
			return response()->json($msg);
		}

	}
	// public function delcolor(Request $req) {
	// 	$id     = $req->id;
	// 	$length = $req->length;
	// 	if (ProductColor::destroy($id)) {

	// 		$msg = array(
	// 			'status' => '_success',
	// 			'msg'    => $length.' mục đã được xóa',
	// 		);
	// 		return json_encode($msg);
	// 	} else {
	// 		$msg = array(
	// 			'status' => '_error',
	// 			'msg'    => 'Có lỗi xảy ra. Vui lòng thử lại',
	// 		);
	// 		return json_encode($msg);
	// 	}
	// }
	public function modalsize(Request $req) {
		$id         = $req->id;
		$body       = $this->GetTableSize($req->id);
		$modal      = Product::find($id);
		$id_color   = $modal->color;
		$color      = ProductColor::find($id_color);
		$name_color = $color->color;
		if (isset($modal)) {
			$msg = [
				'status'     => '_success',
				'body'       => $body,
				'name'       => $modal->name,
				'color'      => $name_color,
				'product_id' => $modal->id,
				'stock'      => $modal->count,
			];
			return response()->json($msg);
		}
		if (isset($body)) {
			$msg = [
				'status' => '_success',
				'body'   => $body,
			];
			return response()->json($msg);
		}
		/*	$id             = $req->id;
	$body           = $this->GetTableSize($req->id);
	$modalsize      = ProductColor::find($id);
	$product_detail = Product::where(['id' => $modalsize->product_id])->first();
	if (isset($modalsize)) {
	$msg = [
	'status'       => '_success',
	'body'         => $body,
	'color'        => $modalsize->color,
	'color_id'     => $modalsize->id,
	'name_product' => $product_detail->name
	];
	return response()->json($msg);
	}
	if (isset($body)) {
	$msg = [
	'status' => '_success',
	'body'   => $body,
	];
	return response()->json($msg);
	}*/
	}
	public function addsize(Request $req) {
		$data = $req->all();

		foreach ($data['size'] as $key => $val) {
			if (!empty($val)) {
				$attrCountSize = ProductAttr::where(['size_id' => $val, 'product_id' => $data['product_id']])->count();
				if ($attrCountSize > 0) {
					$msg = [
						'status' => '_error',
						'msg'    => 'Size này đã thực sự tồn tại. Vui lòng chọn size khác'
					];
					return response()->json($msg);
				}
			}
			$size             = new ProductAttr();
			$size->size_id    = $val;
			$size->stock      = $data['stock'];
			$size->product_id = $data['product_id'];
			$query            = $size->save();
		}
		if ($query) {
			$msg = [
				'status' => '_success',
				'msg'    => 'Thêm size thành công'
			];
			return response()->json($msg);
		} else {
			$msg = [
				'status' => '_error',
				'msg'    => 'Size này đã thực sự tồn tại. Vui lòng nhập từ khác'
			];
			return response()->json($msg);
		}
	}
	public function updatesize(Request $req) {
		//print_r($req->all());
		$product_size        = ProductSize::find($req->id);
		$product_size->size  = $req->size;
		$product_size->stock = $req->stock;
		$query               = $product_size->save();
		if ($query) {
			$msg = [
				'status' => '_success',
				'msg'    => 'Update size thành công'
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
	public function attributecolor(Request $req) {
		$data_color = ProductColor::get();
		if ($req->isMethod('post')) {
			$data = $req->all();
			foreach ($data['color'] as $key => $val) {
				if (!empty($val)) {
					$attrCountColor = ProductColor::where(['color' => $val])->count();
					if ($attrCountColor > 0) {
						return redirect('admin/attribute/view-attribute')->with('flash_message_error', 'Màu này đã tồn tại');
					}
				}
				$color        = new ProductColor();
				$color->color = $val;
				$color->class = $data['bgc'][$key];
				$query        = $color->save();

			}
			if ($query) {
				return view("admin.attribute.color");
			}
		}
		$data_send = ['data_color' => $data_color];
		return view("admin.attribute.color")->with($data_send);
	}
	public function attributesize(Request $req) {
		$data_size = ProductSize::get();
		if ($req->isMethod('post')) {
			$data = $req->all();
			foreach ($data['size'] as $key => $val) {
				if (!empty($val)) {
					$attrCountSize = ProductSize::where(['size' => $val])->count();
					if ($attrCountSize > 0) {
						return redirect('admin/attribute/view-attribute-size')->with('flash_message_error', 'Size này đã tồn tại');
					}
				}
				$size       = new ProductSize();
				$size->size = $val;
				$query      = $color->save();
			}
			if ($query) {
				return view("admin.attribute.size");
			}
		}
		$data_send = ['data_size' => $data_size];
		return view("admin.attribute.size")->with($data_send);
	}
	public function stock(Request $req) {
		// print_r($req->all());
		// die();
		$stock = ProductAttr::where(['size_id' => $req->sizeid, 'product_id' => $req->product_id])->sum('stock');
		$size  = ProductSize::where(['id'      => $req->sizeid])->value('size');
		if ($stock > 0) {
			$msg = [
				'status' => '_success',
				'size'   => $size,
				'msg'    => 'Thanh cong'
			];
			return response()->json($msg);
		} else {
			$msg = [
				'status' => '_error',
				'msg'    => 'Size này hiện tại đang hết hàng. Vui lòng chọn size khác'
			];
			return response()->json($msg);
		}

	}
	public function stock_size(Request $req) {
		$stock = ProductAttr::where(['size_id' => $req->sizeid, 'product_id' => $req->product_id])->sum('stock');
		if ($req->qty > $stock) {
			$msg = [
				'status' => '_error',
				'msg'    => 'Size này không đủ số lượng. Vui lòng nhập số lượng ít hơn
				'
			];
			return response()->json($msg);
		}
		if ($req->qty < $stock) {
			$msg = [
				'status' => '_success',
				'msg'    => 'OK
				'
			];
			return response()->json($msg);
		}

	}
}
