<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
/* Loader就位 */
require DIDA_ROOT . 'Loader/Loader.php';
$dida_loader = new \Dida\Loader;
$dida_loader->regNamespace('Dida', __DIR__);

/* Composer的autoload机制就位 */
if (file_exists(COMPOSER_ROOT . 'autoload.php')) {
    require COMPOSER_ROOT . 'autoload.php';
}
