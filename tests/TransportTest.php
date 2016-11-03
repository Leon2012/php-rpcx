<?php

/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2016/11/3
 * Time: 14:59
 */
class TransportTest extends PHPUnit_Framework_TestCase
{

    public function testConnect()
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $conn = socket_connect($socket, "127.0.0.1", 8972);
        $request = array(
            'jsonrpc' => '2.0',
            'method'  => 'Arith.Mul',
            'params'  => array('A' => 7, 'B' => 8),
            'id'      => 1
        );
        $json = json_encode($request);
        echo $json.PHP_EOL;
        socket_write($socket, $json);
        $ret = socket_read($socket, 4096);
        $response = json_decode($ret,true);
        print_r($response);
        socket_close($socket);
        $this->assertArrayHasKey('result', $response);
    }
}
