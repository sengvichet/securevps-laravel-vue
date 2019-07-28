<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Soap\WSSoapShev;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\LoggedSessions;
use Validator;
use App\Models\AccountList;
use Carbon\Carbon;

//use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
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
    const CUSTOMER = 1;

    //TODO use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

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
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * login
     *
     * @return
     */
    public function login(Request $request)
    {
        $statistics = [
            'datetimeStamp' => Carbon::now('Asia/JERUSALEM')->format('Y-m-d\TH:i:s'),
            'fromPage' => "LoginPage",
            'actionType' => 'Login with Username',
            'valueSent' => $request->username,
            'OS' => getOS(),
            'browser' => getBrowser(),
            'IP' => request()->ip(),
        ];

        $this->sapInsert = new WSSoapShev('reg');
        $res = xmlToArray($this->sapInsert->callTo('InsertSapLogs', $statistics));

        Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ])->validate();

        $params = [
            'userName' => $request->username,
            'password' => $request->password,
        ];

        $res = xmlToArray($this->sap->callTo('ValidateUserName_and_Password', $params));
        $str = array_get($res, 'Body.ValidateUserName_and_PasswordResponse.ValidateUserName_and_PasswordResult.string.1');

        if (is_null($str)) {
            flash(
                'סליחה, אבל...',
                'שם המשתמש או הסיסמה שגויים',
                'error'
            );
            return redirect('/login')
                        ->withInput();
        }

        if ($str === "Success") {

            \Session::put('websiteUserName', $request->username);

            $this->_prepareToCreateSessionInDb($request);

            flash(
                'היי, משתמש ' . $request->username,
                'ברוך הבא לממשק הניהול האישי שלך',
                'success'
            );

            //if user login from cart send him to payment page
            if (session('redirectAfterLogin')) {
                $redirectTo = session('redirectAfterLogin');
                session()->forget(['redirectAfterLogin']);
                return redirect($redirectTo);
            }

            return redirect('/user/domainSpaces');
        } else {
            flash(
                'סליחה, אבל...',
                'שם המשתמש או הסיסמה שגויים',
                'error'
            );
            return redirect('/login');
        }
    }

    /**
     * Send login sms.
     *
     * @return
     */
    public function sendMeSmsCodeForLogin(Request $request)
    {
        $statistics = [
            'datetimeStamp' => Carbon::now('Asia/JERUSALEM')->format('Y-m-d\TH:i:s'),
            'fromPage' => "LoginPage",
            'actionType' => 'Login with SMS',
            'valueSent' => $request->phone['phone'],
            'OS' => getOS(),
            'browser' => getBrowser(),
            'IP' => request()->ip(),
        ];

        $this->sapInsert = new WSSoapShev('reg');
        $res = xmlToArray($this->sapInsert->callTo('InsertSapLogs', $statistics));

        Validator::make($request->phone, [
            'phone' => 'required|digits_between:10,13',
            'captcha' => 'required'
        ])->validate();

//        $phone = '+972' . ltrim($request->phone, '0');
        $phone = $request->phone['phone'];

        $params = [
            'phoneNo' => $phone,
        ];

        $res = xmlToArray($this->sap->callTo('SendSMSwithTempPassword_UsingCellinput', $params));
        $str = $res['Body']['SendSMSwithTempPassword_UsingCellinputResponse']['SendSMSwithTempPassword_UsingCellinputResult']['string'][1];

        if ($str === "Success") {
            //logg(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' ' . "[sendLoginSms SendSMSwithTempPassword_UsingCellinput]", $request->all());

            session(['loginphone' => $phone]);
            // $content = [
            //     'success' => true,
            // ];
            return response()->json(['success' => true]);
        } else {
            // $content = [
            //     'success' => false,
            //     'error' => $str,
            // ];
            return response()->json(['error' => $str], 500);
        }

        // return response([$content, 200, '']);
        // return response()->json([$content]);
    }

    /**
     * Validate login sms.
     *
     * @return
     */
    public function validateMySmsCodeForLogin(Request $request)
    {
        $statistics = [
            'datetimeStamp' => Carbon::now('Asia/JERUSALEM')->format('Y-m-d\TH:i:s'),
            'fromPage' => "LoginPage",
            'actionType' => 'Login with SMS',
            'valueSent' => $request->smscode,
            'OS' => getOS(),
            'browser' => getBrowser(),
            'IP' => request()->ip(),
        ];

        $this->sapInsert = new WSSoapShev('reg');
        $res = xmlToArray($this->sapInsert->callTo('InsertSapLogs', $statistics));

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

        //$str = $res['Body']['GetWebSiteUserNamesAndDomain_For_PhoneNoResponse'];

        //logg(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' ' . "[createSessionInDbforCell GetWebSiteUserNamesAndDomain_For_PhoneNo]", $request->all());

        // then redirect

        return response([$content, 200, '']);
    }

    /**
     * [accountList description]
     * @return [type] [description]
     */
    public function accountList()
    {
        // login process
        $params = [
            'phoneNo' => session('loginphone'),
        ];

        $statistics = [
            'datetimeStamp' => Carbon::now('Asia/JERUSALEM')->format('Y-m-d\TH:i:s'),
            'fromPage' => "LoginPage",
            'actionType' => 'Login with SMS',
            'valueSent' => $params['phoneNo'],
            'OS' => getOS(),
            'browser' => getBrowser(),
            'IP' => request()->ip(),
        ];

        $this->sapInsert = new WSSoapShev('reg');
        $res = xmlToArray($this->sapInsert->callTo('InsertSapLogs', $statistics));

        if (!session('showDomainListToUser') || (session('loginphone')==='')) {
            flash(
                'סליחה, אבל...',
                'אין לך רשות להיכנס לדף זה ללא ביצוע לוגין',
                'error'
            );
            return redirect('/login');
        }

        session(['showDomainListToUser' => false]);

        $accounts = xmlToArray($this->sap->callTo('GetWebSiteUserNamesAndDomain_For_PhoneNo', $params));
        $accountsList = array_get($accounts, 'Body.GetWebSiteUserNamesAndDomain_For_PhoneNoResponse.GetWebSiteUserNamesAndDomain_For_PhoneNoResult.NewDataSet.Table', []);
        $collection = collect($accountsList);
        $unique = $collection->unique('U_WEBSITE_USERNAME')->values()->toArray();

        foreach ($unique as $it => $newItem) {
            $unique[$it]['U_DOMAIN_NAME'] = [];
            foreach ($accountsList as $key => $value){
                if(($value['U_WEBSITE_USERNAME'] == $newItem['U_WEBSITE_USERNAME']) && !empty($value['U_DOMAIN_NAME'])) {
                    array_push($unique[$it]['U_DOMAIN_NAME'],$value['U_DOMAIN_NAME']);
                }
            }
        }

        return view('website.settings.accountlist', ['accounts' => $unique]);
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
     * [loginWithAccountName description]
     * @return [type] [description]
     */
    public function loginWithAccountName(Request $request)
    {
        $statistics = [
            'datetimeStamp' => Carbon::now('Asia/JERUSALEM')->format('Y-m-d\TH:i:s'),
            'fromPage' => "LoginPage",
            'actionType' => 'Login with Username',
            'valueSent' => $request->username,
            'OS' => getOS(),
            'browser' => getBrowser(),
            'IP' => request()->ip(),
        ];

        $this->sapInsert = new WSSoapShev('reg');
        $res = xmlToArray($this->sapInsert->callTo('InsertSapLogs', $statistics));

        Validator::make($request->all(), [
            'username' => 'required',
            'bpcode' => 'required',
        ])->validate();

        if (!empty(json_decode($request->domains))) {
            session(['domains' => json_decode($request->domains)]);
            session(['domainsCount' => $request->domainsCount]);
        };
        $this->createSessionInDb($request, $request->bpcode);

        //logg(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' ' . "[login loginWithAccountName]", $request->all());

        flash(
            'היי, משתמש ' . $request->username,
            'ברוך הבא לממשק הניהול האישי שלך',
            'success'
        );

        return redirect('/user/domainSpaces');
    }

    /**
     * [_prepareToCreateSessionInDb description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    private function _prepareToCreateSessionInDb(Request $request)
    {
        $sapbp = new WSSoapShev('bp');

        $userCodeArr = xmlToArray($sapbp->callTo('GetBPCode', ['WebsiteUserName' => $request->username]));
        $userCode = $userCodeArr['Body']['GetBPCodeResponse']['GetBPCodeResult'];
        $BPCode = $userCode['string'][2];

        $this->createSessionInDb($request, $BPCode);
    }

    /**
     * [createSessionInDb description]
     * @param  Request $request [description]
     * @param  [type]  $BPCode  [description]
     * @return [type]           [description]
     */
    private function createSessionInDb(Request $request, $BPCode)
    {
        $sapbp = new WSSoapShev('bp');

        $user = $sapbp->callTo('GetBPDetails', ['BPCode' => $BPCode]);

        $firstName = $user['first_name'];
        $lastName = $user['last_name'];
        $password = $user['password'];

        LoggedSessions::destroy(\Session::getId());

        $loggedSessions = new LoggedSessions;
        $loggedSessions->id = \Session::getId();
        $loggedSessions->ip_address = \Request::ip();
        $loggedSessions->user_agent = \Request::server('HTTP_USER_AGENT');
        $loggedSessions->payload = "xx";
        $loggedSessions->last_activity = 123;
        $loggedSessions->user_name = $request->username;
        $loggedSessions->full_name = $firstName . ' ' . $lastName;
        $loggedSessions->user_code = $BPCode;
        $loggedSessions->domain_name = '';
        $loggedSessions->login_type = self::USER_CREDENTIALS;
        $loggedSessions->user_type = self::CUSTOMER;
        $loggedSessions->save();

        session([
            'signedIn' => true,
            'userId' => \Session::getId(),
            'username' => $request->username,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'password' => $password,
            'BPCode' => $BPCode,
        ]);
    }

    /**
     * logout.
     *
     * @return
     */
    public function logout()
    {
        if(\Session::has('getCookieResult')){
            session()->forget('getCookieResult');
        }

        if (session('admin_signedIn')) {
            session()->forget(['signedIn', 'userId', 'username', 'firstName', 'lastName', 'password']);
            return redirect('/admin/users');
        } else {
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

    /** check auth user click "Cookie Policy" close */
    public function cookiePolicyStatus(Request $request){
          $reqResult = $request->close;

        if($reqResult == 1){
            $userIP = \Request::ip();
            $date = Carbon::now();
            $browser = \Request::server('HTTP_USER_AGENT');
            $username = \Session::get('username');


        }else if($reqResult == 2){
            $userIP = 'EMPTY';
            $date = 'EMPTY';
            $browser = 'EMPTY';
            $username = \Session::get('username');
        }

        $params = [
            'websiteUer' => $username,
            'ip' => $userIP,
            'date' => $date,
            'browser' => $browser,
            'status' => '1',
        ];

        $sapbp = new WSSoapShev('setcookie');

        $res = xmlToArray($sapbp->callTo('SetBPCookie', $params));

        $param = [
            'res' => $res,
            'request' => $reqResult,
        ];
        return $param;
    }
     public function closeCookieInfoForUser(){
         if(\Session::has('getCookieResult')){

             $cookieUserResult = \Session::get('getCookieResult');

             if($cookieUserResult == 1){
                 return 1;
             }else{
                 return 2;
             }
         }
     }

    public function callToUserCookiePolicyStatus(){
        $websiteUserName = \Session::get('websiteUserName');

        $params = [
            'websiteUer' => $websiteUserName
        ];

        $sapbp = new WSSoapShev('getcookie');
        $res = xmlToArray($sapbp->callTo('GetBPCookie', $params));
        $getCookieResult = array_get($res, 'Body.GetBPCookieResponse.GetBPCookieResult.NewDataSet.Table.U_User_DetailsCookie', []);

        if(!empty($getCookieResult)){

            $findme = 'EMPTY';
            $pos = strpos($getCookieResult, $findme);

            if ($pos === false) {
                \Session::put('getCookieResult', 1);
            } else {
                \Session::put('getCookieResult', 0);
            }

        }else{
            \Session::put('getCookieResult', 0);
        }

        $this->closeCookieInfoForUser();

        $par = [
            'cookieUserResult' => \Session::get('getCookieResult'),
            'getCookieResult' => $getCookieResult
        ];
            return $par;
     }


}
