<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Routing;

use Exception\NotFoundException;

/**
 * Router 类
 */
class Router
{
    protected $routes = [];


    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
        return $this;
    }


    public function route(Request $request)
    {
        foreach ($this->routes as $route) {
            $route->setRequest($request);
            if ($route->match()) {
                $route->dispatch();
                return;
            }
        }

        // 路由失败，抛出 RoutingFailException
        throw new RoutingFailException('404 Not Found');
    }
}
