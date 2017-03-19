<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Get/Set Trait
 */
trait GetSetTrait
{


    /**
     * 如果某个属性不可见，检查是否有对应的Getter
     *
     * @param string $name 属性名
     */
    public function __get($name)
    {
        if (method_exists($this, $name . 'Get')) {
            return call_user_func([$this, $name . 'Get']);
        }
    }


    /**
     * 如果某个属性不可见，检查是否有对应的Setter
     *
     * @param string $name 属性名
     * @param string $value 属性值
     */
    public function __set($name, $value)
    {
        if (method_exists($this, $name . 'Set')) {
            call_user_func_array([$this, $name . 'Set'], [$value]);
        }
    }
}
