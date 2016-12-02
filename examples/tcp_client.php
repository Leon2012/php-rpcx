<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2016/11/15
 * Time: 11:30
 */
include_once '../vendor/autoload.php';
use php\rpcx\transport\Socket;
use php\rpcx\codec\JsonV2;
use php\rpcx\Client;

$addr = '127.0.0.1';
$port = 8972;
$method = 'Arith.Mul';
$params = ['A' => 5, 'B' => 6];

$method1 = 'Arith.Hello';
$params1 = 5;

$trans = new Socket($addr, $port);

$codec = new JsonV2();
//$codec = new \php\rpcx\codec\JsonV1();
$codec->setDebug(true);

$client = new Client($trans, $codec);
$result = $client->call($method1, $params1);
if ($result === false) {
    print_r($client->getErrors());
} else {
    if (is_array($result)) {
        print_r($result);
    } else {
        echo 'result: ' . $result;
    }
}

echo $a;
