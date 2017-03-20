<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
header("Content-type: text/html; charset=utf-8");
$app = app();
app()->get('router')->route($app['request']);
