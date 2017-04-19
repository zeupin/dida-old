<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Request;

use \Dida\Request;
use \Dida\HttpRequest\Exception\InvalidUrlException;
use \Dida\HttpRequest\Exception\InvalidRequestMethodException;
use \Dida\HttpRequest\Exception\InvalidQueryException;

/**
 * HttpRequest 类
 */
class HttpRequest extends Request
{
    /* 常量 */
    const GET_METHOD = 'GET';
    const POST_METHOD = 'POST';
    const PUT_METHOD = 'PUT';
    const PATCH_METHOD = 'PATCH';
    const DELETE_METHOD = 'DELETE';
    const HEAD_METHOD = 'HEAD';
    const OPTIONS_METHOD = 'OPTIONS';

    /* 基本属性，初始化时即获取 */
    protected $method = null;
    protected $path = null;

    /* 扩展属性，需要用到时再获取 */
    protected $get = null;          // $_GET
    protected $post = null;         // $_POST
    protected $isAjax = null;
    protected $clientIP = null;     // 客户端IP


    public function __construct()
    {
        $this->method();
        $this->path();
    }


    /**
     * 伪属性
     */
    public function __get($name)
    {
        switch ($name) {
            case 'method':
                return $this->method;
            case 'path':
                return $this->path;
            case 'get':
                return $this->get();
            case 'post':
                return $this->post();
            case 'isAjax':
                return $this->isAjax();
            case 'clientIP':
                return $this->clientIP();
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
                throw new InvalidRequestMethodException;
        }
        return $this->method;
    }


    /**
     * 从REQUEST_URI中分解path
     *
     * @return array
     */
    public function path()
    {
        // 不重复处理
        if (is_array($this->path)) {
            return $this->path;
        }

        /* 获取$path */
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        /* 快捷处理 */
        if (($url === DIDA_WWW) || ($url . '/' === DIDA_WWW)) {
            // 请求首页，因访问频率很高，独立出来，加快速度
            $this->path = [];
            return [];
        }

        /* url中的path */
        $path = explode('/', $url);
        (end($path) === '') ? array_pop($path) : null;   // 末层目录如果为空，则清除之

        /* wwwroot */
        $root = explode('/', DIDA_WWW);
        (end($root) === '') ? array_pop($root) : null;   // 末层目录如果为空，则清除之

        /* path必须是root的子集 */
        if (count($path) < count($root)) {
            throw new InvalidUrlException;
        }

        /* 去除DIDA_WWW */
        while (count($root)) {
            if (strcasecmp(reset($root), reset($path)) === 0) {
                array_shift($root);
                array_shift($path);
            } else {
                throw new InvalidUrlException;
            }
        }

        $this->path = $path;
        return $path;
    }


    /**
     * 获取$_GET
     *
     * @return array
     */
    public function get()
    {
        // 不重复处理
        if (is_array($this->get)) {
            return $this->get;
        }

        // 第一次运行，从$_GET把数据搬过来
        foreach ($_GET as $k => $v) {
            $this->get[$k] = $v;
        }
        return $this->get;
    }


    /**
     * 获取$_POST
     *
     * @return array
     */
    public function post()
    {
        // 不重复处理
        if (is_array($this->post)) {
            return $this->post;
        }

        // 第一次运行，从$_POST把数据搬过来
        foreach ($_POST as $k => $v) {
            $this->post[$k] = $v;
        }
        return $this->post;
    }


    /**
     * 是否是Ajax请求
     *
     * @return bool
     */
    public function isAjax()
    {
        // 不重复处理
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

        // 返回结果
        return $this->isAjax;
    }


    /**
     * 获取客户端IP
     *
     * @return string|bool 正常返回读取的ip，异常返回false
     */
    public function clientIP()
    {
        // 不重复处理
        if ($this->clientIP !== null) {
            return $this->clientIP;
        }

        // 第一次运行
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["REMOTE_ADDR"])) {
            $ip = $_SERVER["REMOTE_ADDR"];
        } else {
            $ip = false; // ip未定义
        }

        // 返回结果
        $this->clientIP = $ip;
        return $ip;
    }
}
