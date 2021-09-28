<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
class AdminController extends Controller
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

    public function index(){
        return view('admin_login');
    }
    public function show_dashboard(){
        $this->AuthLogin();
        return view('admin.dashboard');
    }
    public function dashboard(Request $request){
        $admin_email = $request->admin_email;
        $admin_password = md5($request->admin_password);

        $result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        if($result){
            Session::put('admin_name', $result->admin_name);
            Session::put('admin_id', $result->admin_id);
            return Redirect::to('/dashboard');
        }else{
           // Session::put('message','Mat khau hoac tai khoan bi sai.Lam on nhap lai');
            return Redirect::to('/admin')->with('message','Mat khau hoac tai khoan bi sai.Lam on nhap lai');
        }
    }
    public function logout(){
        $this->AuthLogin();
        Session::put('admin_name', null);
        Session::put('admin_id', null);
        return Redirect::to('/admin');
    }

}
