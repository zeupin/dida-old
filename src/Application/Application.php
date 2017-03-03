<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Application 类
 */
final class Application extends Container
{
    /* 服务容器的配置参数 */
    public $config = null;


    public function __construct()
    {
        $this->config = new Config;
    }


    public function setConfig(Config &$config)
    {
        $this->config = $config;
    }


    public function start()
    {
        $this->bootstrap();
        $this->run();
    }


    private function bootstrap()
    {
        $bootstrap = function (&$app) {
            $target = APP_ROOT . 'Bootstrap/index.php';
            if (file_exists($target) && is_file($target)) {
                require $target;
            }
        };
        $bootstrap($this);
    }


    private function run()
    {
    }
}
