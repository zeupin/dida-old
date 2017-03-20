<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
/* 必填的常量 */
define('DIDA_ROOT', realpath(__DIR__ . '/../src') . '/');
define('DIDA_COMPOSER_ROOT', realpath(__DIR__ . '/../composer') . '/');
define('DIDA_APP_ROOT', realpath(__DIR__ . '/../Builder') . '/');
define('DIDA_VAR_ROOT', realpath(__DIR__ . '/../Var') . '/');
define('DIDA_WEB_ROOT', __DIR__ . '/');
define('DIDA_ENVIRON', 'dev');

/* 选填的常量 */
define('DIDA_WWW', '/');
define('DIDA_DEBUG', true);
define('DIDA_APP_NAMESPACE', 'Dida\\Builder');
define('DIDA_DEFAULT_CONTROLLER', 'Index');
define('DIDA_DEFAULT_ACTION', 'index');

/* 开始 */
require(DIDA_ROOT . 'Index.php');
