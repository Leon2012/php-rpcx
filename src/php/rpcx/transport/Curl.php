<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2016/11/3
 * Time: 15:35
 */

namespace php\rpcx\transport;


use php\rpcx\Transport;

class Curl implements Transport
{
    private $_url;
    private $_headers;
    private $_timeout = 60;
    private $_curl;
    private $_curlOptions;
    private $_rawContent;

    public function __construct($url)
    {
        $this->_url = $url;
        $this->_headers = [
            'User-Agent' => 'RPCX PHP Client',
            'Connection' => 'close',
        ];
        $this->_curlOptions = [
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => $this->_timeout,
        ];
        $this->_rawContent = '';
    }

    function __destruct()
    {
        if ($this->_curl) {
            curl_close($this->_curl);
        }
    }

    public function send($values)
    {
        $this->_curlOptions += [
            CURLOPT_HTTPHEADER => $this->_headers,
            CURLOPT_POSTFIELDS => $values,
        ];
        $this->_curl = curl_init($this->_url);
        if ($this->_curl == false) {
            return false;
        }
        if (!curl_setopt_array($this->_curl, $this->_curlOptions)) {
            return false;
        }
        if (curl_exec($this->_curl) == false) {
            return false;
        }
        return true;
    }

    public function read()
    {
        return $this->_rawContent;
    }

    public function getLastError()
    {
        return [
            'code' => curl_errno($this->_curl),
            'message' => curl_error($this->_curl),
        ];
    }

    public function addHeader($key, $val)
    {
        $this->_headers[$key] = $val;
    }
}