<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feeship;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Customer;
use App\Models\Coupon;
class OrderController extends Controller
{
    // public function print_order($checkout_code){
	// 	$pdf = \App::make('dompdf.wrapper');
	// 	$pdf->loadHTML($this->print_order_convert($checkout_code));
	// 	return $pdf->stream();
	// }
	// public function print_order_convert($checkout_code){
	// 	return $checkout_code;

	// }
	public function view_order($order_code){
		$order_details = OrderDetails::where('order_code',$order_code)->get();
		$order = Order::where('order_code',$order_code)->get();
		foreach($order as $key => $ord){
			$customer_id = $ord->customer_id;
			$shipping_id = $ord->shipping_id;
		}
		$customer = Customer::where('customer_id',$customer_id)->first();
		$shipping = Shipping::where('shipping_id',$shipping_id)->first();

		// $order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();

		// foreach($order_details_product as $key => $order_d){

		// 	$product_coupon = $order_d->product_coupon;
		// }
		// if($product_coupon != 'no'){
		// 	$coupon = Coupon::where('coupon_code',$product_coupon)->first();
		// 	$coupon_condition = $coupon->coupon_condition;
		// 	$coupon_number = $coupon->coupon_number;
		// }else{
		// 	$coupon_condition = 2;
		// 	$coupon_number = 0;
		// }

		return view('admin.view_order')->with(compact('order_details','customer','shipping','order_details'));

	}
     public function manage_order(){
     	$order = Order::orderby('created_at','DESC')->get();
     	return view('admin.manage_order')->with(compact('order'));
     }
}
