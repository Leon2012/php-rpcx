<?php

/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2016/11/3
 * Time: 11:47
 */
namespace php\rpcx;

define('RandomSelect', 1);
define('RoundRobin', 2);
define('WeightedRoundRobin', 3);
define('WeightedICMP', 4);
define('ConsistentHash', 5);
define('Closest', 6);

interface Selector
{
    public function select($trans, $codec);
    public function setClient($client);
    public function setSelectMode($selectMode);
    public function allClients($trans, $codec);
}