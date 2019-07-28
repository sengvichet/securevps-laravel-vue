<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Soap\WSSoapShev;
use Illuminate\Support\Facades\Log;
use App\Models\LoggedSessions;
use Validator;
use App\Models\AccountList;

//use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    const USER_CREDENTIALS = 1;
    const ADMINISTRATOR = 2;

    //TODO use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    private $sap;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sap = new WSSoapShev('admin');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLogin()
    {
        return view('auth.adminlogin');
    }

    /**
     * login
     *
     * @return
     */
    public function postLogin(Request $request)
    {
        Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'smscode' => 'required',
        ])->validate();

        $params = [
            'userName' => $request->username,
            'password' => $request->password,
            'activationCode' => $request->smscode,
        ];

        $res = xmlToArray($this->sap->callTo('AdminLogin', $params));
        $str = array_get($res, 'Body.AdminLoginResponse.AdminLoginResult');
        $str1 = xmlToArray($str);
        $str2 = array_get($str1, 'Msg');

        if (is_null($str2)) {
            flash(
                'סליחה, אבל...',
                'שם המשתמש או הסיסמה שגויים',
                'error'
            );
            return redirect('/admin/login')
                        ->withInput();
        }

        if ($str2 === "Success") {
            $this->_prepareToCreateSessionInDb($request);

            logg(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' ' . "[login AdminLoginResponse]", $request->all());

            flash(
                'היי, מנהל ' . $request->username,
                'ברוך הבא לממשק הניהול האישי שלך',
                'success'
            );
            return redirect('/admin/users');
        } else {
            flash(
                'סליחה, אבל...',
                'שם המשתמש או הסיסמה שגויים',
                'error'
            );
            return redirect('/admin/login');
        }
    }

    /**
     * Send login sms.
     *
     * @return
     */
    public function sendMeSmsCodeForAdminLogin(Request $request)
    {
        Validator::make($request->all(), [
            'phone' => 'required|digits_between:10,13',
        ])->validate();

        $phone = $request->phone; //'+972' . ltrim($request->phone, '0');

        $params = [
            'phoneNo' => $phone,
        ];

        $res = xmlToArray($this->sap->callTo('SendSMSCodeforAdminLogin', $params));
        $str = array_get($res, 'Body.SendSMSCodeforAdminLoginResponse.SendSMSCodeforAdminLoginResult.string.1');

        if ($str === "Success") {
            logg(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' ' . "[sendLoginSms SendSMSCodeforAdminLogin]", $request->all());

            session(['loginphone' => $phone]);
            $content = [
                'success' => true,
            ];
        } else {
            $content = [
                'success' => false,
                'error' => $str,
            ];
        }

        return response([$content, 200, '']);
    }

    /**
     * Validate login sms.
     *
     * @return
     */
    public function validateLoginSms(Request $request)
    {
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

        ($bool) ? session(['showDomainListToUser' => true]) : session(['showDomainListToUser' => false]);

        logg(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' ' . "[validateLoginSms ValidateCredentialsWithCellAndSMS]", $request->all());

        $content = [
            'status' => $bool,
            'errorMessage' => $xmlRes,
        ];

        return response([$content, 200, '']);
    }

    /**
     * [accountList description]
     * @return [type] [description]
     */
    public function accountList()
    {
        if (!session('showDomainListToUser') || (session('loginphone')==='')) {
            flash(
                'סליחה, אבל...',
                'אין לך רשות להיכנס לדף זה ללא ביצוע לוגין',
                'error'
            );
            //return redirect('/login');
        }

        session(['showDomainListToUser' => false]);

        // login process
        $params = [
            'phoneNo' => session('loginphone'),
        ];

        $accounts = xmlToArray($this->sap->callTo('GetWebSiteUserNamesAndDomain_For_PhoneNo', $params));
        $accountsList = array_get($accounts, 'Body.GetWebSiteUserNamesAndDomain_For_PhoneNoResponse.GetWebSiteUserNamesAndDomain_For_PhoneNoResult.NewDataSet.Table', []);

        //dd($accountsList);

        return view('website.settings.accountlist', ['accounts' => $accountsList]);
    }

    /**
     * [accountList description]
     * @return [type] [description]
     */
    public function accountListForEmail($token)
    {
        $accountList = AccountList::whereToken($token)->first();

        if ($accountList) {
            $now = strtotime("now");
            $createdplushour = strtotime("+60 minutes", strtotime($accountList->created_at));

            $bool = $now < $createdplushour;

            if ($bool) {
                $params = [
                    'email' => $accountList->email,
                ];

                $sapbp = new WSSoapShev('bp');

                $accounts = xmlToArray($sapbp->callTo('GetWebSiteUserNames_For_Email', $params));
                $accountsList = array_get($accounts, 'Body.GetWebSiteUserNames_For_EmailResponse.GetWebSiteUserNames_For_EmailResult.NewDataSet.Table', []);

                return view('website.settings.accountlist', ['accounts' => $accountsList]);
            }
        }

        flash(
            'סליחה, אבל...',
            'תוקף האסימון שלך פג',
            'error'
        );
        return redirect('/login');
    }

    /**
     * [_prepareToCreateSessionInDb description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    private function _prepareToCreateSessionInDb(Request $request)
    {
        return $this->createSessionInDb($request);
    }

    /**
     * [createSessionInDb description]
     * @param  Request $request [description]
     * @param  [type]  $BPCode  [description]
     * @return [type]           [description]
     */
    private function createSessionInDb(Request $request)
    {
        LoggedSessions::destroy(\Session::getId());

        $loggedSessions = new LoggedSessions;
        $loggedSessions->id = \Session::getId();
        $loggedSessions->ip_address = \Request::ip();
        $loggedSessions->user_agent = \Request::server('HTTP_USER_AGENT');
        $loggedSessions->payload = '';
        $loggedSessions->last_activity = 0;
        $loggedSessions->user_name = $request->username;
        $loggedSessions->full_name = '';
        $loggedSessions->user_code = '';
        $loggedSessions->domain_name = '';
        $loggedSessions->login_type = self::USER_CREDENTIALS;
        $loggedSessions->user_type = self::ADMINISTRATOR;
        $loggedSessions->save();

        // session([
        //     'signedIn' => true,
        //     'userId' => \Session::getId(),
        //     'username' => $request->username,
        //     'admin' => true,
        // ]);

        session([
            'admin_signedIn' => true,
            'admin_userId' => \Session::getId(),
            'admin_username' => $request->username,
        ]);
    }

    /**
     * logout.
     *
     * @return
     */
    public function logout()
    {
        LoggedSessions::destroy(\Session::getId());
        \Session::flush();

        flash(
            'להתראות בפעם הבאה',
            'כעת אינך מחובר למערכת',
            'info'
        );
        return redirect('/');
    }
}
