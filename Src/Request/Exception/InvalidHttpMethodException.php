<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Request\Exception;

use \Dida\Exception;

/**
 * InvalidHttpMethodException 无效的HttpMethod方法
 *
 * HttpMethod只能为：GET，POST，PUT，PATCH，DELETE，OPTIONS，HEAD之一
 */
class InvalidHttpMethodException extends Exception
{
}
