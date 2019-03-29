<?php

namespace App\Http\Helper;


use DateTime;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Client as Client;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CommonHelper
{    
    const DAILY                 = 'd';
    const HOURLY                = 'h';
    const MONTHLY               = 'm';
    const SINGLE                = 's';
    const USER_LOG_FILE         = 'user';
    
    
    public static function formatPrice($price) {
        $price = number_format((float)$price, 2, '.', '');
        return $price;
    }
    
    public static function getCurrentDateTime() {
        return new DateTime;
    }

    public static function event($message, $fileName = 'event', $type) {
        switch ($type) {
            case self::DAILY:
                $fileName = $fileName . "_" . date('Y-m-d');
                break;
            
            case self::HOURLY:
                $fileName = $fileName . "_" . date('Y-m-d_h');
                break;
            
            case self::MONTHLY:
                $fileName = $fileName . "_" . date('Y-m');
                break;

            default:
                 $fileName = $fileName;
                break;
        }
        $filePath   = storage_path();
        $fileName   = $filePath."/logs/".$fileName .".log";
        $mode       = "a";
        $fh         = fopen($fileName, $mode);
        $message    = self::_prepare($message);
        $message    = date('Y-m-d h:i:s') . "--" . $message . PHP_EOL;
        fwrite($fh, $message);
        fclose($fh);
    }
    
    /**
     * Convert incoming log object to string
     * @param mixed $obj
     * @return string
     */
    protected static function _prepare($obj)
    {
        if (false === is_scalar($obj)) {
            $string = self::_dump($obj);
        } else if (is_numeric($obj)) {
            $string = (string) $obj;
        } else {
            $string = $obj;
        }
        return $string;
    }
    
    protected static function _dump($var)
    {
        // var_export the variable into a buffer and keep the output
        $output = var_export($var, true);
        // neaten the newlines and indents
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        return $output;
    }

    public static function getExceptionMessageString(\Exception $ex) {
        return $ex->getMessage() ."|". $ex->getFile()."|".$ex->getLine();
    }

}