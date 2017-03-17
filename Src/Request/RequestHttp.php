<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Request 类
 */
class RequestHttp extends Request
{
    public $path = [];
    public $query = [];
    public $fragment = '';


    public function __construct()
    {
        $this->parseUrl();
    }


    /**
     * 把URI拆分为path,query,fragment
     */
    private function parseUrl()
    {
        $url = parse_url($_SERVER['REQUEST_URI']);

        if (isset($url['path'])) {
            // 去除DIDA_WWW后的部分
            $path = substr($url['path'], strlen(DIDA_WWW));
            $this->path = explode('/', $path);
        }
        if (isset($url['query'])) {
            $this->query = $url['query'];
        }
        if (isset($url['$fragment'])) {
            $this->fragment = $url['$fragment'];
        }
    }
}
