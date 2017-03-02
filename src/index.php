<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
require __DIR__ . '/autoload.php';

/* Config就位 */
$conf = new Dida\Config();

/* Container就位 */

require DIDA_ROOT . 'Application/Application.php';
$app = new Dida\Application();
