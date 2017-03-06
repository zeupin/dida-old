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


    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }


    public function route()
    {
        foreach ($this->routes as $route) {
            if ($route->match()) {
                $route->route();
                return;
            }
        }

        throw new \Exception('404 Not Found');
    }
}
