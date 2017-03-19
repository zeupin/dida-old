<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Session 类
 */
class Session implements \ArrayAccess
{
    public function offsetExists($key)
    {
        return array_key_exists($key, $_SESSION);
    }


    public function offsetGet($key)
    {
        return ($this->offsetExists($key)) ? $_SESSION[$key] : DIDA_NOT_SET;
    }


    public function offsetSet($key, $value)
    {
        $_SESSION[$key] = $value;
    }


    public function offsetUnset($key)
    {
        unset($_SESSION[$key]);
    }
}
