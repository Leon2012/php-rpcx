<?php

/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2016/11/3
 * Time: 11:51
 */

namespace php\rpcx;
interface Codec
{
    public function decode($rawContent);
    public function encode($method, $args = null);
    public function getLastError();
}