<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
/* 必填的常量 */
define('DIDA_ROOT',           __DIR__ . '/../src/');
define('DIDA_COMPOSER_ROOT',  __DIR__ . '/../vendor/');
define('DIDA_APP_ROOT',       __DIR__ . '/../App/');
define('DIDA_VAR_ROOT',       __DIR__ . '/../Var/');
define('DIDA_WEB_ROOT',       __DIR__ . '/');
define('DIDA_ENV',            'dev');

/* 选填的常量 */
define('DIDA_WWW', '/');
define('DIDA_DEBUG', true);
define('DIDA_APP_NAMESPACE', 'Dida\\Builder');
define('DIDA_DEFAULT_CONTROLLER', 'Index');
define('DIDA_DEFAULT_ACTION', 'index');

/* 开始 */
require(DIDA_ROOT . 'Index.php');
