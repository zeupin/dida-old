<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
return [
    'Dida\\Application'         => 'Application/Application.php',
    'Dida\\Config'              => 'Config/Config.php',
    'Dida\\Container'           => 'Container/Container.php',
    'Dida\\Controller'          => 'Controller/Controller.php',
    'Dida\\ControllerInterface' => 'Controller/ControllerInterface.php',
    'Dida\\Db'                  => 'Db/DbInterface.php',
    'Dida\\Debug'               => 'Debug/Debug.php',
    'Dida\\Dispatcher'          => 'Dispatcher/Dispatcher.php',
    'Dida\\GetSetTrait'         => 'Traits/GetSetTrait.php',
    'Dida\\Html\\Element'       => 'Html/Element.php',
    'Dida\\Event'               => 'Event/Event.php',
    'Dida\\Exception'           => 'Exception/Exception.php',
    'Dida\\Foundation'          => 'Foundation/Foundation.php',
    'Dida\\Loader'              => 'Loader/Loader.php',
    'Dida\\Middleware'          => 'Middleware/Middleware.php',
    'Dida\\Model'               => 'Model/Model.php',
    'Dida\\Request'             => 'Request/Request.php',
    'Dida\\RequestHttp'         => 'Request/RequestHttp.php',
    'Dida\\Response'            => 'Response/Response.php',
    'Dida\\Route'               => 'Route/Route.php',
    'Dida\\RouteInterface'      => 'Route/RouteInterface.php',
    'Dida\\Router'              => 'Router/Router.php',
    'Dida\\Session'             => 'Session/Session.php',
    'Dida\\SingletonTrait'      => 'Traits/SingletonTrait.php',
    'Dida\\Staticall'           => 'Staticall/Staticall.php',
    'Dida\\Validator'           => 'Validator/Validator.php',
    'Dida\\View'                => 'View/View.php',
    'Dida\\Widget'              => 'Widget/Widget.php',
    
    /* 异常 */
    'Dida\ActionNotFoundException'     => 'Exception\ActionNotFoundException.php',
    'Dida\DatabaseConnectionException' => 'Exception\DatabaseConnectionException.php',
    'Dida\EventNotFoundException'      => 'Exception\EventNotFoundException.php',
    'Dida\InvalidDispatchException'    => 'Exception\InvalidDispatchException.php',
    'Dida\MethodNotFoundException'     => 'Exception\MethodNotFoundException.php',
    'Dida\PropertyGetException'        => 'Exception\PropertyGetException.php',
    'Dida\PropertySetException'        => 'Exception\PropertySetException.php',
];
