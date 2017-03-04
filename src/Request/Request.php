<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Request 类
 */
class Request
{
    public $method = null;


    public function __construct()
    {
        $this->method = $this->getMethod();
    }


    private function getMethod()
    {
        if (IS_CLI) {
            return '';
        }

        // 按照使用频率定义的有效method列表
        $methods = ['POST', 'GET', 'DELETE', 'PUT', 'PATCH', 'OPTIONS', 'HEAD'];

        // 如果定义了$_POST['_method']，优先采用这个定义
        if (isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
            if (in_array($method, $methods, true)) {
                return $method;
            } else {
                return 'UNKNOWN';
            }
        }

        // 采用默认定义
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $method = strtoupper($_SERVER['REQUEST_METHOD']);
            return $methd;
        }

        // 都没有就返回null
        return null;
    }
}
