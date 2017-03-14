<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Html;

/**
 * Html Element 抽象类
 */
abstract class Element
{
    /* 必填 */
    private $tag;                     // tag
    private $emptyContent = false;    // 是否是无内容元素，如<img/>,<br/>,<hr/>等

    /* 内部数据 */
    protected $attributes = [];         // 属性数组
    protected $styles = [];             // in-line样式
    protected $children = [];           // 子元素数组

    /* 标准的无值属性列表 */
    protected $noValueAttrList = ['checked', 'disabled', 'readonly', 'selected'];


    /**
     * 如果调用了未定义方法
     */
    public function __call($name, $arguments)
    {
        // 获取参数个数
        $cnt = count($arguments);

        if ($cnt === 0) {
            /* 没有参数，表明是要Get */

            // 第一看看有没有xxxGet()函数
            $targetMethod = $name . 'Get';
            if (method_exists($this, $targetMethod)) {
                return call_user_func([$this, $targetMethod]);
            }

            // 第二看属性是否存在
            if ($this->attrHas($name)) {
                return $this->attrGet($name);
            }

            // 第三看是不是children
            if ($name === 'children') {
                return $this->children;
            }

            // 第四看是不是attributes
            if ($name === 'attributes') {
                return $this->attributes;
            }

            // 第五看是不是style
            if ($name === 'style') {
                return $this->styles;
            }
        } else {
            /* 有参数，表明是要Set */
            $targetMethod = $name . 'Set';
            if (method_exists($this, $targetMethod)) {
                return call_user_func_array([$this, $targetMethod], $arguments);
            }
        }
    }


    /**
     * 生成元素的html
     */
    public function html()
    {
        if ($this->emptyContent) {
            return sprintf('<%s%s%s/>', $this->tag, $this->attributesCombine(), $this->stylesCombine());
        } else {
            return sprintf('<%s%s%s>%s</%s>', $this->tag, $this->attributesCombine(), $this->stylesCombine(), $this->childrenCombine(), $this->tag);
        }
    }


    public function attr($attrName, $attrValue = DIDA_NOT_SET)
    {
        if ($attrValue === DIDA_NOT_SET) {
            // 取值
            return ($this->attrHas($attrName)) ? $this->attributes[$attrName] : null;
        } else {
            // 检查属性名合法性
            if (!is_string($attrName) || ($attrName === '')) {
                return $this;
            }

            // 为null时，删除此属性
            if ($attrValue === null) {
                $this->attrRemove($attrName);
                return $this;
            }

            // 赋值
            $this->attrSet([$attrName => $attrValue]);
            return $this;
        }
    }


    public function attrHas($attrName)
    {
        return array_key_exists($attrName, $this->attributes);
    }


    public function attrGet($attrName)
    {
        return ($this->attrHas($attrName)) ? $this->attributes[$attrName] : null;
    }


    public function attrSet(array $attrs)
    {
        foreach ($attrs as $attrName => $attrValue) {
            $attrName = trim($attrName);
            if (is_string($attrName) && ($attrName !== '')) {
                $this->attributes[$attrName] = $attrValue;
            }
        }
        return $this;
    }


    public function attrRemove($attrName)
    {
        unset($this->attributes[$attrName]);
        return $this;
    }


    public function attributesCombine()
    {
        if (count($this->attributes) === 0) {
            return '';
        }

        // 逐一处理所有属性
        $result = [];
        foreach ($this->attributes as $name => $value) {
            $name = $this->stdAttrName($name);
            if (in_array($name, $this->noValueAttrList)) {
                if (!empty($value)) {
                    $result[] = sprintf(' %s', $name);
                }
            } else {
                $result[] = sprintf(' %s="%s"', $name, $value);
            }
        }

        return implode('', $result);
    }


    /**
     * 对属性名进行标准化
     *
     * 一般的属性名转为全小写
     * 不处理'data-'开头的属性名
     */
    private function stdAttrName($attrName)
    {
        if (strncasecmp($attrName, 'data-', 5) === 0) {
            return $attrName;
        }

        return strtolower($attrName);
    }


    public function styleSet($styles)
    {
        if (is_string($styles)) {
            $this->styleSetString($styles);
            return $this;
        }

        if (is_array($styles)) {
            $this->styleSetArray($styles);
            return $this;
        }

        return $this;
    }


    private function styleSetArray(array $styles)
    {
        foreach ($styles as $styleName => $styleValue) {
            $styleName = trim($styleName);
            $styleValue = trim($styleValue);
            $this->styles[$styleName] = $styleValue;
        }
    }


    private function styleSetString($styles)
    {
        $styles = explode(';', $styles);
        foreach ($styles as $style) {
            $arr = explode(':', $style, 2);
            if (isset($arr[1])) {
                list($styleName, $styleValue) = $arr;
                $styleName = trim($styleName);
                $styleValue = trim($styleValue);
                $this->styles[$styleName] = $styleValue;
            }
        }
    }


    public function styleRemove($styleName)
    {
        unset($this->styles[$styleName]);
        return $this;
    }


    public function styleRemoveAll()
    {
        $this->styles = [];
        return $this;
    }


    public function stylesCombine()
    {
        if (empty($this->styles)) {
            return '';
        }

        $result = [];
        foreach ($this->styles as $styleName => $styleValue) {
            $result[] = "$styleName:$styleValue;";
        }
        return sprintf(' style="%s"', implode(' ', $result));
    }


    public function childAdd(Element $child, $name = DIDA_NOT_SET)
    {
        if ($name === DIDA_NOT_SET) {
            $this->children[] = $child;
            return $this;
        } elseif (is_string($name)) {
            $this->children[$name] = $child;
            return $this;
        } else {
            return $this;
        }
    }


    public function childrenCombine()
    {
        $result = [];
        foreach ($this->children as $item) {
            $result[] = $item->html();
        }
        return implode('', $result);
    }
}
