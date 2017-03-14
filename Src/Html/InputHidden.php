<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Html;

/**
 * InputHidden 基类
 */
class InputHidden extends Element
{
    /* 必填属性 */
    private $tag = 'input';
    private $emptyContent = true;


    public function __construct()
    {
        $this->attrSet(['type' => 'hidden']);
    }
}
