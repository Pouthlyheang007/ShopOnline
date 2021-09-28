<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
class HomeController extends Controller
{
    public function index(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $slider_product = DB::table('tbl_slider')->where('slider_status','0')->orderby('slider_id','desc')->limit(3)->get();

        $all_product = DB::table('tbl_product')->where('product_status','0')->orderby('product_id','desc')->limit(6)->get();
        return view('fontend.home')->with('category',$cate_product)->with('all_product',$all_product)->with('slider',$slider_product);
    }

    public function tim_kiem(Request $request){
        //seo
        //$meta_desc = "Tìm kiếm sản phẩm";
        //$meta_keywords = "Tìm kiếm sản phẩm";
        //$meta_title = "Tìm kiếm sản phẩm";
        //$url_canonical = $request->url();
        //--seo
        $keywords = $request->keywords_submit;

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $slider_product = DB::table('tbl_slider')->where('slider_status','0')->orderby('slider_id','desc')->limit(3)->get();

        $search_product = DB::table('tbl_product')->where('product_name','like','%'.$keywords.'%')->get();


        return view('fontend.product.search')->with('category',$cate_product)->with('search_product',$search_product)->with('slider',$slider_product);
        //->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)
        //->with('url_canonical',$url_canonical);

    }
}
