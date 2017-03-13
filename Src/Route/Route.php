<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Route 类
 */
abstract class Route implements RouteInterface
{
    /*
     * 要输入的变量
     */
    protected $request = null;

    /*
     * 要输出的变量
     */
    protected $controller = '';     // Controller的名称，FQCN格式
    protected $action = '';         // Action的名称
    protected $parameters = [];     // 参数数组

    /*
     * 内部变量
     */
    protected $routemap = [];


    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }


    /**
     * 载入一个路由对应表文件
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
