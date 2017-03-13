<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Route 接口
 */
interface RouteInterface
{
    public function match();
    public function route();
    public static function assemble($controller, $action, array $parameters = []);
}
