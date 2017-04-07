<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\MVC;

use \Dida\Request;

/**
 * Controller 基类
 */
abstract class Controller
{
    protected $request = null;


    /**
     * 检查指定的action是否存在
     */
    public static function actionExists($action)
    {
        return method_exists(get_called_class(), $action);
    }


    /**
     * 设置request对象
     *
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }


    /**
     * 转发
     *
     * @param string $controller
     * @param string $action
     * @param array $parameters
     */
    public function forward($controller, $action, $parameters = [])
    {
    }


    /**
     * 重定向到另外一个url
     */
    public function redirect($url)
    {
        header('Location:' . $url);
    }
}
