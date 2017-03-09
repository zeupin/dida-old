<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
define('DIDA_ROOT', realpath(__DIR__ . '/../src') . '/');
define('COMPOSER_ROOT', realpath(__DIR__ . '/../vendor') . '/');
define('APP_ROOT', realpath(__DIR__ . '/../App') . '/');
define('VAR_ROOT', realpath(__DIR__ . '/../Var') . '/');
define('WEB_ROOT', __DIR__ . '/');
define('APP_ENVIRON', 'dev');

define('DIDA_DEBUG_MODE', true);
define('WEB_BASE', '/');
define('SANDBOX_ROOT', realpath(__DIR__ . '/../Sandbox') . '/');

require(DIDA_ROOT . 'Index.php');
