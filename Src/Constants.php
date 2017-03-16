<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
/* 是否开启调试模式 */
defined('DIDA_DEBUG_MODE') || define('DIDA_DEBUG_MODE', true); // 默认开启调试模式

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
    /* DIDA_WWW */
    defined('DIDA_WWW') || define('DIDA_WWW', str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])));

    /* IS_AJAX */
    define('DIDA_IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

    /* REQUEST_METHOD，值为：GET，POST，PUT，PATCH，DELETE，OPTIONS，HEAD */
    if (isset($_POST['_method'])) {
        define('DIDA_REQUEST_METHOD', strtoupper($_POST['_method']));
    } elseif (isset($_SERVER['REQUEST_METHOD'])) {
        define('DIDA_REQUEST_METHOD', strtoupper($_SERVER['REQUEST_METHOD']));
    } else {
        define('DIDA_REQUEST_METHOD', '');
    }
}
