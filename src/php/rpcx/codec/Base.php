<?php
/**
 * User: PengYe
 * Date: 2016/11/17
 * Time: 15:51
 */

namespace php\rpcx\codec;


abstract class Base
{
    protected $_error;
    protected $_debug;

    protected function __construct()
    {
        $this->_debug = false;
        $this->_error = '';
    }

    public function getLastError()
    {
        return $this->_error;
    }

    /**
     * @return mixed
     */
    public function getDebug()
    {
        return $this->_debug;
    }

    /**
     * @param mixed $debug
     */
    public function setDebug($debug)
    {
        $this->_debug = $debug;
    }
}