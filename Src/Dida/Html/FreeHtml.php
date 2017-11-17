<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Html;

/**
 * Free Text 基类
 */
class FreeHtml extends Element
{
    /* 必填属性 */
    protected $tag = 'FREEHTML';
    protected $emptyContent = true;

    /* 元素属性 */
    protected $html = '';


    public function __construct($html = DIDA_NOT_SET)
    {
        if ($html === DIDA_NOT_SET) {
            return;
        }
        if (!is_string($html)) {
            return;
        }
        $this->html = $html;
    }


    public function set($html)
    {
        $this->html = $html;
    }


    public function html()
    {
        return $this->html;
    }
}
