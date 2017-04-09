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


    /**
     * 新增一个路由规则
     *
     * @param \Dida\Routing\Route $route
     * @return $this 链式调用
     */
    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
        return $this;
    }


    /**
     * 遍历所有的路由规则，如果找到，则执行
     *
     * @param \Dida\Routing\Request $request
     * @return type
     * @throws RoutingFailException
     */
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
        throw new RoutingFailException;
    }
}
