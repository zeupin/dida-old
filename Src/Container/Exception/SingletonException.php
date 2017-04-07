<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Container\Exception;

use \Dida\Exception;

/**
 * SingletonException 单例服务异常
 *
 * 1. 已将一个服务注册为singleton，但是又对其尝试用getNew()的方法
 */
class SingletonException extends Exception
{
}
