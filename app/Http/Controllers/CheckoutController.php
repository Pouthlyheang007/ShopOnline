<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;
session_start();
use App\Models\Comment;
use App\Models\Product;
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Feeship;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderDetails;
class CheckoutController extends Controller
{
    //Bao mat trang
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
           return Redirect::to('dashboard');
        }else{
           return Redirect::to('admin')->send();
        }
    }
    public function delete_comment($comment_id){
        $this->AuthLogin();
        DB::table('tbl_comment')->where('comment_id',$comment_id)->delete();
        return Redirect::to('all-comment')->with('message','Xóa bình luận thành công');
    }
    public function reply_comment(Request $request){
        $data = $request->all();
        $comment = new Comment();
        $comment->comment = $data['comment'];
        $comment->comment_product_id = $data['comment_product_id'];
        $comment->comment_parent_comment = $data['comment_id'];
        $comment->comment_status = 0;
        $comment->comment_name = 'LHStore';
        $comment->save();
    }
    public function all_comment(){
        $this->AuthLogin();
        $comment = Comment::with('product')->where('comment_parent_comment','=',0)->orderBy('comment_id','DESC')->get();
        $comment_rep = Comment::with('product')->where('comment_parent_comment','>',0)->get();
        return view('admin.comment.all_comment')->with(compact('comment','comment_rep'));
    }
    public function allow_comment(Request $request){
        $data = $request->all();
        $comment = Comment::find($data['comment_id']);
        $comment->comment_status = $data['comment_status'];
        $comment->save();

    }

    public function load_comment(Request $request){
        $product_id = $request->product_id;
        $comment = Comment::where('comment_product_id',$product_id)->where('comment_parent_comment','=',0)
        ->where('comment_status',0)->get();
        $comment_rep = Comment::with('product')->where('comment_parent_comment','>',0)->get();
        $output ='';
        foreach ($comment as $key => $comm) {
            $output.= '
            <div class="row style_comment">
                <div class="col-md-2">
                     <img width="100%" src="'.url('/frontend/image/khach.jpg').'" class="img img-responsive img-thumbnail">
                </div>
                <div class="col-md-10">
                     <p style="color: green">@'.$comm->comment_name.'</p>
                    <p style="color: #000">'.$comm->comment_date.'</p>
                    <p>'.$comm->comment.'</p>
                </div>
            </div>
            <p></p>
            ';
            foreach($comment_rep as $key => $rep_comment){
                if($rep_comment->comment_parent_comment==$comm->comment_id){
            $output.= '
            <div class="row style_comment" style="margin: 5px 40px;background:aquamarine;">
                <div class="col-md-2">
                    <img width="80%" src="'.url('/frontend/image/admin.png').'" class="img img-responsive img-thumbnail">
                </div>
                <div class="col-md-10">
                    <p style="color: green">@LHStore</p>
                    <p style="color: #000">'.$rep_comment->comment.'</p>
                    <p></p>
                </div>
            </div>
            <p></p>
            ';
                }
            }

        }
        echo  $output;
    }
    public function send_comment(Request $request){
        $product_id = $request->product_id;
        $comment_name = $request->comment_name;
        $comment_content = $request->comment_content;
        $comment = new Comment();
        $comment->comment = $comment_content;
        $comment->comment_name = $comment_name;
        $comment->comment_product_id = $product_id;
        $comment->comment_status = 1;
        $comment->comment_parent_comment = 0;
        $comment->save();
    }
    //chon
    public function select_delivery_home(Request $request){
        $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action']=="city"){
                $select_province = Province::where('matp',$data['ma_id'])->orderby('maqh','ASC')->get();
                    $output.='<option>---Chọn quận huyện---</option>';
                foreach($select_province as $key => $province){
                    $output.='<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
                }

            }else{

                $select_wards = Wards::where('maqh',$data['ma_id'])->orderby('xaid','ASC')->get();
                $output.='<option>---Chọn xã phường---</option>';
                foreach($select_wards as $key => $ward){
                    $output.='<option value="'.$ward->xaid.'">'.$ward->name_xaphuong.'</option>';
                }
            }
            echo $output;
        }
    }

    //tinh phi van chuyen
    public function calculate_fee(Request $request){
        $data = $request->all();
        if($data['matp']){
            $feeship = Feeship::where('fee_matp',$data['matp'])->where('fee_maqh',$data['maqh'])->where('fee_xaid',$data['xaid'])->get();
            if($feeship){
                $count_feeship = $feeship->count();
                if($count_feeship>0){
                     foreach($feeship as $key => $fee){
                        Session::put('fee',$fee->fee_feeship);
                        Session::save();
                    }
                }else{
                    Session::put('fee',10000);
                    Session::save();
                }
            }

        }
    }
    //delete phi
    public function del_fee(){
        Session::forget('fee');
        return redirect()->back();
    }

    // comfirm order
    public function confirm_order(Request $request){
        $data = $request->all();
        //get coupon giam so luong giam gia
        if($data['order_coupon']!='no'){
            $coupon = Coupon::where('coupon_code',$data['order_coupon'])->first();
            $coupon->coupon_used = $coupon->coupon_used.','.Session::get('customer_id');
            $coupon->coupon_time = $coupon->coupon_time - 1;
            $coupon_mail = $coupon->coupon_code;
            $coupon->save();
           }else{
             $coupon_mail = 'không có sử dụng';
           }

        //get shipping
        $shipping = new Shipping();
        $shipping->shipping_name = $data['shipping_name'];
        $shipping->shipping_email = $data['shipping_email'];
        $shipping->shipping_phone = $data['shipping_phone'];
        $shipping->shipping_address = $data['shipping_address'];
        $shipping->shipping_notes = $data['shipping_notes'];
        $shipping->shipping_method = $data['shipping_method'];
        $shipping->save();
        $shipping_id = $shipping->shipping_id;

        $checkout_code = substr(md5(microtime()),rand(0,26),5);

        //get order
        $order = new Order;
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = $shipping_id;
        $order->order_status = 1;
        $order->order_code = $checkout_code;

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order->created_at = now();
        $order->save();

        // if(Session::get('cart')==true){
        //    foreach(Session::get('cart') as $key => $cart){
        //        $order_details = new OrderDetails;
        //        $order_details->order_code = $checkout_code;
        //        $order_details->$cart->product_id;
        //        $order_details->$cart->product_name;
        //        $order_details->$cart->product_price;
        //        $order_details->$cart->qty;
        //        $order_details->product_coupon =  $data['order_coupon'];
        //        $order_details->product_feeship = $data['order_fee'];
        //        $order_details->save();
        // //        $data['id'] = $product_info->product_id;
        // //   $data['qty'] = $quantity;
        // //   $data['name'] = $product_info->product_name;
        // //   $data['price'] = $product_info->product_price;
        //    }
        // }
        // Session::forget('coupon');
        // Session::forget('fee');
        // Session::forget('cart');
   }

    public function login_checkout(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $slider_product = DB::table('tbl_slider')->where('slider_status','0')->orderby('slider_id','desc')->limit(3)->get();
        return view('fontend.checkout.login_checkout')->with('category',$cate_product)->with('slider',$slider_product);
    }

    public function add_customer(Request $request){

    	$data = array();
    	$data['customer_name'] = $request->customer_name;
    	$data['customer_phone'] = $request->customer_phone;
    	$data['customer_email'] = $request->customer_email;
    	$data['customer_password'] = md5($request->customer_password);

    	$customer_id = DB::table('tbl_customer')->insertGetId($data);

    	Session::put('customer_id',$customer_id);
    	Session::put('customer_name',$request->customer_name);
    	return Redirect::to('/checkout');


    }

    public function checkout(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $slider_product = DB::table('tbl_slider')->where('slider_status','0')->orderby('slider_id','desc')->limit(3)->get();
        $city = City::orderby('matp','ASC')->get();
         return view('fontend.checkout.show_checkout')->with('category',$cate_product)->with('slider',$slider_product)->with('city',$city);
    }

    public function checkout_customer(Request $request){
        $data = array();
    	$data['shipping_name'] = $request->shipping_name;
    	$data['shipping_phone'] = $request->shipping_phone;
    	$data['shipping_email'] = $request->shipping_email;
    	$data['shipping_notes'] = $request->shipping_notes;
        $data['shipping_address'] = $request->shipping_address;

    	$shipping_id = DB::table('tbl_sipping')->insertGetId($data);

    	Session::put('shipping_id',$shipping_id);

    	return Redirect::to('/payment');
    }

    public function logout_checkout(){
    	Session::flush();
    	return Redirect::to('/login-checkout');
    }

    public function login_customer(Request $request){
    	$email = $request->email_account;
    	$password = md5($request->password_account);
    	$result = DB::table('tbl_customer')->where('customer_email',$email)->where('customer_password',$password)->first();


    	if($result){
    		Session::put('customer_id',$result->customer_id);
    		return Redirect::to('/checkout');
    	}else{
    		return Redirect::to('/login-checkout');
    	}

    }

    public function payment(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $slider_product = DB::table('tbl_slider')->where('slider_status','0')->orderby('slider_id','desc')->limit(3)->get();
        return view('fontend.checkout.payment')->with('category',$cate_product)->with('slider',$slider_product);
    }

    public function order_place(Request $request){
        //insert payment method
        $data = array();
    	$data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đăng chờ xử lý';

    	$payment_id = DB::table('tbl_payment')->insertGetId($data);

          //insert order
          $order_data = array();
          $order_data['customer_id'] = Session::get('customer_id');
          $order_data['shipping_id'] = Session::get('shipping_id');
          $order_data['payment_id'] = $payment_id;
          $order_data['order_total'] = Cart::subtotal();
          $order_data['order_status'] = 'Đang chờ xử lý';
          $order_id = DB::table('tbl_order')->insertGetId($order_data);

          //insert order_details
        $content = Cart::content();
        foreach($content as $v_content){
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sales_quantity'] = $v_content->qty;
            DB::table('tbl_order_detail')->insert($order_d_data);

        }
        if($data['payment_method']==1){

            echo 'Thanh toán thẻ ATM';

        }elseif($data['payment_method']==2){
            Cart::destroy();

            $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
            $slider_product = DB::table('tbl_slider')->where('slider_status','0')->orderby('slider_id','desc')->limit(3)->get();

            return view('fontend.checkout.handcash')->with('category',$cate_product)->with('slider',$slider_product);
            //->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);

        }else{
            echo 'Thẻ ghi nợ';

        }


    }

    public function manage_order(){

        return view('admin.manage_order');
    }
    public function delete_order($orderId){
        DB::table('tbl_order')->where('order_id',$orderId)->delete();
        return Redirect::to('manage-order')->with('message','Xóa đơn hàng thành công');
    }


}
