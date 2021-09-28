<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'coupon_name', 'coupon_code', 'coupon_time','coupon_number', 'coupon_condition','coupon_used','coupon_date_start'
        ,'coupon_date_end','coupon_status'
    ];
    protected $primaryKey = 'coupon_id';
 	protected $table = 'tbl_coupon';

    // public function product(){
    //     return $this->belongsTo('App\Models\Product','comment_product_id');
    // }
}
