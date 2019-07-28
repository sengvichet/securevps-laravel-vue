<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Validator;
use App\Http\Soap\WSSoapShev;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Class ProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Profile Controller
    |--------------------------------------------------------------------------
    |
    */
    private $sap;

    public function __construct()
    {
        $this->sap = new WSSoapShev('bp');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //todo what about if user user name not valid
        $user = $this->sap->callTo('GetBPDetails', ['BPCode' => session('BPCode')]);

        return view('website.settings.profile', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'second_email' => 'email',
            'phone' => 'required|digits_between:10,13',
            'second_phone' => 'digits_between:10,13',
            'fax' => 'digits:10',
        ])->validate();

        $res = xmlToArray($this->setBP($request->all(), session('BPCode')));

        $str = $res['Body']['SetBPDetailsResponse']['SetBPDetailsResult']['string'][1];

        if ($str === "Success") {

            logg(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' ' . "[save the edit profile form]", $request->all());

            flash(
                'הפרטים שהזנת נשמרו בהצלחה',
                'תודה שעדכנת את פרטיך במערכת',
                'success'
            );
            return redirect('/user/profile');
        } else {

            flash(
                'מצטערים',
                'הנתונים שהזנת לא נשמרו, חלה שגיאה: ' . $str,
                'error'
            );
            return redirect('/user/profile');
        }
    }

    /**
     * setBP.
     *
     */
    protected function setBP($request, $bpcode)
    {
        $params = [
            'CardCode' => $bpcode,
            'FirstName' => $request['first_name'],
            'LastName' => $request['last_name'],
            'Email' => $request['email'],
            'SecondEmail' => $request['second_email'],
            'CellNumber' => $request['phone'],
            'SecondCellNumber' => $request['second_phone'],
            'FaxNumber' => $request['fax'],
            'StreetAddress' => $request['street_address'],
            'City' => $request['city'],
            'Zip' => $request['zip'],
            'CompanyName' => $request['company_name'],
            'CompanyNumber' => $request['company_number'],
            'ContactPerson' => $request['contact_person'],
            'State' => $request['state'],
            'Country' => $request['country'],
            'Facebook' => $request['facebook'],
        ];

        return $this->sap->setBP($params, $bpcode);
    }
}
