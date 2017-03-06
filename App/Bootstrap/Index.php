<?php

namespace App;

$app['request'] = function () {
    return new \Dida\RequestHttp();
};

$app['router'] = function () {
    $router = new \Dida\Router();
    $router->addRoute(new \App\Routes\DefaultRoute);
    return $router;
};
