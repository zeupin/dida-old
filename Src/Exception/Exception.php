<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Exception 类
 */
class Exception extends \Exception
{
    /**
     * 获取抛出的Exception的具体类名
     */
    public function getType()
    {
        return get_called_class();
    }
}
