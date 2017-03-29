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
    const SYSTEM_EVENT = 0;
    const USER_EVENT = 1;

    // 预定义的系统事件
    protected $events = [
        'dida_ready'      => self::SYSTEM_EVENT,
        'before_request'  => self::SYSTEM_EVENT,
        'after_request'   => self::SYSTEM_EVENT,
        'before_route'    => self::SYSTEM_EVENT,
        'after_route'     => self::SYSTEM_EVENT,
        'before_action'   => self::SYSTEM_EVENT,
        'after_action'    => self::SYSTEM_EVENT,
        'before_response' => self::SYSTEM_EVENT,
        'after_response'  => self::SYSTEM_EVENT,
    ];
    protected $hooks = [];


    /**
     * 新增一个用户事件
     */
    public function addEvent($event)
    {
        if (!array_key_exists($event, $this->events)) {
            $this->events[$event] = self::USER_EVENT;
        }
        return $this;
    }


    /**
     * 删除一个用户事件，以及所有已挂接到这个事件hooks。
     * 注：系统事件不可删除。
     */
    public function removeEvent($event)
    {
        if (array_key_exists($event, $this->events)) {
            if ($this->events[$event] == self::USER_EVENT) {
                unset($this->events[$event]);
                unset($this->hooks[$event]);
            }
        }
        return $this;
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
        return $this;
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
        return $this;
    }


    /**
     * 清除挂接在指定event上的所有处理程序
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
        if (array_key_exists($event, $this->hooks)) {
            /*
             * 依次执行处理程序
             * 注：如果某个处理程序返回false，则不再执行后面的处理程序。
             */
            foreach ($hooks as $hook) {
                list($handler, $parameters) = $hook;
                if (call_user_func_array($handler, $parameters) === false) {
                    break;
                }
            }
        } else {
            /*
             * 如果事件不存在，抛出EventNotFound异常
             */
            if (!array_key_exists($event, $events)) {
                throw new \Dida\Exception\EventNotFound();
            }
        }
    }
}
