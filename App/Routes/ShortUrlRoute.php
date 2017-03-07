<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace App\Routes;

/**
 * Short Url Route
 *
 * @author Macc Liu <mail@maccliu.com>
 */
class ShortUrlRoute extends \Dida\Route
{
    public function match()
    {
        return false;
    }


    public function route()
    {
    }


    public static function assemble($controller, $action, array $parameters = array())
    {
    }
}
