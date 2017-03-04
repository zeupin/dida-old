<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
define('DIDA_ROOT', realpath(__DIR__ . '/../src') . '/');
define('COMPOSER_ROOT', realpath(__DIR__ . '/../vendor') . '/');
define('APP_ROOT', realpath(__DIR__ . '/../App') . '/');
define('VAR_ROOT', realpath(__DIR__ . '/../Var') . '/');
define('APP_ENVIRON', 'dev');

require(DIDA_ROOT . 'index.php');
