<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Routing;

use \Dida\Exception\PropertyGetException;
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
    protected $controller = '';     // Controller的FQCN名称
    protected $action = '';         // Action的名称

    /*
     * 内部变量
     */
    protected $routemap = [];


    /**
     * 对Request进行路由匹配
     *
     * @return array|bool 匹配成功返回[controller, action],失败返回false
     */
    abstract public function match();


    /**
     * 设置要匹配的Request
     */
    public function setRequest(Request $request)
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
