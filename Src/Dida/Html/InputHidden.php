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
    protected $tag = 'input';
    protected $emptyContent = true;


    public function __construct()
    {
        $this->setAttr(['type' => 'hidden']);
    }
}
