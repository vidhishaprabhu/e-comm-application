<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
      'code','type','value','min_order_value',
      'expires_at','usage_limit','used_count'
    ];

    protected $dates = ['expires_at'];

    public function isValidFor($orderTotal)
    {
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->min_order_value && $orderTotal < $this->min_order_value) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        return true;
    }

    public function applyTo($orderTotal)
    {
        return $this->type === 'percent'
             ? round($orderTotal * ($this->value/100),2)
             : min($this->value, $orderTotal);
    }
}
