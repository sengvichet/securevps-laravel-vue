<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartAddons extends Model
{
    public $timestamps = false;
    protected $fillable = ['addon_id', 'cart_id', 'value', 'end_date', 'total_hours'];

    public function items()
    {
        return $this->belongsTo('App\Models\Items', 'addon_id');
    }

    public function cart()
    {
        return $this->belongsTo('App\Models\Cart', 'cart_id');
    }
}
