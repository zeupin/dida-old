<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
/* Loader就位 */
require DIDA_ROOT . 'Loader/Loader.php';
$dida_loader = new \Dida\Loader;

/* 登记Dida命名空间 */
$dida_loader->regNamespace('Dida', __DIR__);

/* 登记App命名空间*/
$dida_loader->regNamespace('App', APP_ROOT);

/* Composer的autoload机制就位 */
if (file_exists(COMPOSER_ROOT . 'autoload.php')) {
    require COMPOSER_ROOT . 'autoload.php';
}
