<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */


/**
 * 将$app转化为一个全局可见的函数
 */
function app($service_id = null)
{
    if ($service_id === null) {
        return \Dida::$app;
    }

    if (\Dida::$app->has($service_id)) {
        return \Dida::$app->get($service_id);
    } else {
        throw new \Dida\Exception\PropertyGetException($service_id);
    }
}
