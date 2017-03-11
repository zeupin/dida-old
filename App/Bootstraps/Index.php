<?php

namespace App;

app()->singleton('request', function () {
    return new \Dida\RequestHttp();
});

app()->singleton('dispatcher', function () {
    return new \Dida\Dispatcher();
});

app()->singleton('router', function () {
    /* 生成 Router实例 */
    $router = new \Dida\Router();

    /* 定义若干路由规则 */

    // 短url路由
    $route1 = new \App\Routes\ShortUrlRoute;
    $router->addRoute($route1);

    // 默认路由
    $route2 = new \App\Routes\DefaultRoute;
    $route2->loadRouteMap(DIDA_APP_ROOT . 'Config/DefaultRouteMap.php');
    $router->addRoute($route2);

    //返回生成的路由器实例
    return $router;
});
