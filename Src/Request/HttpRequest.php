<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Request;

use \Dida\Request;
use \Dida\Request\Exception\InvalidUrlException;
use \Dida\Request\Exception\InvalidHttpMethodException;
use \Dida\Request\Exception\InvalidQueryException;

/**
 * HttpRequest 类
 */
class HttpRequest extends Request
{
    /* 常量 */
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';
    const HEAD = 'HEAD';
    const OPTIONS = 'OPTIONS';

    /* Uri 解析相关 */
    protected $path = [];
    protected $query = [];

    /* Request Method */
    protected $method = null;

    /* 是否是 Ajax */
    protected $isAjax = null;

    
    public function __construct()
    {
        $this->method();
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

            /* method */
            case 'method':
                return $this->method();

            /* isAjax */
            case 'isAjax':
                return $this->isAjax();
        }
    }


    /**
     * 把url拆分为path,query,fragment
     *
     * url 一般表示为 path?query=...#fragment
     */
    private function parseUrl()
    {
        /* 分解uri
         * 注意：parse_url不负责检查url的合法性，需要自己在程序中处理
         */
        $url = parse_url($_SERVER['REQUEST_URI']);

        // 处理path部分
        if (isset($url['path'])) {
            $path = $url['path'];

            // 检查path是否有效
            if (($path === DIDA_WWW) || ($path . '/' === DIDA_WWW)) {
                // 请求首页，因访问频率很高，独立出来，加快速度
                $this->path = [];
            } else {
                if (strncasecmp($path, DIDA_WWW, strlen(DIDA_WWW)) === 0) {
                    // 去除DIDA_WWW
                    $path = substr($path, strlen(DIDA_WWW));
                    // urldecode
                    $path = urldecode($path);
                    // 分解成路径数组
                    $this->path = explode('/', $path);
                } else {
                    throw new InvalidUrlException;
                }
            }
        }

        // 处理query部分
        foreach ($_GET as $k => $v) {
            $this->query[$k] = $v;
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

        // 第一次运行
        $method = '';
        if (isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
            unset($_POST['_method']);
        } elseif (isset($_SERVER['REQUEST_METHOD'])) {
            $method = strtoupper($_SERVER['REQUEST_METHOD']);
        }

        // 只能为：GET，POST，PUT，PATCH，DELETE，OPTIONS，HEAD之一
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
            default:
                throw new InvalidHttpMethodException;
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

        // 第一次运行
        $this->isAjax = false;  // 置初始值
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                $this->isAjax = true;
            }
        }
        return $this->isAjax;   // 返回结果
    }
}
