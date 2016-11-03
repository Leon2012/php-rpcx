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
    public function decode($value);
    public function encode($value);
}