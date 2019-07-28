<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Soap\WSSoapShev;
use Illuminate\Http\Request;

Class CreditCardController extends Controller
{
    protected $sapord;

    public function __construct()
    {
        $this->sapord = new WSSoapShev('invoice');
    }

    public function index()
    {
        $username = session('username');

        $res = xmlToArray($this->sapord->callTo('GetCCUserTokenInfo', ['username' => $username]));
        $res2 = array_get($res, 'Body.GetCCUserTokenInfoResponse.GetCCUserTokenInfoResult.NewDataSet.Table', []);

        return response()->json(['credit_cards' => $res2]);
    }

    public function destroy(Request $request)
    {
        $data = $request->all();
        $credit_card = $data['creditCard'];

        $username = session('username');

        // Call to "Set" with data to mark credit card as default
        $array = [
            'username' => $username,
            'Last4Digits' => $credit_card['CardLastDigits'],
            'expirationDate' => $credit_card['ExpirationDate'],
            'isDefault' => 'false',
            'removeToken' => 'true',
        ];

        $res = xmlToArray($this->sapord->callTo('SetCCUserTokenInfo', $array));

        $res2 = array_get($res, 'Body.SetCCUserTokenInfoResponse.SetCCUserTokenInfoResult', []);

        if($res2 === 'true') {
            return response()->json(['message' => 'Credit card removed successfully.']);
        } else {
            return response()->json(['message' => 'Removing credit card failed.'], 404);
        }
    }

    public function markAsDefault(Request $request)
    {
        $data = $request->all();
        $credit_card = $data['creditCard'];

        $username = session('username');

        // Call to "Set" with data to mark credit card as default
        $array = [
            'username' => $username,
            'Last4Digits' => $credit_card['CardLastDigits'],
            'expirationDate' => $credit_card['ExpirationDate'],
            'isDefault' => 'true',
            'removeToken' => 'false',
        ];

        $res = xmlToArray($this->sapord->callTo('SetCCUserTokenInfo', $array));

        $res2 = array_get($res, 'Body.SetCCUserTokenInfoResponse.SetCCUserTokenInfoResult', []);

        if($res2 === 'true') {
            return response()->json(['message' => 'Credit card marked as default successfully.']);
        } else {
            return response()->json(['message' => 'Marking credit card as default failed.'], 404);
        }
    }

}
