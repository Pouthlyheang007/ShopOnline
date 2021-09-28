<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;
session_start();

class CustomerController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
           return Redirect::to('dashboard');
        }else{
           return Redirect::to('Admini')->send();
        }
    }

    public function all_customer(){
        $this->AuthLogin();
        $all_customer = DB::table('tbl_customer')->get();
        $manager_customer = view('admin.all_customer')->with('all_customer',$all_customer);
        return view('admin_layout')->with('admin.all_customer',$manager_customer);
    }

    // public function manage_order(){
    //     $this->AuthLogin();
    //     $all_order = DB::table('tbl_order')
    //     ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
    //     ->select('tbl_order.*','tbl_customer.customer_name')
    //     ->orderby('tbl_order.order_id','desc')->get();
    //     $manager_order = view('admin.manage_order')->with('all_order',$all_order);
    //     return view('admin_layout')->with('admin.manage_order',$manager_order);
    // }

    // public function view_order($orderId){
    //     $this->AuthLogin();
    //     $order_by_id = DB::table('tbl_order')
    //     ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
    //     ->join('tbl_sipping','tbl_order.shipping_id','=','tbl_sipping.shipping_id')
    //     ->join('tbl_order_detail','tbl_order.order_id','=','tbl_order_detail.order_id')
    //     ->select('tbl_order.*','tbl_customer.*','tbl_sipping.*','tbl_order_detail.*')->first();
    //    // echo '<pre>';
    //    // print_r($order_by_id);
    //    //echo '</pre>';
    //     $manager_order_by_id  = view('admin.view_order')->with('order_by_id',$order_by_id);
    //    return view('admin_layout')->with('admin.view_order', $manager_order_by_id);

    // }

}
