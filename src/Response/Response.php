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
    protected $head = [];
    protected $body = [];
    protected $format = 'html';
    protected $encoding = 'utf-8';


    public function output()
    {
    }


    public function sendHeader()
    {
    }


    public function redirect($url)
    {
        header("Location: $url");
    }


    public function addHead($head)
    {
        $this->head[] = $head;
    }


    public function addBody($body)
    {
        $this->body[] = $body;
    }


    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }


    public function getFormat()
    {
        return $this->format;
    }


    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
        return $this;
    }


    public function getEncoding()
    {
        return $this->encoding;
    }
}
