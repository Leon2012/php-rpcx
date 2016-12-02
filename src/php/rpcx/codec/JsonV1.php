<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2016/11/3
 * Time: 16:05
 */

namespace php\rpcx\codec;


use php\rpcx\Codec;
use php\rpcx\utils\Uuid;
use php\rpcx\utils\JsonEncoder;

class JsonV1 extends Base  implements Codec
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
            'id' => $this->_id,
            'method' => $method,
        ];
        if ($args) {
            $request['params'] = [$args];
            //$request['params'] = JsonEncoder::encode($args);
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
                'code' => '501',
                'message' => $response['error'],
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