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
     *
     * uri 一般表示为 path?query=...#fragment
     */
    private function parseUrl()
    {
        // 检查请求的uri是否有效
        if (strncasecmp($_SERVER['REQUEST_URI'], DIDA_WWW, strlen(DIDA_WWW)) != 0) {
            throw new UriException;
        }

        // 分解uri
        $url = parse_url($_SERVER['REQUEST_URI']);

        // 处理path部分
        if (isset($url['path'])) {
            // 去除DIDA_WWW后的部分
            $path = substr($url['path'], strlen(DIDA_WWW));
            $this->path = explode('/', $path);
        }

        // 处理query部分
        if (isset($url['query'])) {
            $this->query = $url['query'];
        }

        // 处理fragment部分
        if (isset($url['$fragment'])) {
            $this->fragment = $url['$fragment'];
        }
    }
}
