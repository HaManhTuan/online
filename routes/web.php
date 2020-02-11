<?php
//Registation-Login
Route::match(['get', 'post'], '/login-register', 'CustomerController@register');
//Register
Route::post('/register', 'CustomerController@registation');
//login
Route::post('/login', 'CustomerController@login');
//Logout
Route::get('/logout-home', 'CustomerController@logout');

//Account
Route::group(['prefix' => 'account', 'middleware' => 'Home'], function () {
		Route::match(['get', 'post'], '/view-account', 'CustomerController@viewaccount');
		Route::match(['get', 'post'], '/edit-account', 'CustomerController@editaccount');
		Route::match(['get', 'post'], '/edit-password', 'CustomerController@editpassword');
		Route::match(['get', 'post'], '/check-out', 'CheckoutController@checkout');
		Route::match(['get', 'post'], '/place-order', 'CheckoutController@placeorder');
		Route::match(['get', 'post'], '/thank', 'CheckoutController@thank');
		Route::match(['get', 'post'], '/history-order', 'CheckoutController@historyorder');
		Route::match(['get', 'post'], '/history-orderdetail', 'CheckoutController@historyorderdetail');
		//Add Cart
		Route::match(['get', 'post'], 'add-cart', 'CartController@addcart');
		//View-cart
		Route::match(['get', 'post'], 'view-cart', 'CartController@viewcart');
		//Delete Cart
		Route::post('delete-cart', 'CartController@decart');
		//Update Cart
		Route::get('/cart/update-cart/{id}/{quantity}', 'CartController@updatecart');
		//Coupon-Apply
		Route::post('coupon-cart', 'CartController@coupon');
	});
//Home
Route::get('/', 'HomeController@home');
//GetModalReview
Route::post('modal-review', 'HomeController@modalreview');

//Product-detail
Route::get('/{slug}', 'HomeController@detail');
//Count Product
Route::match(['get', 'post'], 'stock', 'ProductController@stock');
Route::match(['get', 'post'], 'stocksize', 'ProductController@stock_size');
//Category-Home
Route::get('danh-muc-san-pham/{slug}', 'HomeController@getProduct');
Route::match(['get', 'post'], 'filter-data/{slug}', 'HomeController@filter');
//Admin
Route::match(['get', 'post'], 'admin/login', 'AdminController@login');
Route::group(['prefix' => 'admin', 'middleware' => 'Admin'], function () {
		Route::get('logout', 'AdminController@logout');
		Route::get('dashboard', 'AdminController@dashboard');
		//Profile
		Route::get('profile', 'ProfileController@view');
		//ChangePW
		Route::post('changePwd', 'ProfileController@changePwd');
		//User
		Route::group(['prefix' => 'member', 'middleware' => 'Admin'], function () {
				Route::get('view-member', 'UserController@view');
			});
		//Silder
		Route::group(['prefix' => 'media', 'middleware' => 'Admin'], function () {
				Route::get('view-media', 'MediaController@view');
				Route::match(['get', 'post'], 'add-media', 'MediaController@add');
				Route::post('edit-modal', 'MediaController@editModal');
				Route::post('edit-media', 'MediaController@edit');
				Route::post('delete', 'MediaController@delete');
				Route::match(['get', 'post'], 'discount', 'MediaController@discount');
			});
		//Categories
		Route::group(['prefix' => 'category', 'middleware' => 'Admin'], function () {
				Route::get('view-category', 'CategoryController@viewcate');
				Route::post('add-category', 'CategoryController@add');
				Route::post('edit-modal', 'CategoryController@editModal');
				Route::post('edit', 'CategoryController@edit');
				Route::post('delete', 'CategoryController@delete');
				Route::post('change-status', 'CategoryController@changestatus');
				Route::post('changeSort', 'CategoryController@changeSort');
			});
		//Product
		Route::group(['prefix' => 'product', 'middleware' => 'Admin'], function () {
				Route::get('view-product', 'ProductController@viewpro');
				Route::get('add', 'ProductController@add');
				Route::post('add-pro', 'ProductController@addpro');
				Route::match(['get', 'post'], 'edit-pro/{url}', 'ProductController@editpro');
				Route::post('delete-pro', 'ProductController@delpro');
				Route::match(['get', 'post'], 'add-image/{url}', 'ProductController@addimg');
				Route::post('delete-img', 'ProductController@deimg');
				//Open modal add color
				/*Route::post('modal-color', 'ProductController@modalcolor');
				Route::post('add-color', 'ProductController@addcolor');
				Route::post('delete-color', 'ProductController@delcolor');*/
				//Open modal add size
				Route::post('modal-size', 'ProductController@modalsize');
				Route::post('add-size', 'ProductController@addsize');
				Route::post('update-size', 'ProductController@updatesize');

			});
		//Attribute-Color
		Route::group(['prefix' => 'attribute', 'middleware' => 'Admin'], function () {
				Route::match(['get', 'post'], 'view-attribute', 'ProductController@attributecolor');
				Route::match(['get', 'post'], 'view-attribute-size', 'ProductController@attributesize');
			});
		Route::group(['prefix' => 'coupon', 'middleware' => 'Admin'], function () {
				Route::match(['get', 'post'], 'view-coupon', 'CouponController@viewcoupon');
				Route::match(['get', 'post'], 'edit-modal', 'CouponController@editmodal');
				Route::post('add-coupon', 'CouponController@addcoupon');
				Route::post('edit-coupon', 'CouponController@editcoupon');
				Route::post('delete-coupon', 'CouponController@deletecoupon');
			});
		Route::group(['prefix' => 'order', 'middleware' => 'Admin'], function () {
				Route::match(['get', 'post'], 'view-order', 'OrderController@vieworder');
				Route::match(['get', 'post'], 'view-orderdetail/{id}', 'OrderController@vieworderdetail');
			});
	});
