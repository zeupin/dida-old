<?php

namespace Dida;

$app['request'] = function ()  {
    return new Request();
};

$app['router'] = function () {
    $router = new Router();
    $router->addRoute(new App\Routes\DefaultRoute);
    return $router;
};