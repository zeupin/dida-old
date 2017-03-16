<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

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
    protected $parameters = [];     // 参数数组
    protected $flags = [];          // 会用到的标志位

    /*
     * 内部变量
     */
    protected $routemap = [];
    protected $matched = false;


    /**
     * 抽象方法，对Request进行路由匹配
     * 
     * @return bool 匹配成功返回true，否则返回false
     */
    abstract public function match();


    /**
     * 抽象方法，如果匹配成功，分发对应的路由
     */
    abstract public function dispatch();


    /**
     * 抽象方法，组装一个路由
     */
    abstract public static function assemble($controller, $action, array $parameters = [], array $options = []);


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
            $routemap = require($routemapfile);
            if (!is_array($routemap)) {
                $this->routemap = [];
                return false;
            }
            $this->routemap = $routemap;
            return true;
        } else {
            $this->routemap = [];
            return false;
        }
    }
}
