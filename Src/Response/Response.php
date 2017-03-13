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


    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
        return $this;
    }


    public function getEncoding()
    {
        return $this->encoding;
    }


    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }


    public function getContentType()
    {
        return $this->contentType;
    }
}
