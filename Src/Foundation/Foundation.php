<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Foundation 类
 */
class Foundation
{
    private static $initialized = false;


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


    private static function loadFunctions()
    {
        require DIDA_ROOT . 'Functions/Index.php';
    }
}
