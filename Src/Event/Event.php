<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Event 基类
 */
abstract class Event
{
    protected $events = [];


    /**
     * 新增一个事件到一个baseEvent事件之前
     */
    public function addEventBefore($newEvent, $baseEvent);


    /**
     * 新增一个事件到一个baseEvent事件之后
     */
    public function addEventAfter($newEvent, $baseEvent);


    /**
     * 挂接一个处理程序到指定的事件上
     */
    public function hook($event, $handler, $parameters);
}
