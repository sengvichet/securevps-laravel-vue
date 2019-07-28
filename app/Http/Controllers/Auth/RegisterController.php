<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\ConfirmEmail;
use App\Mail\AddBpEmail;
use Validator;
use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use App\Http\Soap\WSSoapShev;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    //use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
    * _isStepCompleted.
    *
    */
    private function _isStepCompleted($step)
    {
        if (!session($step)) {
            \Redirect::to('/register')->send();
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:25|min:2',
            'last_name' => 'required|max:25|min:2',
            'email' => 'required|email|max:255|confirmed',
            'terms' => 'accepted',
        ]);
    }

    private $bulletstep = [
        'activestepa' => false,
        'activestepb' => false,
        'activestepc' => false,
        'activestepd' => false,
    ];

    /*
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $this->bulletstep['activestepa'] = 'active';
        $terms = \App\Models\LanguagesTerms::first();;
        return view('auth.register', ['bulletstep' => $this->bulletstep, 'terms' => $terms->hebrew, 'firstStepDone' => false]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    private function create(array $data)
    {
        $randomString = str_random(30);
        // only for test purpose
        //$randomString = 'rEGbOl0Okxhp50rC97G9UGneFRq6XA';

        $newUser = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'token' => $randomString,
        ]);

        if ($newUser) {
            $emailData = ['first_name'=>$data['first_name'], 'token'=>$randomString];
            Mail::to($data['email'])->send(new ConfirmEmail($emailData));
            // logg(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' ' . "[register new user, not exists in local db][email-link:http://shev.web/register/confirm/$randomString]", $data);
        }

        return $newUser;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $exist = User::where('email', $request->email)
                    ->where('verified', 0)
                    ->first();

        if ($exist) {
            $emailData = ['first_name'=>$request->first_name, 'token'=>$exist->token];
            Mail::to($request->email)->send(new ConfirmEmail($emailData));
            logg(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' ' . "[register new user, exists in local db][email-link:http://shev.web/register/confirm/$exist->token]", $request->all());
        } else {
            event(new Registered($user = $this->create($request->all())));
        }

        $exist = (bool) $exist;

        session(['regstep' => true]);

        flash(
            'הידד...',
            'נרשמת בהצלחה למערכת, כעת גש בבקשה לתיבת האימייל שלך ולחץ על לינק האישור בכדי שנוכל לוודא את כתובת המייל שלך ולהמשיך בתהליך ההרשמה',
            'success'
        );
        return redirect('/register/done');
    }

    public function firstStepDone()
    {
        $this->bulletstep['activestepa'] = 'active';
        return view('auth.register', ['bulletstep' => $this->bulletstep, 'firstStepDone' => true]);
    }

    /**
    * Confirm a user's email address.
    *
    * @param  string $token
    * @return mixed
    */
    public function confirmEmail($token)
    {
        $user = User::whereToken($token)->first();

        if ($user) {
            session(['userId' => $user->id]);
            session(['isStep' => true]);
            $user->verified = true;
            $user->token = null;
            $user->save();

            logg(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' ' . "[confirmed email, token:$token]");

            session(['regconfstep1'=>true]);
            return redirect('/register/phone');
        } else {
            return redirect('/register');
        }
    }

    /**
     * [phone description]
     * @return [type] [description]
     */
    public function phone()
    {
        $this->_isStepCompleted('regconfstep1');
        session(['regconfstep1' => false]);

        $this->bulletstep['activestepb'] = 'active';
        return view('auth/phone', ['bulletstep' => $this->bulletstep]);
    }

    /**
    * joinUs.
    *
    */
    public function joinUs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|digits_between:10,13',
        ]);

        if ($validator->fails()) {
            session(['regconfstep1' => true]);
            return redirect('/register/phone')
                        ->withErrors($validator)
                        ->withInput();
        }

        $sap = new WSSoapShev('reg');

//        $phone = '+972' . ltrim($request->phone, '0');
        $phone = $request->phone;
        session(['phone' => $request->phone]);
        session(['internationalphone' => $phone]);

        $params = [
            'PhoneNo' => $phone,
        ];

        $res = xmlToArray($sap->callTo('JoinUs', $params));
        $str = $res['Body']['JoinUsResponse']['JoinUsResult'];

        if ($str === "true") {
            session(['regconfstep2'=>true]);
            return redirect('/register/smscode');
        } else {

            flash(
                'מצטערים',
                'חלה שגיאה: ' . $str,
                'error'
            );
            return redirect('/register/phone');
        }
    }

    /**
    * smsCode.
    *
    */
    public function smsCode()
    {
        $this->_isStepCompleted('regconfstep2');
        session(['regconfstep2' => false]);

        $this->bulletstep['activestepc'] = 'active';
        return view('auth/smscode', ['bulletstep' => $this->bulletstep]);
    }

    /**
    * validateJoinUsSMSAuthCode.
    *
    */
    public function validateJoinUsSMSAuthCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'smscode' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            session(['regconfstep2' => true]);
            return redirect('/register/smscode')
                        ->withErrors($validator)
                        ->withInput();
        }

        // NOTE CANCEL THIS SERVICE -> ValidateJoinUsSMSAuthCode:
        // $sap = new WSSoapShev('reg');
        //
        // $params = [
        //     'PhoneNo' => session('internationalphone'),
        //     'activationCode' => $request->smscode,
        // ];
        //$res = xmlToArray($sap->callTo('ValidateJoinUsSMSAuthCode', $params));
        //$str = $res['Body']['ValidateJoinUsSMSAuthCodeResponse']['ValidateJoinUsSMSAuthCodeResult']['string'][1];
        // END:NOTE

        $str = "Success";
        if ($str === "Success") {

            logg(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' ' . "[Validate Join Us SMS AuthCode]", $request->all());

            session(['smscode' => $request->smscode]);
            session(['regconfstep3'=>true]);
            return redirect('/register/password');
        } else {
            session(['regconfstep1' => true]);

            flash(
                'מצטערים',
                'חלה שגיאה: ' . $str,
                'error'
            );
            return redirect('/register/phone');
        }
    }

    /**
    * password.
    *
    */
    public function password()
    {
        $this->_isStepCompleted('regconfstep3');
        session(['regconfstep3' => false]);

        $this->bulletstep['activestepd'] = 'active';
        return view('auth.password', ['bulletstep' => $this->bulletstep]);
    }

    /**
     * [setPassword description]
     * @param Request $request [description]
     */
    public function setPassword(Request $request)
    {
        //todo if validator fail he drop me out to reg page
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            session(['regconfstep3' => true]);
            return redirect('/register/password')
                        ->withErrors($validator)
                        ->withInput();
        }

        //$res = xmlToArray($this->addBp($request->password));
        $userData = User::findOrFail(session('userId'));

        $params = [
            'FirstName' => $userData->first_name,
            'LastName' => $userData->last_name,
            'Password' => $request->password,
            'Email' => $userData->email,
            'CellNumber' => session('internationalphone'),
            'AuthCode' => session('smscode'),
        ];

        $sap = new WSSoapShev('reg');

        $res = xmlToArray($sap->callTo('AddBP', $params, 'NewCustomer', 'XmlDoc', 'AddBP'));
        $res2 = xmlToArray($res['Body']['AddBPResponse']['AddBPResult']);
        $msg = $res2['Msg'];

        if ($msg === 'Success') {
            $newUserName = $res2['CustomerName'];
            $user = User::findOrFail(session('userId'));
            $emailData = ['firstName' => $user['first_name'], 'newUserName' => $newUserName];
            Mail::to($user['email'])->send(new AddBpEmail($emailData));
            User::destroy(session('userId'));

            //logg(__FILE__ . ':' . __LINE__ . ' ' . __METHOD__ . ' ' . "[set Password for the user]", $request->all());

            flash(
                'היי, משתמש חדש ' . $newUserName,
                "נרשמת בהצלחה, נא היכנס בצע כניסה באמצעות  $newUserName שם המשתמש והסיסמה שבחרת",
                'success'
            );
            return redirect('/login');
        } elseif ($msg = 'No SMS Auth. Code Record Found for current parameters.') {

            session(['regconfstep2' => true]);
            flash(
                'אופס...',
                'הקוד המסרון שהזנת אינו תקין, נסה שוב',
                'error'
            );
            return redirect('/register/smscode');
        }
    }

    /**
    * setPassword.
    *
    */
    private function addBp($password)
    {
        $userData = User::findOrFail(session('userId'));

        $sap = new WSSoapShev('reg');

        $params = [
            'FirstName' => $userData->first_name,
            'LastName' => $userData->last_name,
            'Password' => $password,
            'ConfirmPassword' => $password,
            'Email' => $userData->email,
            'AuthCode' => session('smscode'),
        ];

        return $sap->addBP($params);
    }
}
