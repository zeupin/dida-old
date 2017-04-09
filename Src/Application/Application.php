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
    /* 公有变量 */
    protected $config = null;    // 配置
    protected $response = null;  // 响应

    /**
     * 启动
     */
    public function start()
    {
        // 和app无关部分的初始化
        $this->init();

        // 和app有关部分的初始化
        $this->bootstrap();

        // 准备工作就绪，正式处理用户请求
        $this->run();
    }


    /**
     * 和App无关的通用环境的初始化
     */
    private function init()
    {
        // 基础环境初始化
        Foundation::init();

        // 基础变量
        $this->config = new Config;
        $this->response = new Response;
    }


    /**
     * 和App相关部分的初始化
     */
    private function bootstrap()
    {
        // 载入App配置
        $this->loadAppConfig();

        // 载入App函数库
        $this->loadAppFunctions();

        // 依次载入App的bootstraps
        $this->loadAppBootstraps();
    }


    /**
     * 根据不同的DIDA_ENV载入不同的配置文件
     */
    private function loadAppConfig()
    {
        $target = DIDA_APP_ROOT . 'Config/App.' . DIDA_ENV . '.php';
        if (file_exists($target) && is_file($target)) {
            $this->config->load($target);
        }
    }


    /**
     * 载入app级别的函数库
     */
    private function loadAppFunctions()
    {
        $target = DIDA_APP_ROOT . 'Functions/Index.php';
        if (file_exists($target) && is_file($target)) {
            $app = $this;
            require $target;
        }
    }


    /**
     * 载入app的自举程序
     */
    private function loadAppBootstraps()
    {
        $target = DIDA_APP_ROOT . 'Bootstraps/Index.php';
        if (file_exists($target) && is_file($target)) {
            $app = $this;
            require $target;
        }
    }


    /**
     * 载入app的入口程序，正式开始处理app
     */
    private function run()
    {
        $app = $this;
        require DIDA_APP_ROOT . 'Index.php';
    }


    /**
     * 解析未定义的类属性
     */
    public function __get($id)
    {
        switch ($id) {
            case 'config':
                return $this->config;
            case 'response':
                return $this->response;
            default:
                return $this->get($id);
        }
    }


    /**
     * 设置未定义的类属性
     */
    public function __set($id, $service)
    {
        $this->set($id, $service);
    }
}
