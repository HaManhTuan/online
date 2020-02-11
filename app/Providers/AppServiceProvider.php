<?php

namespace App\Providers;

use App\Category;
use App\Discount;
use App\ProductColor;
use App\ProductSize;

use Auth;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
	public function get_menu_data($parent_id = 0, $type = '', $status = 1) {
		$category  = Category::orderBy('arrange', 'asc')->get()->toArray();
		$menu_data = [];
		foreach ($category as $category_item) {
			if ($category_item['parent_id'] == $parent_id) {
				$cate_status = $category_item['status'];
				if ($status = $cate_status) {
					$menu_data[] = $category_item;
				}
			}
		}
		if ($menu_data && count($menu_data) > 0) {
			foreach ($menu_data as $key => $item) {
				// Đệ quy cấp con của danh mục
				$data_child               = $this->get_menu_data($item['id']);
				$menu_data[$key]['child'] = $data_child;
			}
		}
		return $menu_data;
	}
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		view()->composer('*', function ($view) {
				$menu_data = $this->get_menu_data(0, "", 1);
				$category = Category::where(['parent_id' => 0, 'status_cate' => 1])->orderBy('arrange', 'asc')->paginate(3);
				$discount = Discount::where(['status'    => 1])->first();
				$data_send = [
					'menu_data' => $menu_data,
					'category'  => $category,
					'discount'  => $discount
				];
				$view->with($data_send);
				//Get datauser
				if (Auth::check() == true) {
					$userLogin = Auth::user();
					// $role_id = $userLogin->role_id;
					// $role_value = Role::where("id", $role_id)->value("value");
					// $userLogin->role_value = $role_value;
					$view->with('userLogin', $userLogin);
				}
				//Get data color
				$color_data = ProductColor::get();
				$view->with('color_data', $color_data);
				//Get data_size
				$size_data = ProductSize::get();
				$view->with('size_data', $size_data);
			});
	}
}
