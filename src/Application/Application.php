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
    public $response = null;


    public function __construct()
    {
        $this->config = new Config;
        $this->response = new Response;
    }


    public function start()
    {
        $this['app'] = $this;

        // 启动Staticall机制
        Staticall::init($this, VAR_ROOT);
        Staticall::link('App', 'app');      // 链接App伪类到$app['app']
        // 载入app配置
        $this->loadAppConfig();

        // 载入App函数库
        $this->loadAppFunctions();

        // 依次载入app的bootstraps
        $this->bootstrap();

        // 准备工作就绪，正式处理用户发起的请求
        $this->run();
    }


    private function loadAppConfig()
    {
        $target = APP_ROOT . 'Config/App.' . APP_ENVIRON . '.php';
        if (file_exists($target) && is_file($target)) {
            $this->config->load($target);
        }
    }


    private function loadAppFunctions()
    {
        $target = APP_ROOT . 'Functions/Index.php';
        if (file_exists($target) && is_file($target)) {
            require $target;
        }
    }


    private function bootstrap()
    {
        $app = $this;

        $target = APP_ROOT . 'Bootstrap/Index.php';
        if (file_exists($target) && is_file($target)) {
            require $target;
        }
    }


    private function run()
    {
        require APP_ROOT . 'Index.php';
    }
}
