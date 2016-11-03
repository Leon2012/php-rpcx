<?php

/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2016/11/3
 * Time: 11:52
 */
namespace php\rpcx;
interface Transport
{
    public function send($values);
    public function read();
    public function getLastError();
}