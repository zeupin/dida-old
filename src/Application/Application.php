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


    public function start()
    {
        $this['app'] = $this;

        // 启动Staticall机制
        Staticall::init($this, VAR_ROOT);
        Staticall::link('App', 'app');

        $this->loadAppConfig();
        $this->bootstrap();
        $this->run();
    }


    private function loadAppConfig()
    {
        $target = APP_ROOT . 'Config/App.php';
        if (file_exists($target) && is_file($target)) {
            $this->config->load($target);
        }
    }


    private function bootstrap()
    {
        $app = $this;

        $target = APP_ROOT . 'Bootstrap/index.php';
        if (file_exists($target) && is_file($target)) {
            require $target;
        }
    }


    private function run()
    {
    }


    public function getConfig()
    {
        return $this->config;
    }
}
