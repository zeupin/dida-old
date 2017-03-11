<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
define('DIDA_ROOT', realpath(__DIR__ . '/../src') . '/');
define('DIDA_COMPOSER_ROOT', realpath(__DIR__ . '/../vendor') . '/');
define('DIDA_APP_ROOT', realpath(__DIR__ . '/../App') . '/');
define('DIDA_VAR_ROOT', realpath(__DIR__ . '/../Var') . '/');
define('DIDA_WEB_ROOT', __DIR__ . '/');
define('DIDA_ENVIRON', 'dev');

define('DIDA_DEBUG_MODE', true);
define('DIDA_WWW', '/');
define('DIDA_SANDBOX_ROOT', realpath(__DIR__ . '/../Sandbox') . '/');

require(DIDA_ROOT . 'Index.php');
