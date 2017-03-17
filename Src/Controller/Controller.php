<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Controller 基类
 */
abstract class Controller implements ControllerInterface
{
    public static function actionExists($action)
    {
        return method_exists(get_called_class(), $action);
    }


    public function forward();  // todo
    public function redirect(); // todo
    public function render(); // todo
}
