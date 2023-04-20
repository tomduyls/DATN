<?php

namespace App\Utilities;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;

class Common
{
    public static function uploadFile($file, $path)
    {
        $file_name_original = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $file_name_without_extension = Str::replaceLast('.'.$extension, '', $file_name_original);

        $str_time_now = Carbon::now()->format('ymd_his');
        $file_name = Str::slug($file_name_without_extension) . '_' . uniqid() . '_' . $str_time_now . '.' . $extension;

        $file->move($path, $file_name);

        return $file_name;
    }

    public static function percentageDiscount()
    {
        $discount = str_replace( ',', '', Cart::discount());
        $price_total = str_replace( ',', '', Cart::priceTotal());
        $percentage_discount = 0;
        
        if($price_total > 0) $percentage_discount = $discount/$price_total * 100;

        return $percentage_discount;
    }

    public static function getFisrtCartItem()
    {
        
    }
}