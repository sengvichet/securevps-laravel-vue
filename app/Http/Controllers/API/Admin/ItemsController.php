<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Items;
use App\Models\ItemProps;
use App\Http\Soap\WSSoapShev;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class ItemsController extends Controller
{

    function __construct()
    {
        # code...
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        return Items::all();
    }

    public function import()
    {
        // First we clean table
        DB::table('items')->truncate();

        // Import items to local db
        $sap = new WSSoapShev('inventory');
        $dataXml = xmlToArray($sap->callTo('GetAllItems'));
        $items = array_get($dataXml, 'Body.GetAllItemsResponse.GetAllItemsResult.NewDataSet.Table', []);
        $itemsProps = array_get($dataXml, 'Body.GetAllItemsResponse.GetAllItemsResult.NewDataSet.Table1', []);
        
    //    echo '<pre>';
    //    var_export($itemsProps); exit();

        foreach ($items as $key => $value) {
            $item = new Items;
            $item->id = $value['ItemCode'];
            $item->description = $value['ItemName'];
            $item->foreign_name = $value['FrgnName'];
            $item->msrp = $value['U_MSRPS'];
            $item->user_level = $value['U_LEVEL'];
            $item->item_type = $value['U_ITEMTYPE'];
            $item->item_os = $value['U_OSTYPE'];
            $item->uom = $value['U_UoM'];
            $item->uom_type = is_array(array_get($value, 'U_Type', ' ')) ? '': array_get($value, 'U_Type', ' ');
            //$item->mainItemType = $value['U_MainItemType'];
            $item->french_name = is_array(array_get($value, 'U_lang_french', ' ')) ? '': array_get($value, 'U_lang_french', ' ');
            $item->russian_name = is_array(array_get($value, 'U_lang_russian', ' ')) ? '': array_get($value, 'U_lang_russian', ' ');
            $item->arabic_name = is_array(array_get($value, 'U_lang_arabic', ' ')) ? '': array_get($value, 'U_lang_arabic', ' ');
            //add new column info
            $item->show_on_web = is_array($value['U_showOnWeb'])?'':$value['U_showOnWeb'];
            $item->online_provisioning = is_array($value['OnlineProvisioning'])?'':$value['OnlineProvisioning'];
            //
            $item->price = $value['Price'];
            $item->free_trial = 0;//$value['U_FREE_PERIOD_DAYS'];
            $item->billing = $value['U_BILLING_CYCLE'];
            $item->pro_rata_logic = $value['U_PRO_DATA_LOGIC'];

            $item->interval_slider = is_array(array_get($value, 'IntervalSliderValue', ' ')) ? '': array_get($value, 'IntervalSliderValue', ' ');
            $item->max_slider = is_array(array_get($value, 'AddonMaxSliderValue', ' ')) ? '': array_get($value, 'AddonMaxSliderValue', ' ');
            $item->min_slider = is_array(array_get($value, 'AddonMinSliderValue', ' ')) ? '': array_get($value, 'AddonMinSliderValue', ' ');
            $item->default_slider = is_array(array_get($value, 'DefualtSliderValue', ' ')) ? '': array_get($value, 'DefualtSliderValue', ' ');
            $item->website_image_file = is_array(array_get($value, 'WebSiteImageFile', ' ')) ? '': array_get($value, 'WebSiteImageFile', ' ');

            $item->save();
        }

        foreach ($itemsProps as $key => $value) {
            $itemProps = new ItemProps;
            $itemProps->name = $value['ChildItem'];
            $itemProps->item_id = $value['ParentItem'];
            $itemProps->quantity = $value['Quantity'];
            $itemProps->save();
        }

        return response()->json(true);
    }

    public function destroy()
    {
        return response()->json(DB::table('items')->truncate());
    }

    public function destroyAll()
    {
        DB::table('item_props')->truncate();
        return response()->json(DB::table('items')->truncate());
    }

    /**
     * [enable description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function enable(Request $request)
    {
        return response()->json(Items::toggleEnable($request->id));
    }

}
