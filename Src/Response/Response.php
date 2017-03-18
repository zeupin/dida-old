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
    protected $encoding = 'utf-8';
    protected $contentType = '';


    public function output($delimiter = '')
    {
        echo implode($delimiter, $this->body);
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


    public function encodingSet($encoding)
    {
        $this->encoding = $encoding;
        return $this;
    }


    public function encodingGet()
    {
        return $this->encoding;
    }


    public function contentTypeSet($contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }


    public function contentTypeGet()
    {
        return $this->contentType;
    }


    public function clear()
    {
        $this->head = [];
        $this->body = [];
    }
}
