<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
/* 开始计时 */
define('DIDA_START_TIME', microtime(true));

/* 检测运行环境 */
define('IS_CLI', PHP_SAPI === 'cli');

/* 导入通用函数库 */
require DIDA_ROOT . 'Functions/Dida.php';

/* 加载autoload机制 */
require __DIR__ . '/autoload.php';

/* 生成app实例 */
$app = new Dida\Application();

/* 开始运行 */
$app->start();
