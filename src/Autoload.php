<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
/* Loader就位 */
require DIDA_ROOT . 'Loader/Loader.php';
$dida_loader = new \Dida\Loader;

/* 登记Dida类的对应表文件，加快查找速度 */
$dida_loader->regClassMap(DIDA_ROOT . 'ClassMap.php');

/* 登记Dida命名空间 */
$dida_loader->regNamespace('Dida', DIDA_ROOT);

/* 登记App命名空间 */
$dida_loader->regNamespace('App', APP_ROOT);

/* Composer的autoload机制就位 */
if (file_exists(COMPOSER_ROOT . 'autoload.php')) {
    require COMPOSER_ROOT . 'autoload.php';
}
