<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
 
/* 必填的常量 */
$DIDA_ROOT =           __DIR__ . '/../src/';
$DIDA_COMPOSER_ROOT =  __DIR__ . '/../vendor/';
$DIDA_APP_ROOT =       __DIR__ . '/../App/';
$DIDA_VAR_ROOT =       __DIR__ . '/../Var/';
$DIDA_WEB_ROOT =       __DIR__ . '/';
$DIDA_ENV =            'dev';

/* 选填的常量 */
$DIDA_WWW = '/';
$DIDA_DEBUG = true;
$DIDA_APP_NAMESPACE = 'Dida\\Builder';
$DIDA_DEFAULT_CONTROLLER = 'Index';
$DIDA_DEFAULT_ACTION = 'index';

/* 开始 */
require($DIDA_ROOT . 'Index.php');
