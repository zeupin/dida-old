<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Html;

/**
 * Free Text 基类
 */
class FreeText extends Element
{
    /* 必填属性 */
    protected $tag = 'FREETEXT';
    protected $emptyContent = true;

    /* 元素属性 */
    protected $text = '';


    public function __construct($text = DIDA_NOT_SET)
    {
        if ($text === DIDA_NOT_SET) {
            return;
        }
        if (!is_string($text)) {
            return;
        }
        $this->text = $text;
    }


    public function set($text)
    {
        $this->text = $text;
    }


    public function html()
    {
        return nl2br(htmlspecialchars($this->text));
    }
}
