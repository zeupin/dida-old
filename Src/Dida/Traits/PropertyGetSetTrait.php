<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Traits;

use \Dida\Exception\PropertyGetException;
use \Dida\Exception\PropertySetException;

/**
 * Get/Set Trait
 */
trait PropertyGetSetTrait
{
    /**
     * 如果某个属性不可见，检查是否有对应的Getter
     *
     * @param string $name 属性名
     */
    public function __get($name)
    {
        if (method_exists($this, $name . '__Get')) {
            return call_user_func([$this, $name . '__Get']);
        }

        // 没有找到的话，抛异常
        throw new PropertyGetException(get_called_class() . '->' . $name);
    }


    /**
     * 如果某个属性不可见，检查是否有对应的Setter
     *
     * @param string $name 属性名
     * @param string $value 属性值
     */
    public function __set($name, $value)
    {
        if (method_exists($this, $name . '__Set')) {
            call_user_func_array([$this, $name . '__Set'], [$value]);
            return;
        }

        // 没有找到的话，抛异常
        throw new PropertySetException(get_called_class() . '->' . $name);
    }
}
