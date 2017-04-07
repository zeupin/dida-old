<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Request\Exception;

use \Dida\Exception;

/**
 * InvalidRequestMethod 无效的Request方法
 *
 * RequestMethod只能为：GET，POST，PUT，PATCH，DELETE，OPTIONS，HEAD之一
 */
class InvalidRequestMethod extends Exception
{
}
