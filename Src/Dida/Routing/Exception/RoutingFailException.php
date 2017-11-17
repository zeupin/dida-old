<?php

/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Routing\Exception;

use \Dida\Exception;

/**
 * RoutingFailException
 *
 * 1. 如果遍历所有的路由规则后，都无法匹配，则返回此异常
 */
class RoutingFailException extends Exception
{
}
