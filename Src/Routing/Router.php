<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Routing;

use \Dida\Routing\InvalidDispatchException;
use \Dida\Routing\Exception\ControllerNotFoundException;
use \Dida\Routing\Exception\ActionNotFoundException;

/**
 * Router 类
 */
final class Router
{
    protected $routes = [];

    /* 匹配到的路由 */
    protected $activeRoute = null;
    protected $activeController = null;
    protected $activeAction = null;


    /**
     * 新增一个路由规则
     *
     * @param \Dida\Routing\Route $route
     */
    public static function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }


    /**
     * 遍历所有的路由规则，如果找到，则执行
     *
     * @param \Dida\Routing\Request $request
     *
     * @throws RoutingFailException
     */
    public static function start(Request $request)
    {
        foreach ($this->routes as $route) {
            $route->setRequest($request);
            if ($route->match()) {
                $this->activeRoute = $route;
                $this->activeController = $route->controller;
                $this->activeAction = $route->action;
                // dispatch
                self::dispatch($this->activeController, $this->activeAction);
                return;
            }
        }

        // 路由失败，抛出 RoutingFailException
        throw new RoutingFailException;
    }


    /**
     * 分派Action
     *
     * @param string $controller
     * @param string $action
     *
     * @throws ActionNotFoundException
     * @throws ControllerNotFoundException
     */
    public static function dispatch($controller, $action, $parameters = [])
    {
        if (class_exists($controller, true)) {
            if ($controller::actionExists($action)) {
                $obj = new $controller;
                $obj->execute($action, $parameters);
            } else {
                throw new ActionNotFoundException($controller . '->' . $action);
            }
        } else {
            throw new ControllerNotFoundException($controller);
        }
    }
}
