<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'coupon_id', 'id');
    }
}
