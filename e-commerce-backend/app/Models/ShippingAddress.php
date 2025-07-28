<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $fillable = [
        'user_id', 'email', 'firstName', 'lastName',
        'address', 'city', 'country', 'state',
        'zip', 'phone', 'sameAsShipping'
    ];
}
