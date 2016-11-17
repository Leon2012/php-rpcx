<?php
/**
 * User: PengYe
 * Date: 2016/11/17
 * Time: 14:54
 */

namespace php\rpcx;


class Exception extends \Exception
{
    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }
}