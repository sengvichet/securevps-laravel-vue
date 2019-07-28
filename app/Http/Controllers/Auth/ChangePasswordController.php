<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoggedSessions;
use Illuminate\Http\Request;
use App\Http\Soap\WSSoapShev;
use Validator;

//use Illuminate\Foundation\Auth\ResetsPasswords;

class ChangePasswordController extends Controller
{
    private $sap;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->sap = new WSSoapShev('bp');
    }

    /**
     * Show the application's change password form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPasswordForm()
    {
        return view('website.settings.password');
    }

    /**
     * Store new password.
     *
     * @return
     */
    public function store(Request $request)
    {
        $sapbp = new WSSoapShev('bp');
        $user = $sapbp->callTo('GetBPDetails', ['BPCode' => session('BPCode')]);

        Validator::make($request->all(), [
            'current_password' => 'required|min:6',
            'password' => 'required|min:6|confirmed',
        ])->validate();

        $currentPassword = session('password');
        if($request['current_password'] == $currentPassword){

            $params = [
                'userName' => session('username'),
                'newPassword' => $request->password,
            ];

            $res = xmlToArray($sapbp->callTo('UpdatePassword', $params));
            $str = $res['Body']['UpdatePasswordResponse']['UpdatePasswordResult'];

            if($str === 'true') {
                session(['password' => $params['newPassword']]);

                if (\Session::has('getCookieResult')) {
                    session()->forget('getCookieResult');
                }
                LoggedSessions::destroy(\Session::getId());
                \Session::flush();
                flash(
                    'שינית את הסיסמה בהצלחה !',
                    'אתה עכשיו תנותק מהחשבון ותצטרך להתחבר מחדש עם הסיסמה החדשה',
                    'success'
                );

                return redirect('/login');
            } else {
                flash(
                    'מצטערים',
                    'חלה שגיאה בעת הניסיון לשנות את הסיסמה',
                    'error'
                );
            }

            logg(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' ' . "[save the new password]", $request->all());

        } else {
            flash(
                'Wrong current password',
                'Your typed current password is incorrect',
                'error'
            );
        }
        return redirect('/password/change');
    }
}
