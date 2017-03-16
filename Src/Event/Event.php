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
    // 预定义的系统事件
    protected $events = [
        'dida_ready'      => 0,
        'before_request'  => 0,
        'after_request'   => 0,
        'before_route'    => 0,
        'after_route'     => 0,
        'before_action'   => 0,
        'after_action'    => 0,
        'before_response' => 0,
        'after_response'  => 0,
    ];
    protected $hooks = [];


    /**
     * 新增一个用户事件
     */
    public function addEvent($event)
    {
        if (!array_key_exists($event, $this->events)) {
            $this->events[$event] = 1;
        }
    }


    /**
     * 删除一个用户事件，以及所有已挂接到这个事件hooks。
     * 注，预定义的系统事件是不可删除的。
     */
    public function removeEvent($event)
    {
        if (array_key_exists($event, $this->events)) {
            if ($this->events[$event] > 0) {
                unset($this->events[$event]);
                unset($this->hooks[$event]);
            }
        }
    }


    /**
     * 检查一个事件是否已经定义
     */
    public function hasEvent($event)
    {
        return array_key_exists($event, $this->events);
    }


    /**
     * 挂接一个处理程序到指定的event上
     *
     * @param string $event
     * @param string $handler
     * @param array $parameters
     * @param string $id
     */
    public function hook($event, $handler, array $parameters = [], $id = DIDA_NOT_SET)
    {
        if ($this->hasEvent($event)) {
            if ($id === DIDA_NOT_SET) {
                $this->hooks[$event][] = [$handler, $parameters];
            } else {
                $this->hooks[$event][$id] = [$handler, $parameters];
            }
        } else {
            throw new \Dida\Exception\EventNotFound();
        }
    }


    /**
     * 解除event上某个id的处理程序的挂接
     *
     * @param string $event
     * @param string $id
     */
    public function unhook($event, $id)
    {
        unset($this->hooks[$event][$id]);
    }


    /**
     * 清除挂接在某个event上的所有处理程序
     *
     * @param string $event
     */
    public function unhookAll($event)
    {
        unset($this->hooks[$event]);
    }


    /**
     * 触发一个事件
     */
    public function tigger($event)
    {
        if (array_key_exists($event, $events)) {
            if (array_key_exists($event, $this->hooks)) {
                foreach ($hooks as $hook) {
                    list($handler, $parameters) = $hook;
                    call_user_func_array($handler, $parameters);
                }
            }
        } else {
            throw new \Dida\Exception\EventNotFound();
        }
    }
}
