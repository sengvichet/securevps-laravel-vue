<?php

use App\Mail\EmailLimit;
use App\Models\EmailLimits;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

function flash($title, $text, $type, $timer = false)
{
    \Session::flash('title', $title);
    \Session::flash('text', $text);
    \Session::flash('type', $type);
    ($timer) ? \Session::flash('timer', true): null;
}

function loggxml($key, $value, $params=[])
{
    App\Http\Utils\Logg::loggxml($key, $value, $params);
}

function logg($str, $arr = [])
{
    //debug_print_backtrace();
    App\Http\Utils\Logg::logg($str, $arr);
}

function getXmlByKey($xml, $tag)
{
    $xmlDoc = new \DOMDocument();
    $xmlDoc->loadXML($xml);

    if ($xmlDoc) {
        return $xmlDoc->getElementsByTagName($tag)->item(0)->nodeValue;
    } else {
        return false;
    }
}

function xmlToArray($xmlstring) {

    $clean_xml = str_ireplace(['SOAP-ENV:', 'SOAP:'], '', $xmlstring);

    return json_decode(json_encode(simplexml_load_string($clean_xml)), true);
}

function setActive ($uri) {
    if(Request::path() === ltrim($uri, '/')) {
        echo 'active';
    }
}

function filterWebspace ($in) {
    return (int) $in . ' GB';
}
function filterWebspaceMB ($in) {
    return (int) $in . 'MB';
}

function filterBandwidth ($in) {
    return (int) ($in/1024).'GB';
}
function filterBandwidthMB ($in) {
    return 'MB ' . (int) ($in/1024);
}

function filterQty ($in) {
    return (int) $in . ' יח\'';
}

function emailCount ($mail_sent) {
    if(EmailLimits::count() == 0){
        EmailLimits::create(['limit' => 120]);
    }
    $data = EmailLimits::whereDate('updated_at', Carbon::today())->first();
    if(empty($data) || is_null($data)) {
        $update = EmailLimits::where('id',1)->update(['count' => 0]);
        if($update) {
            $data = EmailLimits::whereDate('updated_at', Carbon::today())->first();
        }
    }
    if ($mail_sent) {
        if ($data->count < $data->limit) {
            $data->count = $data->count + 1;
            if($data->count == ($data->limit-1)) {

                Mail::to('hosting@shev.com')->send(new EmailLimit());
                $data->count = 0;
            }
            $data->save();
        }
    } else {
        flash(
            'מתנצלים לא ניתן לשלוח אליך אימייל כרגע',
            'נא פנה אל התמיכה בטלפון: 03-6421228  וציין קוד 1426 אימייל כדי שנוכל לעזור לך',
            'error'
        );
    };
}

function getOS() {

    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $os_platform  = "Unknown OS Platform";

    $os_array     = array(
        '/windows nt 10/i'      =>  'Windows 10',
        '/windows nt 6.3/i'     =>  'Windows 8.1',
        '/windows nt 6.2/i'     =>  'Windows 8',
        '/windows nt 6.1/i'     =>  'Windows 7',
        '/windows nt 6.0/i'     =>  'Windows Vista',
        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'     =>  'Windows XP',
        '/windows xp/i'         =>  'Windows XP',
        '/windows nt 5.0/i'     =>  'Windows 2000',
        '/windows me/i'         =>  'Windows ME',
        '/win98/i'              =>  'Windows 98',
        '/win95/i'              =>  'Windows 95',
        '/win16/i'              =>  'Windows 3.11',
        '/macintosh|mac os x/i' =>  'Mac OS X',
        '/mac_powerpc/i'        =>  'Mac OS 9',
        '/linux/i'              =>  'Linux',
        '/ubuntu/i'             =>  'Ubuntu',
        '/iphone/i'             =>  'iPhone',
        '/ipod/i'               =>  'iPod',
        '/ipad/i'               =>  'iPad',
        '/android/i'            =>  'Android',
        '/blackberry/i'         =>  'BlackBerry',
        '/webos/i'              =>  'Mobile'
    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent)){
            $os_platform = $value;
        }
    return $os_platform;
}

function getBrowser() {

    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $browser        = "Unknown Browser";

    $browser_array = array(
        '/msie/i'      => 'Internet Explorer',
        '/firefox/i'   => 'Firefox',
        '/safari/i'    => 'Safari',
        '/chrome/i'    => 'Chrome',
        '/edge/i'      => 'Edge',
        '/opera/i'     => 'Opera',
        '/netscape/i'  => 'Netscape',
        '/maxthon/i'   => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i'    => 'Handheld Browser'
    );

    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    return $browser;
}

function getOsType($item_id)
{
    $array_type = [
        'Windows' => [
            '0106-WinMurchav',
            '0105-WinTadmiti',
            '0107-WinPaeel'
        ],
        'Linux' => [
            '0121-Metukzav',
            '0100-LxTadmiti',
            '0120-Cheschoni',
            'SAL2000-5Mailbox+Web',
            '0101-LxMurchav',
            '0102-LxPaeel',
            '0122-Yaeel',
            '0110-ResLxTadmiti'
        ]
    ];

    $os_type = 'Not Applicable';

    foreach ($array_type as $key => $value){
        if (in_array($item_id, $value)){
            $os_type = $key;
            break;
        }
    }

    return $os_type;

}
