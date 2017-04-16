<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Container;

use \ArrayAccess;
use \Dida\Container\Exception\InvalidServiceException;
use \Dida\Container\Exception\ServiceNotFoundException;
use \Dida\Container\Exception\SingletonException;

/**
 * Container 容器类，主要用于依赖注入和服务定位。
 *
 * 从运行效率考虑，Container设计为只包含服务定义，不包含配置定义。
 * 不然，每次想引用一个service，都要从几十个conf中逐个找下来，会滞碍运行速度。
 */
class Container implements ArrayAccess
{
    /* 类型常量 */
    const CLASSNAME_TYPE = 'classname';     // 类名字符串
    const CLOSURE_TYPE = 'closure';         // 闭包
    const INSTANCE_TYPE = 'instance';       // 服务实例

    /* 所有服务的keys */
    private $_keys = [];

    /* 不同种类的服务集合 */
    private $_classnames = [];  // 类名
    private $_closures = [];    // 闭包
    private $_instances = [];   // 已生成的实例
    private $_singletons = [];  // 单例服务


    /**
     * 实现ArrayAccess:检查键值是否存在。
     *
     * @param string $id
     */
    public function offsetExists($id)
    {
        return $this->has($id);
    }


    /**
     * 实现ArrayAccess:获取一个服务。
     *
     * @param string $id
     */
    public function offsetGet($id)
    {
        return $this->get($id);
    }


    /**
     * 实现ArrayAccess:注册一个服务。
     *
     * @param string $id
     * @param string|closure|object $service
     */
    public function offsetSet($id, $service)
    {
        return $this->set($id, $service);
    }


    /**
     * 实现ArrayAccess:删除一个条目。
     *
     * @param string $id
     */
    public function offsetUnset($id)
    {
        return $this->remove($id);
    }


    /**
     * 是否已经注册此id
     *
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        return array_key_exists($id, $this->_keys);
    }


    /**
     * 注册一个服务
     *
     * @param string $id
     * @param string|closure|object $service
     *
     * @return Container $this 链式调用
     */
    public function set($id, $service)
    {
        if ($this->has($id)) {
            $this->remove($id);
        }

        if (is_string($service)) {
            $this->_keys[$id] = self::CLASSNAME_TYPE;
            $this->_classnames[$id] = $service;
        } elseif (is_object($service)) {
            if ($service instanceof \Closure) {
                $this->_keys[$id] = self::CLOSURE_TYPE;
                $this->_closures[$id] = $service;
            } else {
                $this->_keys[$id] = self::INSTANCE_TYPE;
                $this->_instances[$id] = $service;
            }
        } else {
            throw new InvalidServiceException('传入的service类型不合法');
        }

        // 服务注册成功
        return $this;
    }


    /**
     * 注册一个单例服务
     *
     * @param string $id
     * @param string|closure|object $service
     *
     * @return Container $this 链式调用
     */
    public function setSingleton($id, $service)
    {
        $this->set($id, $service);
        $this->_singletons[$id] = true;
        return $this;
    }


    /**
     * 返回一个共享的服务实例
     *
     * 如果需要返回新的服务实例，需要用getNew()方法来完成。
     *
     * @param string $id 服务id
     * @param array $parameters 待传入的参数数组，可选填
     *
     * @return mixed
     */
    public function get($id, array $parameters = [])
    {
        if (!$this->has($id)) {
            throw new ServiceNotFoundException("容器中不存在指定id的服务");
        }

        $obj = null;

        switch ($this->_keys[$id]) {
            case self::INSTANCE_TYPE:
                return $this->_instances[$id];

            case self::CLOSURE_TYPE:
                //如果服务实例以前已经创建，直接返回创建好的服务实例
                if (isset($this->_instances[$id])) {
                    return $this->_instances[$id];
                }
                // 如果是第一次运行，则创建新服务实例，并保存备用
                $serviceInstance = call_user_func_array($this->_closures[$id], $parameters);
                $this->_instances[$id] = $serviceInstance;
                return $serviceInstance;

            case self::CLASSNAME_TYPE:
                //如果服务实例以前已经创建，直接返回创建好的服务实例
                if (isset($this->_instances[$id])) {
                    return $this->_instances[$id];
                }
                // 如果是第一次运行，则创建新服务实例，并保存备用
                $class = new \ReflectionClass($this->_classnames[$id]);
                if (!$class->isInstantiable()) {
                    return null;
                }
                $serviceInstance = new $this->_classnames[$id];
                $this->_instances[$id] = $serviceInstance;
                return $serviceInstance;
        } // switch
    }


    /**
     * 返回一个新的服务实例
     *
     * @param string $id 服务id
     * @param array $parameters 待传入的参数数组
     *
     * @return mixed
     */
    public function getNew($id, array $parameters = [])
    {
        if (!$this->has($id)) {
            throw new ServiceNotFoundException("容器中不存在指定id的服务");
        }

        if (isset($this->_singletons[$id])) {
            throw new SingletonException('已被注册为单例服务，不可生成新的服务实例');
        }

        $obj = null;

        switch ($this->_keys[$id]) {
            case self::INSTANCE_TYPE:
                return $this->_instances[$id];

            case self::CLOSURE_TYPE:
                $serviceInstance = call_user_func_array($this->_closures[$id], $parameters);
                return $serviceInstance;

            case self::CLASSNAME_TYPE:
                $class = new \ReflectionClass($this->_classnames[$id]);
                if (!$class->isInstantiable()) {
                    return null;
                }
                $serviceInstance = new $this->_classnames[$id];
                return $serviceInstance;
        } // switch
    }


    /**
     * 删除指定的条目
     *
     * @param string $id
     */
    public function remove($id)
    {
        unset($this->_keys[$id]);
        unset($this->_classnames[$id], $this->_closures, $this->_instances[$id], $this->_singletons[$id]);
    }


    /**
     * 返回所有的keys
     *
     * @return array
     */
    public function keys()
    {
        return $this->_keys;
    }
}
