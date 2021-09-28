<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
class SliderController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function add_slider(){
        $this->AuthLogin();
        return view('admin.add_slider');
    }

    public function save_slider(Request $request){
        $this->AuthLogin();
        $data = array();
        $data['slider_title'] = $request->slider_title;
        $data['slider_desc'] = $request->slider_desc;
        $data['slider_status'] = $request->slider_status;

        $gete_image = $request->file('slider_image');
        if($gete_image){
            $gete_name_image = $gete_image->getClientOriginalName();
            $namer_image = current(explode('.',$gete_name_image));
            $newe_image = $namer_image.rand(0,99).'.'.$gete_image->getClientOriginalExtension();
            $gete_image->move('upload/slider',$newe_image);
            $data['slider_image'] = $newe_image;
            DB::table('tbl_slider')->insert($data);
            return Redirect::to('all-slider')->with('message','Thêm slide thành công');
        }
        $data['slider_image'] = '';
       DB::table('tbl_slider')->insert($data);
       return Redirect::to('all-slider')->with('message','Thêm slide thành công');
    }

    public function all_slider(){
        $this->AuthLogin();
        $all_slider = DB::table('tbl_slider')->get();
        $manager_slider = view('admin.all_slider')->with('all_slider',$all_slider);
        return view('admin_layout')->with('admin.all_slider',$manager_slider);
    }

    public function unactive_slider($slider_id){
        $this->AuthLogin();
        DB::table('tbl_slider')->where('slider_id',$slider_id)->update(['slider_status'=>1]);
        return Redirect::to('all-slider')->with('message','Ấn slide thành công');
    }

    public function active_slider($slider_id){
        $this->AuthLogin();
        DB::table('tbl_slider')->where('slider_id',$slider_id)->update(['slider_status'=>0]);
        return Redirect::to('all-slider')->with('message','Hiển thị slide thành công');
    }

    public function edit_slider($slider_id){
        $this->AuthLogin();
        $slider_product = DB::table('tbl_slider')->orderby('slider_id','desc')->get();

        $edit_slider = DB::table('tbl_slider')->where('slider_id',$slider_id)->get();
        $manager_slider = view('admin.edit_slider')->with('edit_slider',$edit_slider)->with('slider_product',$slider_product);
        return view('admin_layout')->with('admin.edit_slider',$manager_slider);
    }

    public function update_slider(Request $request, $slider_id){
        $this->AuthLogin();
        $data = array();
        $data['slider_title'] = $request->slider_title;
        $data['slider_desc'] = $request->slider_desc;
        $data['slider_status'] = $request->slider_status;

       $gete_image = $request->file('slider_image');
        if($gete_image){
            $gete_name_image = $gete_image->getClientOriginalName();
            $namer_image = current(explode('.',$gete_name_image));
            $newe_image = $namer_image.rand(0,99).'.'.$gete_image->getClientOriginalExtension();
            $gete_image->move('upload/slider',$newe_image);
            $data['slider_image'] = $newe_image;
            DB::table('tbl_slider')->where('slider_id',$slider_id)->update($data);
            return Redirect::to('all-slider')->with('message','Cập nhật slide thành công');
        }

        DB::table('tbl_slider')->where('slider_id',$slider_id)->update($data);
        return Redirect::to('all-slider')->with('message','Cập nhật slide thành công');
    }

    public function delete_slider($slider_id){
        $this->AuthLogin();
        DB::table('tbl_slider')->where('slider_id',$slider_id)->delete();
        return Redirect::to('all-slider')->with('message','Xóa slide thành công');
    }

}
