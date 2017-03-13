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


    /**
     * 启动
     */
    public function start()
    {
        // 基础环境初始化
        Foundation::init();

        // 基础变量
        $this->config = new Config;
        $this->response = new Response;

        // 载入app配置
        $this->loadAppConfig();

        // 载入App函数库
        $this->loadAppFunctions();

        // 依次载入App的bootstraps
        $this->loadAppBootstraps();

        // 准备工作就绪，正式处理用户请求
        $this->run();
    }


    /**
     * 根据不同的DIDA_ENVIRON载入不同的配置文件
     */
    private function loadAppConfig()
    {
        $target = DIDA_APP_ROOT . 'Config/App.' . DIDA_ENVIRON . '.php';
        if (file_exists($target) && is_file($target)) {
            $this->config->load($target);
        }
    }


    private function loadAppFunctions()
    {
        $target = DIDA_APP_ROOT . 'Functions/Index.php';
        if (file_exists($target) && is_file($target)) {
            $app = $this;
            require $target;
        }
    }


    private function loadAppBootstraps()
    {
        $target = DIDA_APP_ROOT . 'Bootstraps/Index.php';
        if (file_exists($target) && is_file($target)) {
            $app = $this;
            require $target;
        }
    }


    private function run()
    {
        $app = $this;
        require DIDA_APP_ROOT . 'Index.php';
    }
}
