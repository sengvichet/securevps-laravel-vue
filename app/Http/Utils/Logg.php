<?php

namespace App\Http\Utils;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

class Logg
{
    /**
     * [info description]
     * @param  [type] $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function loggxml($key, $value, $params = [])
    {
        // $dateFormat = "Y n j, g:i a";
        // $output = "[%datetime% - %level_name%] %message% %context% %extra%\n\n\n";
        // $formatter = new LineFormatter($output, $dateFormat, $key);
        //
        // $stream = new StreamHandler(storage_path() . '/logs/shevxml.log');
        // $stream->setFormatter($formatter);
        //
        // $viewLog = new Logger($key);
        // $viewLog->pushHandler($stream);
        // $viewLog->addInfo($value);

        $viewLog = new Logger($key);
        $viewLog->pushHandler(new StreamHandler(storage_path() . '/logs/shevxml.log'));
        $viewLog->addInfo($value,$params);
    }

    /**
     * [any description]
     * @param  [type] $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function logg($str, $arr)
    {
        $viewLog = new Logger('');
        $viewLog->pushHandler(new StreamHandler(storage_path() . '/logs/shev.log'));
        $viewLog->addInfo($str,$arr);
    }
}
