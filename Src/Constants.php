<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */


/**
 * 必填的常量
 */

// 路径常量
$dida_system_constants = [
    'DIDA_ROOT',
    'DIDA_APP_ROOT',
    'DIDA_WEB_ROOT',
    'DIDA_VAR_ROOT',
];

foreach ($dida_system_constants as $const) {
    if (!isset($$const)) {
        die("The necessary configure variable ${$const} is not set.");
    } elseif (!file_exists($$const) || !is_dir($$const)) {
        die("${$const}" . $$const . ", but this directory does not exist.");
    } else {
        $$const = realpath($$const) . DIRECTORY_SEPARATOR;
    }
}

define('DIDA_ROOT', $DIDA_ROOT);
define('DIDA_APP_ROOT', $DIDA_APP_ROOT);
define('DIDA_WEB_ROOT', $DIDA_WEB_ROOT);
define('DIDA_VAR_ROOT', $DIDA_VAR_ROOT);

/**
 * 选填的常量
 */

// DIDA_WWW  --网站的根路径
define('DIDA_WWW', isset($DIDA_WWW) ? $DIDA_WWW : '/');

// DIDA_DEBUG  --是否开启调试模式
define('DIDA_DEBUG', isset($DIDA_DEBUG) ? $DIDA_DEBUG : false);

// DIDA_DEFAULT_SCRIPT_NAME  --缺省的php脚本
define('DIDA_DEFAULT_SCRIPT_NAME', isset($DIDA_DEFAULT_SCRIPT_NAME) ? $DIDA_DEFAULT_SCRIPT_NAME : 'index.php');

// DIDA_APP_NAMESPACE  --APP的名称空间
define('DIDA_APP_NAMESPACE', isset($DIDA_APP_NAMESPACE) ? $DIDA_APP_NAMESPACE : 'App');

// DIDA_DEFAULT_CONTROLLER  --默认的Controller
define('DIDA_DEFAULT_CONTROLLER', isset($DIDA_DEFAULT_CONTROLLER) ? $DIDA_DEFAULT_CONTROLLER : 'Index');

// DIDA_DEFAULT_ACTION  --默认的Action
define('DIDA_DEFAULT_ACTION', isset($DIDA_DEFAULT_ACTION) ? $DIDA_DEFAULT_ACTION : 'index');

// DIDA_ENV
define('DIDA_ENV', isset($DIDA_ENV) ? $DIDA_ENV : 'dev');

// DIDA_COMPOSER_ROOT
if (isset($DIDA_COMPOSER_ROOT)) {
    if (file_exists($DIDA_COMPOSER_ROOT) && is_dir($DIDA_COMPOSER_ROOT)) {
        define('DIDA_COMPOSER_ROOT', realpath($DIDA_COMPOSER_ROOT) . DIRECTORY_SEPARATOR);
    }
}

/**
 * 内置的常量
 */

// DIDA_IS_CLI 是否是CLI模式
define('DIDA_IS_CLI', PHP_SAPI === 'cli');

// DIDA_NOT_SET 指示这是未设置的函数参数
define('DIDA_NOT_SET', "\0");
