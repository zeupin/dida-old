<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Request\Exception;

use \Dida\Exception;

/**
 * InvalidQueryException 无效的查询串
 *
 * 1. 查询串的格式不正确，不是 name=value 的形式
 */
class InvalidQueryException extends Exception
{
}
