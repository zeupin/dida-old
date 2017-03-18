<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Response 类
 */
class Response
{
    public $contentType = 'html';       // html,json,text
    public $encoding = 'utf-8';
    public $buffer = [];


    public function clear()
    {
        $this->buffer = [];
    }


    public function sendHeader($header, $replace = false, $http_response_code = 0)
    {
        if ($http_response_code > 99) {
            header($header, $replace, $http_response_code);
        } else {
            header($header, $replace);
        }
    }


    public function redirect($url)
    {
        header("Location: $url");
    }


    public function addData($data)
    {
        $this->buffer[] = $data;
    }


    public function output()
    {
        if ($this->contentType == 'json') {
            return json_encode($this->buffer);
        }
    }
}
