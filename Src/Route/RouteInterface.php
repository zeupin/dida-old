<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Route Interface
 */
interface RouteInterface
{
    /**
     * 设置要匹配的Request
     */
    public function setRequest(Request $request);


    /**
     * 对Request进行路由匹配
     *
     * @return bool 匹配成功返回true，否则返回false
     */
    public function match();


    /**
     * 分派任务
     */
    public function dispatch();


    /**
     * 按照本路由规则，组装一个路由
     */
    public static function assemble($controller, $action, array $parameters = []);
}
