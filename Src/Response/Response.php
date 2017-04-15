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
    public $data = [];


    public function clear()
    {
        $this->data = [];
    }


    public function addData($data)
    {
        $this->data[] = $data;
    }


    public function output()
    {
        if ($this->contentType == 'json') {
            return json_encode($this->data);
        }
    }


    public function redirect($url)
    {
        header("Location: $url");
    }


    /**
     * 检查是否是一个有效的HTTP状态码
     *
     * 一个有效的 HTTP 状态码是一个三位数，由 RFC 2616 规范定义的，参阅百度百科“HTTP状态码”词条。
     * 1xx  消息
     * 2xx  成功
     * 3xx  重定向
     * 4xx  请求错误
     * 5xx  服务器错误
     * 6xx  其它错误
     *
     * @param int $http_status_code
     * @return boolean
     */
    public function isValidHttpStatusCode($http_status_code)
    {
        if (is_int($http_status_code) && $http_status_code > 99 && $http_status_code < 700) {
            return true;
        } else {
            return false;
        }
    }
}
