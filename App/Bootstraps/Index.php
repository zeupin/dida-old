<?php

namespace App;

app()->set('request', function () {
    return new \Dida\RequestHttp();
});

app()->set('dispatcher', function () {
    return new \Dida\Dispatcher();
});

app()->set('router', function () {
    /* 生成 Router实例 */
    $router = new \Dida\Router();

    /* 定义短url路由规则 */
    $route1 = new \App\Routes\ShortUrlRoute;
    $router->addRoute($route1);

    /* 定义默认路由规则 */
    $route2 = new \Dida\Route\DefaultRoute;
    $router->addRoute($route2);

    /* 返回生成的路由器实例 */
    return $router;
});
