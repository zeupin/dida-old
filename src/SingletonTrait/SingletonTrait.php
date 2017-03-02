<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * SingletonTrait 单例模式特性
 */
trait SingletonTrait
{
    /**
     * 保存类的实例
     */
    private static $_instance = null;


    /**
     * 不准 new操作
     */
    private function __construct()
    {
    }


    /**
     * 不准 clone()操作
     */
    private function __clone()
    {
    }


    /**
     * 获取类的实例，在首次访问时，生成一个新实例
     */
    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
}
