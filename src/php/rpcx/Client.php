<?php

/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2016/11/3
 * Time: 10:35
 */
namespace php\rpcx;

class Client
{
    private $_transport;
    private $_codec;
    private $_errors;

    public function __construct($transport, $codec)
    {
        $this->_transport = $transport;
        $this->_codec = $codec;
        $this->_errors = [];
    }

    public function call($method, $args = null)
    {
        $request = $this->_codec->encode($method, $args);
        $ret = $this->_transport->send($request);
        if (!$ret) {
            $this->_errors[] = $this->_transport->getLastError();

            return false;
        } else {
            $rawContent = $this->_transport->read();
            $result = $this->_codec->decode($rawContent);
            if ($result === false) {
                $this->_errors[] = $this->_codec->getLastError();

                return false;
            }

            return $result;
        }
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function getLastError()
    {
        return end($this->_errors);
    }

    /**
     * @return mixed
     */
    public function getTransport()
    {
        return $this->_transport;
    }

    /**
     * @param mixed $transport
     */
    public function setTransport($transport)
    {
        $this->_transport = $transport;
    }

    /**
     * @return mixed
     */
    public function getCodec()
    {
        return $this->_codec;
    }

    /**
     * @param mixed $codec
     */
    public function setCodec($codec)
    {
        $this->_codec = $codec;
    }

}
