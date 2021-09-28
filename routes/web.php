<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//backend
Route::get('/admin', 'App\Http\Controllers\AdminController@index');
Route::get('/dashboard', 'App\Http\Controllers\AdminController@show_dashboard');

Route::post('/admin-dashboard', 'App\Http\Controllers\AdminController@dashboard');
Route::get('/logout', 'App\Http\Controllers\AdminController@logout');

//category
Route::get('/add-category-product', 'App\Http\Controllers\CategoryProduct@add_category_product');
Route::get('/all-category-product', 'App\Http\Controllers\CategoryProduct@all_category_product');
Route::get('/edit_category_product/{category_product_id}', 'App\Http\Controllers\CategoryProduct@edit_category_product');
Route::get('/delete-category-product/{category_product_id}', 'App\Http\Controllers\CategoryProduct@delete_category_product');
Route::post('/save-category-product', 'App\Http\Controllers\CategoryProduct@save_category_product');
Route::post('/update-category-product/{category_product_id}', 'App\Http\Controllers\CategoryProduct@update_category_product');

//an hien thi
Route::get('/unactive-category-product/{category_product_id}', 'App\Http\Controllers\CategoryProduct@unactive_category_product');
Route::get('/active-category-product/{category_product_id}', 'App\Http\Controllers\CategoryProduct@active_category_product');

//customer
Route::get('/all-customer', 'App\Http\Controllers\CustomerController@all_customer');

//slider
Route::get('/add-slider', 'App\Http\Controllers\SliderController@add_slider');
Route::get('/all-slider', 'App\Http\Controllers\SliderController@all_slider');
Route::post('/save-slider', 'App\Http\Controllers\SliderController@save_slider');
Route::get('/edit_slider/{slider_id}', 'App\Http\Controllers\SliderController@edit_slider');
Route::get('/delete-slider/{slider_id}', 'App\Http\Controllers\SliderController@delete_slider');
Route::post('/update-slider/{slider_id}', 'App\Http\Controllers\SliderController@update_slider');

//
Route::get('/unactive-slider/{slider_id}', 'App\Http\Controllers\SliderController@unactive_slider');
Route::get('/active-slider/{slider_id}', 'App\Http\Controllers\SliderController@active_slider');


//Product
Route::get('/add-product', 'App\Http\Controllers\ProductController@add_product');
Route::get('/all-product', 'App\Http\Controllers\ProductController@all_product');
Route::get('/edit_product/{product_id}', 'App\Http\Controllers\ProductController@edit_product');
Route::get('/delete-product/{product_id}', 'App\Http\Controllers\ProductController@delete_product');
Route::get('/unactive-product/{product_id}', 'App\Http\Controllers\ProductController@unactive_product');
Route::get('/active-product/{product_id}', 'App\Http\Controllers\ProductController@active_product');
Route::post('/save-product', 'App\Http\Controllers\ProductController@save_product');
Route::post('/update-product/{product_id}', 'App\Http\Controllers\ProductController@update_product');


//frontend
Route::get('/index', 'App\Http\Controllers\HomeController@index');
Route::get('/trang-chu', 'App\Http\Controllers\HomeController@index');
//tim kiem
Route::post('/tim-kiem', 'App\Http\Controllers\HomeController@tim_kiem');

//Danh muc san pham fontend
Route::get('/danh-muc-san-pham/{category_id}', 'App\Http\Controllers\CategoryProduct@category_home');
Route::get('/chi-tiet-san-pham/{product_id}', 'App\Http\Controllers\ProductController@detail_product');



//Cart
Route::post('/save-cart','App\Http\Controllers\CartController@save_cart');
Route::get('/show-cart','App\Http\Controllers\CartController@show_cart');
Route::post('/update-cart-quantity','App\Http\Controllers\CartController@update_cart_quantity');
Route::get('/delete-to-cart/{rowId}','App\Http\Controllers\CartController@delete_to_cart');
Route::get('/delete-all-cart', 'App\Http\Controllers\CartController@delete_all_cart');

//check-coupon
Route::post('/check-coupon','App\Http\Controllers\CouponController@check_coupon');

Route::get('/unset-coupon','App\Http\Controllers\CouponController@unset_coupon');
Route::get('/insert-coupon','App\Http\Controllers\CouponController@insert_coupon');
Route::get('/delete-coupon/{coupon_id}','App\Http\Controllers\CouponController@delete_coupon');
Route::get('/list-coupon','App\Http\Controllers\CouponController@list_coupon');
Route::post('/insert-coupon-code','App\Http\Controllers\CouponController@insert_coupon_code');

//checkout
Route::get('/login-checkout', 'App\Http\Controllers\CheckoutController@login_checkout');
Route::get('/logout-checkout', 'App\Http\Controllers\CheckoutController@logout_checkout');
Route::post('/add-customer', 'App\Http\Controllers\CheckoutController@add_customer');
Route::post('/login-customer', 'App\Http\Controllers\CheckoutController@login_customer');
Route::get('/checkout', 'App\Http\Controllers\CheckoutController@checkout');
Route::post('/checkout-customer', 'App\Http\Controllers\CheckoutController@checkout_customer');
Route::get('/delete-order/{order_id}','App\Http\Controllers\CheckoutController@delete_order');

Route::post('/select-delivery-home','App\Http\Controllers\CheckoutController@select_delivery_home');
Route::post('/calculate-fee','App\Http\Controllers\CheckoutController@calculate_fee');
Route::get('/del-fee','App\Http\Controllers\CheckoutController@del_fee');
Route::post('/confirm-order','App\Http\Controllers\CheckoutController@confirm_order');
//payment
Route::get('/payment', 'App\Http\Controllers\CheckoutController@payment');
Route::post('/order-place', 'App\Http\Controllers\CheckoutController@order_place');



//order
Route::get('/manage-order', 'App\Http\Controllers\OrderController@manage_order');
Route::get('/view-order/{order_code}','App\Http\Controllers\OrderController@view_order');

//comment
Route::post('/load-comment', 'App\Http\Controllers\CheckoutController@load_comment');
Route::post('/send-comment', 'App\Http\Controllers\CheckoutController@send_comment');
Route::get('/all-comment', 'App\Http\Controllers\CheckoutController@all_comment');
Route::post('/allow-comment', 'App\Http\Controllers\CheckoutController@allow_comment');
Route::post('/reply-comment', 'App\Http\Controllers\CheckoutController@reply_comment');
Route::get('/delete-comment/{comment_id}', 'App\Http\Controllers\CheckoutController@delete_comment');

//Delivery
Route::get('/delivery','App\Http\Controllers\DeliveryController@delivery');
Route::post('/select-delivery','App\Http\Controllers\DeliveryController@select_delivery');
Route::post('/insert-delivery','App\Http\Controllers\DeliveryController@insert_delivery');
Route::post('/select-feeship','App\Http\Controllers\DeliveryController@select_feeship');
Route::post('/update-delivery','App\Http\Controllers\DeliveryController@update_delivery');


//mail
Route::get('/send-coupon-vip/{coupon_time}/{coupon_condition}/{coupon_number}/{coupon_code}','App\Http\Controllers\MailController@send_coupon_vip');
Route::get('/send-coupon/{coupon_time}/{coupon_condition}/{coupon_number}/{coupon_code}','App\Http\Controllers\MailController@send_coupon');
Route::get('/mail-example','App\Http\Controllers\MailController@mail_example');

Route::get('/send-mail','App\Http\Controllers\MailController@send_mail');
Route::get('/quen-mat-khau','App\Http\Controllers\MailController@quen_mat_khau');
Route::get('/update-new-pass','App\Http\Controllers\MailController@update_new_pass');
Route::post('/recover-pass','App\Http\Controllers\MailController@recover_pass');
Route::post('/reset-new-pass','App\Http\Controllers\MailController@reset_new_pass');
