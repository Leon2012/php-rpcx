<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2016/11/3
 * Time: 16:46
 */

namespace php\rpcx\codec;


use php\rpcx\Codec;
use php\rpcx\utils\Uuid;

class JsonV2 extends Base implements Codec
{
    private $_id;

    public function __construct()
    {
        parent::__construct();
    }

    public function encode($method, $args = null)
    {
        $this->_id = Uuid::gen();
        $request = [
            'jsonrpc' => '2.0',
            'id' => $this->_id,
            'method' => $method,
        ];
        if ($args == null) {
            $request['params'] = [];
        }else if (is_object($args)) {
            $request['params'] = (array)$args;
        }else{
            $request['params'] = $args;
        }
        $json = json_encode($request);
        if ($this->_debug) {
            echo sprintf("request: %s \n", $json);
        }
        return $json;
    }

    public function decode($rawContent)
    {
        if ($this->_debug) {
            echo sprintf("response: %s \n", $rawContent);
        }
        $response = json_decode($rawContent, true);
        if (isset($response['error']) && !empty($response['error'])) {
            $this->_error = [
                'code' => $response['error']['code'],
                'message' => $response['error']['message'],
            ];
            return false;
        }else{
            $id = $response['id'];
            if (empty($id) || $id != $this->_id) {
                $this->_error = [
                    'code' => '500',
                    'message' => sprintf("id not equal %s , %s", $id, $this->_id),
                ];
                return false;
            }

            if (isset($response['result'])) {
                return $response['result'];
            }else{
                return true;
            }
        }
    }


}