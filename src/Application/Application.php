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
        $this->setConfig(new Config);
    }


    public function setConfig(Config &$config)
    {
        $this->config = $config;
    }


    private function bootstrap()
    {
    }


    public function run()
    {
    }
}
