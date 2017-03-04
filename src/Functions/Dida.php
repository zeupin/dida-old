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


/**
 * 停止执行程序
 */
function dida_halt($msg, $mode = 'html')
{
    if (IS_CLI) {
        echo $msg;
        die();
    }

    if ($mode === 'html') {
        header("Content-type:text/html;charset=utf-8");
        $tpl = '<!doctype html><html><head><meta charset="utf-8"><title></title></head><body><xmp>MESSAGE</xmp></body></html>';
        echo str_replace('MESSAGE', $msg, $tpl);
        die();
    }

    echo $msg;
    die();
}
