<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Container 服务容器类
 */
class Container implements \ArrayAccess
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
     * 实现ArrayAccess。检查键值是否存在。
     *
     * @param string $id
     */


    public function offsetExists($id)
    {
        return $this->has($id);
    }


    /**
     * 实现ArrayAccess。获取一个服务。
     *
     * @param string $id
     */
    public function offsetGet($id)
    {
        return $this->get($id);
    }


    /**
     * 实现ArrayAccess。注册一个服务。
     *
     * @param string $id
     * @param string|closure|object $service
     */
    public function offsetSet($id, $service)
    {
        return $this->set($id, $service);
    }


    /**
     * 实现ArrayAccess。删除一个条目。
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
     * 返回一个共享的服务实例
     *
     * 如果需要返回新的服务实例，需要用getNew()方法来完成。
     *
     * @param string $id 服务id
     * @param array $parameters 待传入的参数数组
     *
     * @return mixed
     */
    public function get($id, array $parameters = [])
    {
        if (!$this->has($id)) {
            throw new \Exception("服务容器中不存在指定服务id");
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
     * 注册一个服务
     *
     * @param string $id
     * @param string|closure|object $service
     *
     * @return bool 成功返回true
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
            throw new \Exception('传入的service类型不合法');
        }

        // 服务注册成功
        return true;
    }


    /**
     * 删除指定的条目
     *
     * @param string $id
     */
    public function remove($id)
    {
        unset($this->_keys[$id], $this->_classnames[$id], $this->_closures, $this->_instances[$id], $this->_singletons[$id]);
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
            throw new \Exception('未找到指定的服务id');
        }

        if (isset($this->_singletons[$id])) {
            throw new \Exception('已被注册为单例服务，不可生成新的服务实例');
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
     * 注册一个单例服务
     */
    public function singleton($id, $service)
    {
        $result = $this->bind($id, $service);
        if ($result) {
            $this->_singletons[$id] = true;
        }
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
