<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2016/11/3
 * Time: 11:58
 */

namespace php\rpcx\transport;


use php\rpcx\Transport;

define('MAX_READ_LENGTH', 4096);

class Socket implements Transport
{

    private $_socket = null;
    private $_addr;
    private $_port;
    private $_rawContent;

    /**
     * Socket constructor.
     */
    public function __construct($addr, $port)
    {
        $this->_addr = $addr;
        $this->_port = $port;
        $this->_rawContent = '';
    }

    public function __destruct()
    {
        if ($this->_socket) {
            socket_close($this->_socket);
        }
    }

    private function open()
    {
        $this->_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!$this->_socket) {
            return false;
        }
        if (!socket_connect($this->_socket, $this->_addr, $this->_port)) {
            return false;
        }
        return true;
    }

    /**
     * @param $values
     */
    public function send($args)
    {
        $isOpen = $this->open();
        if (!$isOpen) {
            return false;
        }
        if (socket_write($this->_socket, $args) === false) {
            return false;
        }

        if (($this->_rawContent = socket_read($this->_socket, MAX_READ_LENGTH)) === false) {
            return false;
        }

        return true;
    }

    /**
     *
     */
    public function read()
    {
        return $this->_rawContent;
    }


    /**
     *
     */
    public function getLastError()
    {
        return [
            'code' => socket_last_error(),
            'message' => socket_strerror(),
        ];
    }
}