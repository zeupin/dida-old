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
    protected $name;
    protected $value;


    public function __construct()
    {
        $this->setAttr([
            'type' => 'text',
        ]);
    }


    public function set($name, $value)
    {
        $this->setAttr([
            'name'  => $name,
            'value' => $value,
        ]);
        return $this;
    }


    protected function nameSet($v)
    {
        $this->name = $v;
        $this->setAttr(['name' => $v]);
        return $this;
    }


    protected function nameGet()
    {
        return $this->name;
    }


    protected function valueSet($v)
    {
        $this->value = $v;
        $this->setAttr(['value' => $v]);
        return $this;
    }


    protected function valueGet()
    {
        return $this->value;
    }
}
