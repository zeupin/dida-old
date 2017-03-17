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


    /**
     * 检查指定的action是否存在
     */
    public static function actionExists($action)
    {
        return method_exists(get_called_class(), $action);
    }


    public function render()
    {
    }


    public function forward()
    {
    }


    public function redirect()
    {
    }
}
