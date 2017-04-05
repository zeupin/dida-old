<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Foundation 类
 */
final class Foundation
{
    private static $initialized = false;


    /**
     * 禁用构造函数
     */
    private function __construct()
    {
    }


    /**
     * 禁用clone函数
     */
    private function __clone()
    {
    }


    /**
     * 初始化
     */
    public static function init()
    {
        // 确保本函数只执行一次
        if (self::$initialized) {
            return;
        }

        self::handleErrorsAndExceptions();
        self::loadFunctions();

        // 确保本函数只执行一次
        self::$initialized = true;
    }


    /**
     * 根据参数宏的定义，决定如何处理抛出的错误和异常
     */
    private static function handleErrorsAndExceptions()
    {
        if (DIDA_DEBUG) {
            // 报告所有 PHP 错误，参见 PHP 的 error_reporting() 文档
            error_reporting(E_ALL);
        } else {
            // 关闭所有 PHP 错误报告
            error_reporting(0);
        }
    }


    /**
     * 载入DIDA的全局函数库
     */
    private static function loadFunctions()
    {
        require DIDA_ROOT . 'Functions/Index.php';
    }
}
