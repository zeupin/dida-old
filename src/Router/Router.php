<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Router 类
 */
class Router
{
    protected $routes = [];

    use SingletonTrait;     // Router类为单例模式


    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }


    public function route()
    {
        foreach ($this->routes as $route) {
            if ($route->match()) {
                $route->route();
                break;
            }
        }
    }
}
