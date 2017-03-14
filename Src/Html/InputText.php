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
    protected $tag = 'input';
    protected $emptyContent = true;

    /* 元素属性 */
    public $name;           // 表单字段名
    public $value;          // 默认值
    public $caption;        // 标题
    public $tooltip;        // 提示


    public function __construct()
    {
        $this->setAttr(['type' => 'text']);
    }


    public function set($name, $value, $caption = '', $tooltip = '')
    {
        $this->name = $name;
        $this->setAttr(['name' => $name]);

        $this->valueSet($value);

        $this->caption = $caption;

        $this->tooltip = $tooltip;

        return $this;
    }


    private function valueSet($value)
    {
        if ($value === null) {
            $this->value = null;
            $this->attrRemove('value');
            return $this;
        }

        $this->value = $value;
        $this->setAttr(['value' => $value]);
        return $this;
    }
}
