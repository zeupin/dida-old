<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Route 类
 */
class Route
{
    protected $app = null;


    public function __construct(Application &$app)
    {
        $this->app = $app;
    }
}
