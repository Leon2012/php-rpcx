<?php
/**
 * User: PengYe
 * Date: 2016/11/17
 * Time: 15:35
 */

include_once "../vendor/autoload.php";
use php\rpcx\transport\Curl;
use php\rpcx\codec\JsonV2;
use php\rpcx\Client;

$url = 'http://127.0.0.1:8092/';
$method = 'Arith.Mul1';
$params = ['A' => 5, 'B' => 6];

$trans = new Socket($addr, $port);
$codec = new JsonV2();
$client = new Client($trans, $codec);
$client->setDebug(true);
$client->call($method, $params);