<?php
/**
 * User: PengYe
 * Date: 2016/11/21
 * Time: 11:12
 */

namespace php\rpcx\selector;


use php\rpcx\Selector;
use php\rpcx\Client;

class DirectClientSelector extends Base  implements Selector
{

    private $_client = null;

    public function __construct($trans, $codec)
    {
        $this->_client = new Client($trans, $codec);
    }


    public function select($trans, $codec)
    {
        if ($this->_client) {
            return $this->_client;
        }else{
            $this->_client = new Client($trans, $codec);
            return $this->_client;
        }
    }

    public function setClient($client)
    {
        $this->_client = $client;
    }

    public function setSelectMode($selectMode)
    {
    }

    public function allClients($trans, $codec)
    {
        return [$this->_client];
    }

}