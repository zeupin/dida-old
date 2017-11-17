<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Event;

use \Dida\Event\Exception\EventNotFoundException;

/**
 * EventBus 事件总线
 *
 * 有两种事件类型：系统事件和用户事件，区别在于系统事件不可删除。
 */
final class EventBus
{
    const SYSTEM_EVENT = 1;     // 系统事件
    const USER_EVENT = 2;       // 用户事件

    /*
     * 所有事件
     */
    protected $events = [];

    /*
     * 挂接在事件上的回调函数
     * $hooks["event_name"][id] = callback()
     */
    protected $hooks = [];


    /**
     * 新增一个系统事件
     *
     * @param string $event 事件名称
     * @return bool 成功返回true，失败返回false
     */
    public function addSystemEvent($event)
    {
        if (isset($this->events[$event])) {
            return ($this->events[$event] == self::SYSTEM_EVENT);
        } else {
            $this->events[$event] = self::SYSTEM_EVENT;
            return true;
        }
    }


    /**
     * 新增一个用户事件
     *
     * @param string $event 事件名称
     */
    public function addUserEvent($event)
    {
        if (isset($this->events[$event])) {
            return ($this->events[$event] == self::USER_EVENT);
        } else {
            $this->events[$event] = self::USER_EVENT;
            return true;
        }
    }


    /**
     * 删除一个用户事件，以及所有已挂接到这个事件上的回调函数
     *
     * @param string $event 事件名称
     * @return bool 删除用户事件是否完成。
     */
    public function removeUserEvent($event)
    {
        if (isset($this->events[$event])) {
            if ($this->events[$event] == self::USER_EVENT) {
                // 删除此事件和所有hooks
                unset($this->events[$event]);
                unset($this->hooks[$event]);
                return true;
            } else {
                // 事件未删除
                return false;
            }
        } else {
            return true;
        }
    }


    /**
     * 检查一个事件是否已经定义
     *
     * @param string $event 事件名称
     */
    public function hasEvent($event)
    {
        return isset($this->events[$event]);
    }


    /**
     * 在指定事件上挂接一个回调函数
     *
     * @param string $event      事件名称
     * @param callback $callback 回调函数
     * @param array $parameters  回调函数的参数
     * @param string $id         设置这个回调函数的id
     */
    public function hook($event, $callback, array $parameters = [], $id = null)
    {
        if ($this->hasEvent($event)) {
            if ($id === null) {
                $this->hooks[$event][] = [$callback, $parameters];
            } else {
                $this->hooks[$event][$id] = [$callback, $parameters];
            }
        } else {
            throw new EventNotFoundException($event);
        }
        return $this;
    }


    /**
     * 解除某个事件上挂接的某个或者全部回调函数
     * 如果不指定id，则表示解除此事件上的所有回调函数
     *
     * @param string $event 事件名称
     * @param string $id    回调函数的id
     */
    public function unhook($event, $id = null)
    {
        if ($id === null) {
            unset($this->hooks[$event]);
        } else {
            unset($this->hooks[$event][$id]);
        }
        return $this;
    }


    /**
     * 触发一个事件，并执行挂接在这个事件上的所有回调函数
     * 注：如果某个回调函数返回false，则不再执行后面的回调函数。
     *
     * @param string $event 事件名称
     */
    public function tigger($event)
    {
        if (array_key_exists($event, $this->hooks)) {
            /*
             * 依次执行此事件上的所有回调函数
             * 注：如果某个回调函数返回false，则不再执行后面的回调函数。
             */
            foreach ($hooks as $hook) {
                list($callback, $parameters) = $hook;
                if (call_user_func_array($callback, $parameters) === false) {
                    break;
                }
            }
        } else {
            /*
             * 如果事件不存在，抛出EventNotFound异常
             */
            if (!array_key_exists($event, $events)) {
                throw new EventNotFoundException($event);
            }
        }
    }
}
