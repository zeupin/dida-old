<?php

namespace Dida\Builder;

use \Dida;

Dida::$app->request = function () {
    return new \Dida\Request\HttpRequest();
};

Dida::$app->router = function () {
    /* 生成 Router实例 */
    $router = new \Dida\Routing\Router();

    /* 定义默认路由规则 */
    $route2 = new \Dida\Routing\DefaultRoute;
    $router->addRoute($route2);

    /* 返回生成的路由器实例 */
    return $router;
};

Dida::$app->twig = function () {
    $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../Views');
    $twig = new \Twig_Environment($loader, []);
    return $twig;
};

Dida::$app->db = function () {
    // Doctrine配置器
    $config = new \Doctrine\DBAL\Configuration();

    // Doctrine连接参数
    $connectionParams = array(
        'dbname'   => 'pi',
        'user'     => 'pi',
        'password' => 'pi',
        'host'     => 'localhost',
        'driver'   => 'pdo_mysql',
    );

    // 生成conn
    $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

    return $conn;
};
