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


    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }


    public function get($key)
    {
        return $_SESSION[$key];
    }


    public function has($key)
    {
        return array_key_exists($key, $_SESSION);
    }


    public function remove($key)
    {
        unset($_SESSION[$key]);
    }


    /**
     * 删除所有$_SESSION变量
     *
     * @param array $except[] 可以指定保留哪些SESSION变量
     */
    public function clear($except = [])
    {
        $session = [];
        foreach ($except as $key) {
            if (array_key_exists($key, $_SESSION)) {
                $session[$key] = $_SESSION;
            }
        }
        session_unset();
        foreach ($session as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }
}
