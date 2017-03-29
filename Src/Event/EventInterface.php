<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Event Interface
 */
interface EventInterface
{
    /**
     * 注册一个事件
     *
     * @param string $event
     * @param callback $callback
     * @param array $parameters
     */
    public function on($event, $callback, array $parameters = []);


    /**
     * 注销一个事件
     *
     * @param string $event
     */
    public function off($event);


    /**
     * 注册一个一次性事件
     *
     * @param string $event
     * @param callback $callback
     * @param array $parameters
     */
    public function once($event, $callback, array $parameters = []);


    /**
     * 触发一个事件
     * @param string $event
     */
    public function tigger($event);
}
