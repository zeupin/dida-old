<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

/**
 * Dida
 */
final class Dida
{
    public static $app = null;


    public static function start()
    {
        self::$app = new \Dida\Application();
        self::$app->start();
    }
}
