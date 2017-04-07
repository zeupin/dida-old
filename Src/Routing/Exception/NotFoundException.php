<?php

/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Routing\Exception;

use \Dida\Exception;

/**
 * NotFoundException
 *
 * 1. 如果遍历所有的路由规则后，都无法匹配这个url，返回404错误
 */
class NotFoundException extends Exception
{
}
