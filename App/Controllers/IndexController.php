<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace App\Controllers;

/**
 * Default Controller
 */
class DefaultController extends \Dida\Controller
{
    protected $actions = ['index'];


    public static function actionExists($action)
    {
        $actions = ['index'];
        return (in_array($actions, $this->actions));
    }


    public function indexAction()
    {
    }
}
