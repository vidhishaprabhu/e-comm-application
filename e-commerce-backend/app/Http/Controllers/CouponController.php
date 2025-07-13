<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index() {
      return Coupon::all();
    }
    public function store(Request $req) {
      $data = $req->validate([
        'code'=>'required|unique:coupons',
        'type'=>'required|in:fixed,percent',
        'value'=>'required|numeric|min:0.01',
        'min_order_value'=>'nullable|numeric|min:0',
        'expires_at'=>'nullable|date',
        'usage_limit'=>'nullable|integer|min:1'
      ]);
      $coupon = Coupon::create($data);
      return response()->json($coupon,201);
    }

    public function applyCoupon(Request $req) {
      $req->validate([
        'code'=>'required|string',
        'cart_total'=>'required|numeric|min:0'
      ]);
      $coupon = Coupon::where('code',$req->code)->first();
      if(!$coupon || ! $coupon->isValidFor($req->cart_total)) {
        return response()->json(['error'=>'Invalid or expired coupon'],422);
      }
      $discount = $coupon->applyTo($req->cart_total);
      $coupon->increment('used_count');
      return response()->json([
        'code'=>$coupon->code,
        'type'=>$coupon->type,
        'value'=>$coupon->value,
        'discount'=>$discount,
        'new_total'=>round($req->cart_total - $discount,2)
      ]);
    }
}
