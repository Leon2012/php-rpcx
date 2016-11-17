<?php
/**
 * User: PengYe
 * Date: 2016/11/17
 * Time: 17:28
 */

namespace php\rpcx\utils;


class JsonEncoder
{

    /**
     * @param $val
     * @return string
     */
    public static function encode($val)
    {
        if (is_string($val)) {
            return '"' . self::addslashes($val) . '"';
        }
        if (is_numeric($val)) {
            return $val;
        }
        if ($val === null) {
            return 'null';
        }
        if ($val === true) {
            return 'true';
        }
        if ($val === false) {
            return 'false';
        }
        $assoc = false;
        $i = 0;
        foreach ($val as $k => $v) {
            if ($k !== $i++){
                $assoc = true;
                break;
            }
        }
        $res = array();
        foreach ($val as $k => $v) {
            $v = self::addslashes($v);
            if ($assoc) {
                $k = '"' . self::encode($k) . '"';
                $v = $k . ':' . $v;
            }
            $res[] = $v;
        }
        $res = implode(',', $res);
        return ($assoc) ?
            '{' . $res . '}' :
            '[' . $res . ']';
    }


    /**
     * @param $string
     * @return mixed
     */
    public static function addslashes($string)
    {
        $string = addslashes($string);
        return str_replace('\\\\', '\\', $string);
    }
}