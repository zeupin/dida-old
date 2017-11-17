<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\HttpRequest\Exception;

use \Dida\Exception;

/**
 * InvalidRequestMethodException 无效的 RequestMethod 方法
 *
 * RequestMethod 只能为：GET,POST,PUT,PATCH,DELETE,OPTIONS,HEAD 之一
 */
class InvalidRequestMethodException extends Exception
{
}
