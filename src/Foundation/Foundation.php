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
    private function handleErrorsAndExceptions()
    {
        if (DIDA_DEBUG_MODE) {
            // 报告所有 PHP 错误，参见 PHP 的 error_reporting() 文档
            error_reporting(E_ALL);
        } else {
            // 关闭所有 PHP 错误报告
            error_reporting(0);
        }
    }
}
