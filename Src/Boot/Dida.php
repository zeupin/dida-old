<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

use \Dida\Boot\Foundation;
use \Dida\Application\Application;

/**
 * Dida
 */
final class Dida
{
    public static $app = null;


    public static function start()
    {
        // 基础环境初始化
        Foundation::init();

        // 生成并启动Application实例
        self::$app = new Application;
        try {
            self::$app->start();
        } catch (\Exception $e) {
            include DIDA_ROOT . 'Exception/View/Html.php';
        }
    }
}
