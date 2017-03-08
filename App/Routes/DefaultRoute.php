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
    public function match()
    {
        $path = explode('/', $this->request->path, 3);

        $controller = (isset($path[0])) ? $path[0] : '';
        $action = (isset($path[1])) ? $path[1] : '';

        $entry = strtolower("{$controller}/{$action}");

        // 检查routemap中是否定义了这个文件
        if (!array_key_exists($entry, $this->routemap)) {
            return false;
        }

        list($this->controller, $this->action) = $this->routemap[$entry];
        return true;
    }


    public function route()
    {
        app()->set('controller', $this->controller);
        $callback = [app('controller'), $this->action];
        return call_user_func_array($callback, $this->parameters);
    }


    public static function assemble($controller, $action, array $parameters = array())
    {
        return str_replace('\\', '/', "$controller/$action");
    }
}
