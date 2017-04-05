<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * HttpRequest 类
 */
class HttpRequest extends Request
{
    /* Uri 解析相关 */
    protected $path = [];
    protected $query = [];
    protected $fragment = '';

    /* 是否是 Ajax */
    protected $isAjax = null;

    /* Request Method */
    protected $method = null;


    public function __construct()
    {
        $this->parseUrl();
    }


    /**
     * 伪属性
     */
    public function __get($name)
    {
        switch ($name) {
            /* URI解析相关的几个属性 */
            case 'path':
                return $this->path;
            case 'query':
                return $this->query;
            case 'fragment':
                return $this->fragment;

            case 'method':
                return $this->method();
            case 'isAjax':
                return $this->isAjax();
        }
    }


    /**
     * 把URI拆分为path,query,fragment
     *
     * uri 一般表示为 path?query=...#fragment
     */
    private function parseUrl()
    {
        // 检查请求的uri是否有效
        if (strncasecmp($_SERVER['REQUEST_URI'], DIDA_WWW, strlen(DIDA_WWW)) != 0) {
            throw new UriException;
        }

        // 分解uri
        $url = parse_url($_SERVER['REQUEST_URI']);

        // 处理path部分
        if (isset($url['path'])) {
            // 去除DIDA_WWW后的部分
            $path = substr($url['path'], strlen(DIDA_WWW));
            $this->path = explode('/', $path);
        }

        // 处理query部分
        if (isset($url['query'])) {
            $this->query = $url['query'];
        }

        // 处理fragment部分
        if (isset($url['$fragment'])) {
            $this->fragment = $url['$fragment'];
        }
    }


    /**
     * 获取method
     *
     * @return string 正常为GET,POST,PUT,PATCH,DELETE,OPTIONS,HEAD之一。如果非法，则为空字符串。
     */
    public function method()
    {
        // 如果已经有值，直接引用
        if ($this->method !== null) {
            return $this->method;
        }

        // 获取method
        $method = '';
        if (isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        } elseif (isset($_SERVER['REQUEST_METHOD'])) {
            $method = strtoupper($_SERVER['REQUEST_METHOD']);
        }

        // 限定method只能为：GET，POST，PUT，PATCH，DELETE，OPTIONS，HEAD之一
        // 否则，返回空串
        switch ($method) {
            case 'GET':
            case 'POST':
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
            case 'OPTIONS':
            case 'HEAD':
                $this->method = $method;
                break;
            default :
                $this->method = '';
        }
        return $this->method;
    }


    /**
     * 是否是Ajax请求
     *
     * @return bool
     */
    public function isAjax()
    {
        // 如果已经有值，直接引用
        if ($this->isAjax !== null) {
            return $this->isAjax;
        }

        // 第一次运行，从设置中读取
        $this->isAjax = false;  // 置初始值
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                $this->isAjax = true;
            }
        }
        return $this->isAjax;   // 返回结果
    }
}
