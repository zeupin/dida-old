<?php

namespace Dida\Builder;

app()->request = function () {
    return new \Dida\RequestHttp();
};

app()->router = function () {
    /* 生成 Router实例 */
    $router = new \Dida\Router();

    /* 定义默认路由规则 */
    $route2 = new \Dida\Route\DefaultRoute;
    $router->addRoute($route2);

    /* 返回生成的路由器实例 */
    return $router;
};

app()->twig = function () {
    $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../Views');
    $twig = new \Twig_Environment($loader, []);
    return $twig;
};

app()->db = function () {
    $db = new \Dida\Database\Driver\Mysql([
        'user'     => 'pi',
        'password' => 'pi',
        'dbname'   => 'pi',
    ]);
    $db->connect();
    return $db;
};
