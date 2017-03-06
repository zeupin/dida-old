<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace App\Routes;

/**
 * Default Route
 */
class DefaultRoute extends \Dida\Route
{
    public $controller = '';
    public $action = '';


    public function match()
    {
        $request = app('request');
        $path = explode('/', $request->path, 3);

        $controller = '';
        $action = '';

        if (isset($path[0])) {
            $controller = $path[0];
            if (isset($path[1])) {
                $action = $path[1];
            }
        }

        $main =strtolower("$controller/$action");

        app()->config->load(APP_ROOT . 'Config/RouteMap.php');

        return true;
    }


    public function route()
    {
    }


    public function assemble($controller, $action, array $parameters = array())
    {
    }
}
