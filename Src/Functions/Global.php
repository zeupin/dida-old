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


/**
 * 检查给出的name是否是个有效的名字
 * 有效的名字是指以英文字母或下划线开头，且全词只含有英文字母，数字和下划线的单词
 * @param string $name
 */
function dida_is_valid_name($name)
{
    return preg_match('/^[A-Za-z_]{1}[A-Za-z0-9_]{0,}$/', $name) > 0;
}
