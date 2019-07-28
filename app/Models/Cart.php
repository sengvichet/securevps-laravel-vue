<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CartAddons;

/**
 *
 */
class Cart extends Model
{
    public function items()
    {
        return $this->belongsTo('App\Models\Items', 'item_id');
    }

    public function itemAddons()
    {
        return $this->belongsToMany('App\Models\Items', 'cart_addons', 'cart_id', 'addon_id')->withPivot('value', 'end_date', 'total_hours')->wherePivot('value', '>', 0);
    }

    public static function deleteWithAddons($cartId)
    {
        if (CartAddons::where('cart_id', $cartId)->delete() &&
            self::find($cartId)->delete()) {
            return true;
        } else {
            return false;
        }
    }
}
