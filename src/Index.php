<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
/* 开始计时 */
define('DIDA_START_TIME', microtime(true));

/* 检测运行环境 */
define('IS_CLI', PHP_SAPI === 'cli');

/* 导入全局函数库 */
require DIDA_ROOT . 'Functions/Global.php';

/* 加载autoload机制 */
require __DIR__ . '/Autoload.php';

/* 生成app实例 */
$app = new Dida\Application();

/* 载入App相关函数库 */
require DIDA_ROOT . 'Functions/App.php';

/* 开始运行 */
$app->start();
