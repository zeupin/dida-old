<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/* 开始计时 */
define('DIDA_START_TIME', microtime(true));

/* 导入全局常量 */
require __DIR__ . '/Constants.php';

/* 加载autoload机制 */
require __DIR__ . '/Autoload.php';

/* 导入全局函数库 */
require DIDA_ROOT . 'Functions/Global.php';

/* 生成app实例 */
$app = new Application();

/* 载入App相关函数库 */
require DIDA_ROOT . 'Functions/App.php';

/* 启动Staticall机制 */
Staticall::init();
Staticall::bind('App', $app);
Staticall::bind('Response', $app->response);

/* 开始运行 */
$app->start();
