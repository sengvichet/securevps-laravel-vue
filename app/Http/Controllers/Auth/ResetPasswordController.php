<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Soap\WSSoapShev;
use App\Models\AccountList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use App\Mail\ResetPasswordEmail;
use App\Mail\AccountListEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\PasswordReset;

//use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    //use ResetsPasswords;

    private $sap;
    private $sapInsert;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sap = new WSSoapShev('login');
    }

    /**
    * showPasswordResetForm.
    *
    */
    public function showPasswordResetForm()
    {
        return view('website.settings.resetpassword');
    }

    /**
    * showPasswordResetForm.
    *
    */
    public function ResetByUsername(Request $request)
    {
        $statistics = [
            'datetimeStamp' => Carbon::now('Asia/JERUSALEM')->format('Y-m-d\TH:i:s'),
            'fromPage' => "ResetPasswordPage",
            'actionType' => 'Reset with Username',
            'valueSent' => $request->username,
            'OS' => getOS(),
            'browser' => getBrowser(),
            'IP' => request()->ip(),
        ];

        $this->sapInsert = new WSSoapShev('reg');
        $res = xmlToArray($this->sapInsert->callTo('InsertSapLogs', $statistics));

        Validator::make($request->all(), [
            'username' => 'required',
        ])->validate();

        session()->forget('usernameForSms');
        $username = $request->username;
        $sapbp = new WSSoapShev('bp');

        $user = xmlToArray($sapbp->callTo('GetBPDetailsByUserName', ['username' => $username]));
        $user = array_get($user, 'Body.GetBPDetailsByUserNameResponse.GetBPDetailsByUserNameResult.NewDataSet.Table');
        if (!empty($user)) {
            session(['usernameForSms' => $username]);
            return redirect('password/smsoremail');
        } else {
            return view('website.settings.notfoundusername');
        }

    }

    /**
    * showPasswordResetForm.
    *
    */
    public function showSmsOrEmailForm()
    {
        if(session('usernameForSms')) {
            $username = session('usernameForSms');
            return view('website.settings.smsoremail', compact('username'));
        } else {
            return view('website.settings.notfoundusername');
        }

    }

    /**
     * [ResetPasswordByEmailAccountsList description]
     * @param string $value [description]
     */
    public function ResetPasswordByEmailAccountsList(Request $request)
    {
        if(session('signedIn')) {
            $actionType = 'Reset with Email From Logged in user ' . session('username');
        } else {
            $actionType = 'Reset with Email';
        }

        $statistics = [
            'datetimeStamp' => Carbon::now('Asia/JERUSALEM')->format('Y-m-d\TH:i:s'),
            'fromPage' => "ResetPasswordPage",
            'actionType' => $actionType,
            'valueSent' => $request->email,
            'OS' => getOS(),
            'browser' => getBrowser(),
            'IP' => request()->ip(),
        ];

        $this->sapInsert = new WSSoapShev('reg');
        $res = xmlToArray($this->sapInsert->callTo('InsertSapLogs', $statistics));

        Validator::make($request->all(), [
                    'email' => 'required',
                    'g-recaptcha-response' => 'required'
                ])->validate();

        // TODO need to validate that the mail exists in service
        $sapbp = new WSSoapShev('bp');
        $hasDomain = xmlToArray($sapbp->callTo('GetWebSiteUserNames_For_RecoveryByEmail', ['email' => $request->email]));
        $hasDomain = array_get($hasDomain, 'Body.GetWebSiteUserNames_For_RecoveryByEmailResponse.GetWebSiteUserNames_For_RecoveryByEmailResult.NewDataSet.Table');
        if (!empty($hasDomain)) {
            $newToken = str_random(50);
            $accountList = new AccountList;
            $accountList->token = $newToken;
            $accountList->email = $request->email;
            $accountList->save();
            if(count($hasDomain) > 1) {
                $firstName = 'לקוח יקר,';
                $msg = 'קיבלנו בקשה לביצוע איפוס סיסמה לאחד החשבונות שלך.';
            } else {
                $firstName = $hasDomain[0]['U_CLIENT_FNAME'];
                $msg = 'קיבלנו בקשה לביצוע איפוס לחשבונך';
            }
            $emailData = ['first_name'=> $firstName, 'token'=> $newToken, 'msg'=> $msg, 'link'=> 'firstconfirm'];
            try {
                Mail::to($request->email)->send(new ResetPasswordEmail($emailData));
                if (empty(Mail::failures())) {
                    emailCount(true);
                } else {
                    emailCount(false);
                    return redirect('/');
                }
            }
            catch (\Exception $e) {
                emailCount(false);
                return redirect('/');
            }
        }
        \Session::flash('emailsent', true);
        return view('website.settings.checkemail', ['email' => $request->email]);
    }

    /**
     * [firstConfirm description]
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public function firstConfirm($token)
    {
        $passwordReset = AccountList::whereToken($token)->first();
        if (!empty($passwordReset)) {
            AccountList::whereToken($token)->first()->delete();
            // TODO need to validate that the mail exists in service
            $sapbp = new WSSoapShev('bp');
            $hasDomain = xmlToArray($sapbp->callTo('GetWebSiteUserNames_For_RecoveryByEmail', ['email' =>  $passwordReset->email]));
            $hasDomain = array_get($hasDomain, 'Body.GetWebSiteUserNames_For_RecoveryByEmailResponse.GetWebSiteUserNames_For_RecoveryByEmailResult.NewDataSet.Table');
            $collection = collect($hasDomain);
            $accounts = $collection->unique('U_WEBSITE_USERNAME')->values()->toArray();
            foreach ($accounts as $it => $newItem) {
                $accounts[$it]['U_DOMAIN_NAME'] = [];
                foreach ($hasDomain as $key => $value){
                    if(($value['U_WEBSITE_USERNAME'] == $newItem['U_WEBSITE_USERNAME']) && !empty($value['U_DOMAIN_NAME'])) {
                        array_push($accounts[$it]['U_DOMAIN_NAME'],$value['U_DOMAIN_NAME']);
                    }
                }
            }
            \Session::flash('emailsent', true);
            return view('website.settings.accounts', ['accounts' => $accounts, 'email' => $passwordReset->email]);
        } else {
            return view('website.settings.accounts', ['accounts' => null]);
        }

    }

    /**
     * [ResetPasswordByEmailb description]
     * @param string $value [description]
     */
    public function ResetPasswordByEmailb(Request $request)
    {
        $statistics = [
            'datetimeStamp' => Carbon::now('Asia/JERUSALEM')->format('Y-m-d\TH:i:s'),
            'fromPage' => "ResetPasswordPage",
            'actionType' => 'Reset with Email',
            'valueSent' => $request->email,
            'OS' => getOS(),
            'browser' => getBrowser(),
            'IP' => request()->ip(),
        ];

        $this->sapInsert = new WSSoapShev('reg');
        $res = xmlToArray($this->sapInsert->callTo('InsertSapLogs', $statistics));

        if (!empty($request->email) && !empty($request->username) && !empty($request->firstname)) {
            $email = $request->email;
            $username = $request->username;
            $firstName = $request->firstname;
            $randomString = str_random(50);
            $passwordReset = new PasswordReset;
            $passwordReset->email = $email;
            $passwordReset->username = $username;
            $passwordReset->token = $randomString;
            $passwordReset->save();

            $msg = 'לחיצה על הקישור המצורף תשלח אותך לדף איפוס הסיסמה. הקישור זמין לשעתיים בלבד ולאחר מכן יפוג תוקף.';
            $emailData = ['first_name'=> $firstName, 'token'=> $randomString, 'msg'=> $msg, 'link'=> 'confirm'];
            try {
                Mail::to($email)->send(new ResetPasswordEmail($emailData));
                if (empty(Mail::failures())) {
                    emailCount(true);
                } else {
                    emailCount(false);
                    return redirect('/');
                }
            }
            catch (\Exception $e) {
                emailCount(false);
                return redirect('/');
            }
            \Session::flash('emailsent', true);

            logg(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' ' . "[reset password by email new pass to user]", $request->all());

            flash(
                'איפוס הסיסמה בוצע',
                'בדוק אימייל על מנת להשלים את תהליך איפוס הסיסמה',
                'success'
            );
            return redirect('/password/resetbyemailb');

        } else {

            flash(
                'אופס...',
                'חלה שגיאה בעת הניסיון לאפס את הסיסמה',
                'error'
            );
            return redirect('/password/resetbyemailb')
                ->withInput();
        }
    }

    /**
    * showPasswordResetForm.
    *
    */
    public function showPasswordEmailResetForm()
    {
        return view('website.settings.resetpasswordemail');
    }

    /**
    * showPasswordSmsResetForm.
    *
    */
    public function showPasswordSmsResetForm()
    {
        session()->forget('loginphone');
        session()->forget('smssent');
        session()->forget('count');
        return view('website.settings.resetpasswordsms');
    }

    /**
     * ResetPasswordBySms.
     *
     */
    public function ResetPasswordBySms(Request $request)
    {
        $statistics = [
            'datetimeStamp' => Carbon::now('Asia/JERUSALEM')->format('Y-m-d\TH:i:s'),
            'fromPage' => "ResetPasswordPage",
            'actionType' => 'Reset with SMS',
            'valueSent' => $request->phone,
            'OS' => getOS(),
            'browser' => getBrowser(),
            'IP' => request()->ip(),
        ];

        $this->sapInsert = new WSSoapShev('reg');
        $res = xmlToArray($this->sapInsert->callTo('InsertSapLogs', $statistics));

        Validator::make($request->all(), [
            'phone' => 'required|digits_between:10,13',
            'g-recaptcha-response' => 'required'
        ])->validate();

//        $phone = '+972' . ltrim($request->phone, '0');
        $phone = $request->phone;

        $params = [
            'phoneNo' => $phone,
        ];

        $res = xmlToArray($this->sap->callTo('SendSMSwithTempPassword_UsingCellinput', $params));
        $str = $res['Body']['SendSMSwithTempPassword_UsingCellinputResponse']['SendSMSwithTempPassword_UsingCellinputResult']['string'][1];

        if ($str === "Success") {

            session(['loginphone' => $phone]);
            session(['smssent' => true]);
        }

        flash(
            'שליחת SMS',
            'ה-SMS נשלח בהצלחה למספר טלפון שנמצא במערכת. נא בדוק שקיבלת את המסרון.',
            'success'
        );
        return view('website.settings.resetpasswordsms');
    }

    /**
     * showCheckSmsCodeForm.
     *
     */
    public function showCheckSmsCodeForm()
    {
        return view('website.settings.resetpasswordsms');
    }
    /**
     * checkSmsCode.
     *
     */
    public function checkSmsCode(Request $request) {
        Validator::make($request->all(), [
            'smscode' => 'required',
        ])->validate();

        $params = [
            'phoneNo' => session('loginphone'),
            'validationCode' => $request->smscode,
        ];
        $xmlRes = xmlToArray($this->sap->callTo('ValidateCredentialsWithCellAndSMS', $params));
        $str = $xmlRes['Body']['ValidateCredentialsWithCellAndSMSResponse']['ValidateCredentialsWithCellAndSMSResult']['string'][1];

        $bool = ($str === 'Success');

        $request->session()->has('count')? $count = $request->session()->get('count'): $count = 0;

        if($bool) {
            $sapbp = new WSSoapShev('bp');
            $user = xmlToArray($sapbp->callTo('GetWebSiteUserNames_For_RecoveryByPhoneNum', ['phoneNum' => session('loginphone')]));
            $user = array_get($user, 'Body.GetWebSiteUserNames_For_RecoveryByPhoneNumResponse.GetWebSiteUserNames_For_RecoveryByPhoneNumResult.NewDataSet.Table');
            $collection = collect($user);
            $accounts = $collection->unique('U_WEBSITE_USERNAME')->values()->toArray();
            foreach ($accounts as $it => $newItem) {
                $accounts[$it]['U_DOMAIN_NAME'] = [];
                foreach ($user as $key => $value){
                    if(($value['U_WEBSITE_USERNAME'] == $newItem['U_WEBSITE_USERNAME']) && !empty($value['U_DOMAIN_NAME'])) {
                        array_push($accounts[$it]['U_DOMAIN_NAME'],$value['U_DOMAIN_NAME']);
                    }
                }
            }
            return view('website.settings.accounts',['data' => $accounts]);
        } else {
            $count++;
            session(['count' => $count]);
            if($count > 2) {
                flash(
                    'קוד שגוי',
                    'אנא נסה להזין את שם המשתמש מחדש',
                    'error'
                );
                $request->session()->forget('count');
                return redirect('/password/reset');
            } else {
                \Session::flash('smssent', true);
                flash(
                    'קוד שגוי',
                    'אנא נסה להזין את הקוד שנית, או חזור למסך הקודם לשליחת קוד SMS חדש',
                    'error'
                );
                return redirect('/password/resetbysms');
            }

        }
    }

    /**
     * ResetPasswordMethod.
     *
     */
    public function ResetPasswordMethod(Request $request)
    {
        $data = $request->all();

        if($data['method'] == 'email') {
            $actionType = 'Reset by Email from Username';
        } else {
            $actionType = 'Reset by SMS from Username';
        }

        $statistics = [
            'datetimeStamp' => Carbon::now('Asia/JERUSALEM')->format('Y-m-d\TH:i:s'),
            'fromPage' => "ResetPasswordPage",
            'actionType' => $actionType,
            'valueSent' => $request->username,
            'OS' => getOS(),
            'browser' => getBrowser(),
            'IP' => request()->ip(),
        ];

        $this->sapInsert = new WSSoapShev('reg');
        $res = xmlToArray($this->sapInsert->callTo('InsertSapLogs', $statistics));

        Validator::make($request->all(), [
            'username' => 'required',
            'g-recaptcha-response' => 'required',
            'method' => 'required',
        ])->validate();

        $method = $request['method'];
        $sapbp = new WSSoapShev('bp');
        $user = xmlToArray($sapbp->callTo('GetBPDetailsByUserName', ['username' => $request->username]));
        $user = array_get($user, 'Body.GetBPDetailsByUserNameResponse.GetBPDetailsByUserNameResult.NewDataSet.Table');
        if($user) {
            if($method == 'email') {

                $randomString = str_random(50);
                $firstName = $user['U_CLIENT_FNAME'];
                $email = $user['U_CLIENT_EMAIL1'];

                $passwordReset = new PasswordReset;
                $passwordReset->email = $email;
                $passwordReset->username = $request->username;
                $passwordReset->token = $randomString;
                $passwordReset->save();

                $msg = 'לחיצה על הקישור המצורף תשלח אותך לדף איפוס הסיסמה. הקישור זמין לשעתיים בלבד ולאחר מכן יפוג תוקף.';
                $emailData = ['first_name'=> $firstName, 'token'=> $randomString, 'msg'=> $msg, 'link'=> 'confirm'];
                try {
                    Mail::to($email)->send(new ResetPasswordEmail($emailData));
                    if (empty(Mail::failures())) {
                        emailCount(true);
                    } else {
                        emailCount(false);
                        return redirect('/');

                    }
                }
                catch (\Exception $e) {
                    emailCount(false);
                    return redirect('/');
                }
                \Session::flash('emailsent', true);
                logg(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' ' . "[reset password by email new pass to user]", $request->all());

                flash(
                    'איפוס הסיסמה בוצע',
                    'בדוק אימייל על מנת להשלים את תהליך איפוס הסיסמה',
                    'success'
                );
                return redirect('/password/reset');

            } else {
                $phone = $user['U_CLIENT_PHONE1'];
                $params = [
                    'phoneNo' => $phone,
                ];

                $res = xmlToArray($this->sap->callTo('SendSMSwithTempPassword_UsingCellinput', $params));
                $str = $res['Body']['SendSMSwithTempPassword_UsingCellinputResponse']['SendSMSwithTempPassword_UsingCellinputResult']['string'][1];

                if ($str === "Success") {
                    session(['loginphone' => $phone]);
                    session(['smssent' => true]);
                }

                flash(
                    'שליחת SMS',
                    'ה-SMS נשלח בהצלחה למספר טלפון שנמצא במערכת. נא בדוק שקיבלת את המסרון.',
                    'success'
                );
                return redirect('/password/resetbysms');
            }
        } else {
            return view('website.settings.notfoundusername');
        }
    }

    /**
     * [confirm description]
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public function confirm($token)
    {
        $passwordReset = PasswordReset::whereToken($token)->first();

        if ($passwordReset) {
            PasswordReset::whereToken($token)->first()->delete();
            $now = strtotime("now");
            $createdplushour = strtotime("+120 minutes", strtotime($passwordReset->created_at));
            $bool = $now < $createdplushour;

            if ($bool && ($passwordReset->used === 0)) {
                $passwordReset->used = 1;
                $passwordReset->save();
                session(['setNewPassUsername' => $passwordReset->username]);
                return view('website.settings.warningresetpassword');
            } else {
                // Code ..
            }

            logg(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' ' . "[confirmed email, token:$token]");
        } else {
            flash(
                'אופס...',
                'חלה שגיאה בעת הניסיון לאפס את הסיסמה',
                'error'
            );
            return redirect('/password/reset');
        }
    }

    /**
     * [setNewPass description]
     */
    public function setNewPass(Request $request)
    {
        $username = $request->username;
        if (isset($username) && !is_null($username)) {
            session(['setNewPassUsername' => $username]);
            return view('auth.setpassword', ['username' => $username]);
        } else {
            return redirect('/password/reset');
        }
    }

    /**
     * [storeNewPass description]
     * @param string $value [description]
     */
    public function storeNewPass(Request $request)
    {
        Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
        ])->validate();

        $params = [
            'userName' => session('setNewPassUsername'),
            'newPassword' => $request->password,
        ];

        $sapbp = new WSSoapShev('bp');
        $res = xmlToArray($sapbp->callTo('UpdatePassword', $params));
        $str = $res['Body']['UpdatePasswordResponse']['UpdatePasswordResult'];

        if ($str === 'true') {
            if(session('setNewPassUsername') == session('username')) {
                session(['password' => $params['newPassword']]);
            }
            \Session::forget('setNewPassUsername');
            flash(
                'הסיסמה שונתה בהצלחה',
                'כעת תוכל להתחבר באמצעות הסיסמה החדשה שבחרת',
                'success'
            );
        } else {
            flash(
                    'אופס...',
                    'חלה שגיאה בעת הניסיון לשנות את הסיסמה',
                    'error'
                );
        }

        logg(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' ' . "[save the new password]", $request->all());
        if(session('signedIn')) {
            return redirect('/user/domainSpaces');
        }
        return redirect('/login');
    }
}
