<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */


/**
 * 将$app转化为一个全局可见的引用
 */
function App($service_id = null)
{
    global $app;

    if ($service_id === null) {
        return $app;
    }

    if ($app->has($service_id)) {
        return $app($service_id);
    } else {
        return null;
    }
}
