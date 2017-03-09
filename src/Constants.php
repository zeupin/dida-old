<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
/* 是否开启调试模式 */
defined('DIDA_DEBUG_MODE') || define('DIDA_DEBUG_MODE', true); // 默认开启所有错误提示
if (DIDA_DEBUG_MODE) {
    // 报告所有 PHP 错误，参见 PHP 的 error_reporting() 文档
    error_reporting(E_ALL);
} else {
    // 关闭所有 PHP 错误报告
    error_reporting(0);
}


/* 沙箱目录的文件路径 */
defined('SANDBOX_ROOT') || define('SANDBOX_ROOT', VAR_ROOT);


/* 是否是CLI模式 */
define('IS_CLI', PHP_SAPI === 'cli');
if (!IS_CLI) {
    /* REQUEST_METHOD，值为：GET，POST，PUT，PATCH，DELETE，OPTIONS，HEAD */
    if (isset($_POST['_method'])) {
        define('REQUEST_METHOD', strtoupper($_POST['_method']));
    } elseif (isset($_SERVER['REQUEST_METHOD'])) {
        define('REQUEST_METHOD', strtoupper($_SERVER['REQUEST_METHOD']));
    } else {
        define('REQUEST_METHOD', '');
    }

    /* WEB_BASE */
    defined('WEB_BASE') || define('WEB_BASE', str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])));

    /* IS_AJAX */
    define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
}
