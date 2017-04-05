<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
/* 是否开启调试模式 */
defined('DIDA_DEBUG') || define('DIDA_DEBUG', true); // 默认开启调试模式

/* APP的名称空间 */
defined('DIDA_APP_NAMESPACE') || define('DIDA_APP_NAMESPACE', 'App'); // 默认值为App

/* 是否是CLI模式 */
define('DIDA_IS_CLI', PHP_SAPI === 'cli');

/* 指示这是未设置的函数参数 */
define('DIDA_NOT_SET', "\0");

/* 默认的Controller和Action */
defined('DIDA_DEFAULT_CONTROLLER') || define('DIDA_DEFAULT_CONTROLLER', 'Index'); // DefaultController默认值为Index
defined('DIDA_DEFAULT_ACTION') || define('DIDA_DEFAULT_ACTION', 'index'); // DefaultAction默认值为index

/* 如果不是CLI模式，则为HTTP模式 */
if (!DIDA_IS_CLI) {
    /* 如果没有定义 DIDA_WWW，则默认其为当前脚本所在目录 */
    if (!defined('DIDA_WWW')) {
        $dida_www = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        define('DIDA_WWW', ($dida_www === '/') ? '/' : $dida_www . '/');
        unset($dida_www);
    }
}
