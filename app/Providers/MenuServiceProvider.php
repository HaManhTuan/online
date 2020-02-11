<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Category;
use App\Product;

class MenuServiceProvider extends ServiceProvider
{
    // Get menu data
    private function get_menu_data($parent_id = 0, $type = '', $status = 1) {
      
        $category = Category::orderBy('arrange', 'asc')->get()->toArray();
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
                $data_child = $this->get_menu_data($item['id']);
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
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view) {
            $menu_data = $this->get_menu_data(0, "", 1);
            /*$menu_data_left = $this->get_menu_data(0, 'san-pham', 3);
            $post_cate = $this->get_menu_data(0, 'tin-tuc', 3);
            $chinhSachFooter = $this->getFooter();*/
            $data_send = [
                'menu_data'             => $menu_data
                /*'menu_data_left'        => $menu_data_left,
                'post_cate'             => $post_cate,
                'chinhSachFooter'       => $chinhSachFooter*/
            ];
            $view->with($data_send);
        });
    }
}
