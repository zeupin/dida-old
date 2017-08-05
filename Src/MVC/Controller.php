<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\MVC;

use \Dida\Request;
use \Dida\Routing\Router;
use \Dida\Routing\Exception\ActionNotFoundException;

/**
 * Controller 基类
 */
abstract class Controller
{
    protected $request = null;


    public function __construct()
    {
        $this->init();
    }


    /**
     * Controller的公共入口程序
     */
    public function init()
    {
    }


    /**
     * 检查指定的action是否存在。
     *
     * 默认是检查当前Controller有没有对应的Action方法。
     * 如果和上述默认设置不一样，可以在继承时进行覆盖。
     *
     * @param string $action
     */
    public static function actionExists($action)
    {
        return method_exists(get_called_class(), $action . 'Action');
    }


    /**
     * 执行指定的Action
     *
     * 1. 默认是执行当前Controller实例中的action方法。如果和上述默认方法不一致，可以在继承时进行覆盖。
     * 2. 一般Controller级别的权限认证也在这里做。
     *
     * @param string $action
     * @param array $parameters
     */
    public function execute($action, $parameters = [])
    {
        // 如果action不存在，直接抛异常
        if (!self::actionExists($action)) {
            throw new ActionNotFoundException(get_called_class() . '->' . $action);
        }

        // 调用$this的action方法
        return call_user_func_array([$this, $action . 'Action'], $parameters);
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
        Router::dispatch($controller, $action, $parameters);
    }


    /**
     * 重定向到另外一个url
     *
     * @param string $url
     */
    public function redirect($url)
    {
        header('Location:' . $url);
    }
}
