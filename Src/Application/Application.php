<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Application;

use \Dida\Container;
use \Dida\Config;
use \Dida\Request\ConsoleRequest;
use \Dida\HttpRequest;
use \Dida\Response;
use \Dida\Event\EventBus;
use \Dida\Exception\PropertyGetException;
use \Dida\Exception\FileNotFoundException;

/**
 * Application 类
 */
final class Application extends Container
{
    /* 属性变量 */
    protected $config = null;    // 配置
    protected $request = null;   // 请求
    protected $response = null;  // 应答
    protected $eventbus = null;  // 事件总线

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
        // 基础变量
        $this->config = new Config;
        $this->response = new Response;
        $this->request = (DIDA_IS_CLI) ? (new ConsoleRequest) : (new HttpRequest);
        $this->eventbus = new EventBus;
    }


    /**
     * 和App相关部分的初始化
     */
    private function bootstrap()
    {
        $app = $this;

        // 载入App配置： [AppRoot]/Config/App.***.php
        $target = DIDA_APP_ROOT . 'Config/App.' . DIDA_ENV . '.php';
        if (file_exists($target) && is_file($target)) {
            $this->config->load($target);
        }

        // 载入app级别的函数库：[AppRoot]/Functions/Index.php
        $target = DIDA_APP_ROOT . 'Functions/Index.php';
        if (file_exists($target) && is_file($target)) {
            include $target;
        }

        // 载入app的自举程序：[AppRoot]/Bootstraps/Index.php
        $target = DIDA_APP_ROOT . 'Bootstraps/Index.php';
        if (file_exists($target) && is_file($target)) {
            include $target;
        }
    }


    /**
     * 载入app的入口程序，正式开始处理app
     *
     * 载入 <App>/Index.php
     */
    private function run()
    {
        $app = $this;
        $APP_ENTRY_FILE = DIDA_APP_ROOT . 'Index.php';
        if (!file_exists($APP_ENTRY_FILE)) {
            throw new FileNotFoundException($APP_ENTRY_FILE);
        }
        require $APP_ENTRY_FILE;
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
            case 'request':
                return $this->request;
            case 'eventbus':
                return $this->eventbus;
            default:
                if ($this->has($id)) {
                    return $this->get($id);
                } else {
                    throw new PropertyGetException($id);
                }
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
