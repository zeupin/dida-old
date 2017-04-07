<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Builder\Controllers;

use \Dida\MVC\Controller;

/**
 * IndexController
 */
class IndexController extends Controller
{
    public function indexAction()
    {
        //echo '当前Action是：' . __METHOD__;
        echo app()->twig->render('Index/index.html.twig');
    }
}
