<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

use \Dida\Request;
use \Dida\HttpRequest\Exception\InvalidUrlException;
use \Dida\HttpRequest\Exception\InvalidRequestMethodException;
use \Dida\HttpRequest\Exception\InvalidQueryException;
use \Dida\Exception\PropertyGetException;

/**
 * HttpRequest 类
 */
class HttpRequest extends Request
{
    /* traits */
    use Traits\PropertyGetSetTrait;

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
    protected $query = null;        // $_GET
    protected $post = null;         // $_POST
    protected $isAjax = null;       // 是否是Ajax访问
    protected $clientIP = null;     // 客户端IP
    protected $host = null;         // 主机名
    protected $scheme = null;       // 协议名（全小写）,http,https等


    public function __construct()
    {
        $this->method__Get();
        $this->path__Get();
    }


    /**
     * 获取method
     *
     * @return string 正常为GET,POST,PUT,PATCH,DELETE,OPTIONS,HEAD之一。如果非法，则为空字符串。
     */
    protected function method__Get()
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
    protected function path__Get()
    {
        // 不重复处理
        if (is_array($this->path)) {
            return $this->path;
        }

        /* 获取$path */
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        /* 对首页的快捷处理 */
        if (($url === DIDA_WWW) || ($url . '/' === DIDA_WWW) || ($url === DIDA_WWW . DIDA_DEFAULT_SCRIPT_NAME)) {
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
     * 获取查询串 $_GET
     *
     * @return array
     */
    protected function query__Get()
    {
        // 不重复处理
        if (is_array($this->query)) {
            return $this->query;
        }

        // 第一次运行，从$_GET把数据搬过来
        foreach ($_GET as $k => $v) {
            $this->query[$k] = $v;
        }
        return $this->query;
    }


    /**
     * 获取$_POST
     *
     * @return array
     */
    protected function post__Get()
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
     * isAjax() 函数的属性访问方式
     * @return type
     */
    protected function isAjax__Get()
    {
        return isAjax();
    }


    /**
     * 获取客户端IP
     *
     * @return string|bool 正常返回读取的ip，异常返回false
     */
    protected function clientIP__Get()
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


    /**
     * 获取主机名
     */
    protected function host__Get()
    {
        // 不重复处理
        if ($this->host !== null) {
            return $this->host;
        }

        // 第一次运行
        if (isset($_SERVER['HTTP_HOST'])) {
            $host = $_SERVER['HTTP_HOST'];
        } else {
            $host = '';
        }

        // 返回结果
        $this->host = $host;
        return $host;
    }


    /**
     * 获取协议名
     */
    protected function scheme__Get()
    {
        // 不重复处理
        if ($this->scheme !== null) {
            return $this->scheme;
        }

        // 第一次运行
        if (isset($_SERVER['REQUEST_SCHEME'])) {
            $scheme = $_SERVER['REQUEST_SCHEME'];
        } else {
            $scheme = '';
        }

        // 返回结果
        $this->scheme = $scheme;
        return $scheme;
    }
}
