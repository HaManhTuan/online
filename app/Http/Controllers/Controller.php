<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	protected function sale($promotional_price, $price) {
		settype($promotional_price, 'int');
		settype($price, 'int');
		if ($price == 0 || $promotional_price > $price) {return 0;
		}

		$sale = round((1-($promotional_price/$price))*100, 1);
		if ($sale == 100) {
			return 99.9;
		}
		return $sale;
	}
	protected function status_convert($status_str) {
		$statusArray = array(
			'all'       => 'Tất cả',
			'1'         => 'Hiển thị',
			'pending'   => 'Chờ duyệt',
			'draft'     => 'Bản nháp',
			'0'         => 'Không hiển thị',
			'cancelled' => 'Đã hủy',
			'sold'      => 'Đã bán',
			'waiting'   => 'Đang chờ',
		);
		if (!isset($status_str)) {return "Không tồn tại trạng thái";
		}

		return $statusArray[$status_str];
	}
	protected function status_format($status) {
		$statusArray = array(
			'all'       => 'label label-danger',
			'1'         => 'badge badge-info',
			'pending'   => 'label label-warning',
			'draft'     => 'label label-inverse',
			'0'         => 'badge badge-success',
			'cancelled' => 'label label-inverse',
			'sold'      => 'label label-inverse',
			'waiting'   => 'label label-warning',
		);
		if (!isset($status)) {return "Không tồn tại trạng thái";
		}

		return $statusArray[$status];
	}
}
