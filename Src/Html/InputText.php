<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Html;

/**
 * InputText 基类
 */
class InputText extends Element
{
    /* 必填属性 */
    public $tag = 'input';
    public $emptyContent = true;

    /* 元素属性 */
    public $name;       // 表单字段名
    public $default;    // 默认值
    public $caption;    // 标题
    public $tooltip;    // 提示

    public function __construct()
    {
        $this->attrSet(['type' => 'text']);
    }
}
