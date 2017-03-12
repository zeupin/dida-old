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

/* 加载Dida的autoload机制 */
require DIDA_ROOT . 'Loader/Loader.php';
Loader::init();
Loader::addClassmap(DIDA_ROOT . 'Classmap.php', DIDA_ROOT);    // 注册所有Dida类文件的位置对照表
Loader::addNamespace('Dida', DIDA_ROOT);                       // 登记Dida命名空间
Loader::addNamespace(DIDA_APP_NAMESPACE, DIDA_APP_ROOT);       // 登记App命名空间

/* 加载Composer的autoload机制，以获取海量第三方软件包的支持 */
if (file_exists(DIDA_COMPOSER_ROOT . 'autoload.php')) {
    require DIDA_COMPOSER_ROOT . 'autoload.php';
}

/* 生成app实例 */
$app = new Application();

/* 开始运行 */
$app->start();
