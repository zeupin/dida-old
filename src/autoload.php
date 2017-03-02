<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
/* 初始化Dida的autoload机制 */
require DIDA_ROOT . 'Loader/Loader.php';
$loader = new \Dida\Loader;
$loader->regNamespace('Dida', __DIR__);

/* 初始化composer的autoload机制 */
if (file_exists(COMPOSER_ROOT . 'autoload.php')) {
    require COMPOSER_ROOT . 'autoload.php';
}
