<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */


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
