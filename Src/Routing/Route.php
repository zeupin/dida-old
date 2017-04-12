<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Routing;

use \Dida\Exception\PropertyGetException;
use \Dida\Exception\ValueNotSetException;
use \Dida\Exception\FileNotFoundException;

/**
 * Route 类
 */
abstract class Route
{
    /*
     * 要输入的变量
     */
    protected $request = null;

    /*
     * 要输出的变量
     */
    protected $matched = false;     // 是否匹配成功
    protected $controller = null;   // controller的类全名，如：Foo\Bar\BazController
    protected $action = null;       // action

    /*
     * 内部变量
     */
    protected $routemap = [];


    /**
     * 对Request进行路由匹配
     *
     * @return bool 匹配成功返回true,失败返回false
     */
    abstract public function match();


    /**
     * 当匹配成功后，返回controller和action
     *
     * @param string $name
     *
     * @throws ValueNotSetException
     * @throws PropertyGetException
     */
    public function __get($name)
    {
        switch ($name) {
            case 'controller':
                if ($this->matched) {
                    return $this->controller;
                } else {
                    throw new ValueNotSetException($name);
                }
            case 'action':
                if ($this->matched) {
                    return $this->action;
                } else {
                    throw new ValueNotSetException($name);
                }
            case 'matched':
                return $this->matched;
            default:
                throw new PropertyGetException($name);
        }
    }


    /**
     * 设置要匹配的Request
     */
    public function setRequest(Request &$request)
    {
        $this->request = $request;
        $this->matched = false;

        return $this;
    }


    /**
     * 载入一个路由表文件
     *
     * @param string $routemapfile
     */
    public function loadRouteMap($routemapfile)
    {
        if (file_exists($routemapfile) && is_file($routemapfile)) {
            $routemap = include($routemapfile);
            if (!is_array($routemap)) {
                $this->routemap = [];
                return false;
            }
            $this->routemap = $routemap;
        } else {
            throw new FileNotFoundException($routemapfile);
        }
    }
}
