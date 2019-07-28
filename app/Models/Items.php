<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = 'items';

    public $incrementing = false;

    /**
     * Like or unlike a song on behalf of a user.
     *
     * @param string $songId
     * @param User   $user
     *
     * @return Interaction
     */
    public static function toggleEnable($itemId)
    {
        if ($item = self::find($itemId)) {
            $item->active = !$item->active;
            $item->save();


            //event(new ItemEnableToggled($items));

            return $item;
        }

        return false;
    }

    public function carts()
    {
        return $this->hasMany('App\Models\Cart');
    }

    public function itemProps()
    {
        return $this->hasMany('App\Models\ItemProps', 'item_id');
    }

    public static function catalogVps()
    {
        return self::where('item_type', 'VPS-Package')->orderby('price')->get();
    }

    public static function catalogShared()
    {
        $list = self::where('item_type', 'Hosting-Package')->with('itemProps')->orderby('price')->limit(11)->get()->toArray();
        $list2 = [];
        foreach ($list as $key => $value) {
            $list2[$key] = $value;
            $list2[$key]['itemprops'] = array_column($value['item_props'], 'quantity', 'name');

            foreach ($list2[$key]['itemprops'] as $key2 => $value2) {
                unset($list2[$key]['itemprops'][$key2]);
                $key2 = explode('-', $key2)[1];
                $list2[$key]['itemprops'][$key2] = $value2;
            }

            unset($list2[$key]['item_props']);
        }

        return $list2;
    }
}
