<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

use \Dida\Application;

/**
 * Dida
 */
final class Dida
{
    public static $app = null;


    public static function start()
    {
        self::$app = new Application;
        self::$app->start();
    }
}
