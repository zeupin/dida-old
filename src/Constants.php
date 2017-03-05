<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
define('IS_CLI', PHP_SAPI === 'cli');

if (!IS_CLI) {
    if (isset($_POST['_method'])) {
        define('REQUEST_METHOD', strtoupper($_POST['_method']));
    } elseif (isset($_SERVER['REQUEST_METHOD'])) {
        define('REQUEST_METHOD', strtoupper($_SERVER['REQUEST_METHOD']));
    } else {
        define('REQUEST_METHOD', '');
    }

    define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
}
