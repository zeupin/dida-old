<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * EventBus 事件总线
 */
final class EventBus
{
    const SYSTEM_EVENT = 0;     // 系统预定义事件
    const USER_EVENT = 1;       // 用户自定义事件

    /*
     * 预定义的系统事件
     */
    private $events = [
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

    /*
     * 挂接在事件上的回调函数
     * $hooks["event_name"][id] = callback()
     */
    protected $hooks = [];


    /**
     * 新增一个用户事件
     *
     * @param string $event 事件名称
     */
    public function addEvent($event)
    {
        if (!array_key_exists($event, $this->events)) {
            $this->events[$event] = self::USER_EVENT;
        }
        return $this;
    }


    /**
     * 删除一个用户事件，以及所有已挂接到这个事件上的回调函数
     * 注：系统事件不可删除，只能删除用户事件。
     *
     * @param string $event 事件名称
     */
    public function removeEvent($event)
    {
        // 删除此事件的所有hooks
        unset($this->hooks[$event]);

        // 如果此事件是用户事件，则删除之
        if (array_key_exists($event, $this->events)) {
            if ($this->events[$event] == self::USER_EVENT) {
                unset($this->events[$event]);
            }
        }

        // return
        return $this;
    }


    /**
     * 检查一个事件是否已经定义
     *
     * @param string $event 事件名称
     */
    public function hasEvent($event)
    {
        return array_key_exists($event, $this->events);
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
            throw new \Dida\EventNotFoundException();
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
                throw new \Dida\EventNotFoundException();
            }
        }
    }
}
