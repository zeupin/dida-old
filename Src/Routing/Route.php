<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Routing;

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
    protected $matched = false;


    /**
     * 对Request进行路由匹配
     *
     * @return bool 匹配成功返回true，否则返回false
     */
    abstract public function match();


    /**
     * 分派任务
     */
    public function dispatch()
    {
        if ($this->matched) {
            app()->set('controller', $this->controller);
            $callback = [app()->get('controller'), $this->action];
            call_user_func_array($callback, $this->parameters);
            return;
        } else {
            throw new \Dida\Exception\InvalidDispatchException();
        }
    }


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


    /**
     * 把一个横线分隔的字符串按照PascalCase模式转换
     * 例如：'foo-bar-baz' 会转化为 FooBarBaz
     *
     * @param string $string
     */
    public function usePascalCase($string)
    {
        $array = explode('-', $string);
        foreach ($array as $k => $v) {
            $array[$k] = ucfirst($v);
        }
        return implode('', $array);
    }


    /**
     * 把一个横线分隔的字符串按照PascalCase模式转换
     * 例如：'foo-bar-baz' 会转化为 fooBarBaz
     *
     * @param string $string
     */
    public function useCamelCase($string)
    {
        $array = explode('-', $string);
        foreach ($array as $k => $v) {
            if ($k === 0) {
                $array[$k] = lcfirst($v);
            } else {
                $array[$k] = ucfirst($v);
            }
        }
        return implode('', $array);
    }
}
