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
    protected $tag;                        // tag
    protected $emptyContent = false;       // 是否是无内容元素，如<img/>,<br/>,<hr/>等

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
            /* 没有参数，先猜测一下是不是想要Get */

            // 第一看看有没有xxxGet()函数
            $targetMethod = $name . 'Get';
            if (method_exists($this, $targetMethod)) {
                return call_user_func([$this, $targetMethod]);
            }

            // 第二看属性是否存在
            if ($this->hasAttr($name)) {
                return $this->getAttr($name);
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
            /* 有参数，看看是否有匹配的Set */
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
            return sprintf('<%s%s%s/>', $this->tag, $this->combineAttributes(), $this->combineStyles());
        } else {
            return sprintf('<%s%s%s>%s</%s>', $this->tag, $this->combineAttributes(), $this->combineStyles(), $this->combineChildren(), $this->tag);
        }
    }


    public function hasAttr($attrName)
    {
        return array_key_exists($attrName, $this->attributes);
    }


    public function getAttr($attrName)
    {
        return ($this->hasAttr($attrName)) ? $this->attributes[$attrName] : null;
    }


    public function setAttr(array $attrs)
    {
        foreach ($attrs as $attrName => $attrValue) {
            $attrName = trim($attrName);
            if (is_string($attrName) && ($attrName !== '')) {
                $this->attributes[$attrName] = $attrValue;
            }
        }
        return $this;
    }


    public function removeAttr($attrName)
    {
        unset($this->attributes[$attrName]);
        return $this;
    }


    public function removeAllAttributes()
    {
        $this->attributes = [];
        return $this;
    }


    public function combineAttributes()
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


    public function setStyles($styles)
    {
        if (is_string($styles)) {
            $this->setStylesString($styles);
            return $this;
        }

        if (is_array($styles)) {
            $this->setStylesArray($styles);
            return $this;
        }

        return $this;
    }


    private function setStylesArray(array $styles)
    {
        foreach ($styles as $styleName => $styleValue) {
            $styleName = trim($styleName);
            $styleValue = trim($styleValue);
            $this->styles[$styleName] = $styleValue;
        }
    }


    private function setStylesString($styles)
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


    public function removeStyle($styleName)
    {
        unset($this->styles[$styleName]);
        return $this;
    }


    public function removeAllStyles()
    {
        $this->styles = [];
        return $this;
    }


    public function combineStyles()
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


    public function addChild(Element $child, $name = DIDA_NOT_SET)
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


    public function addFreeText($text)
    {
        $e = new FreeText($text);
        $this->addChild($e);
        return $this;
    }


    public function addFreeHtml($html)
    {
        $e = new FreeHtml($html);
        $this->addChild($e);
        return $this;
    }


    public function combineChildren()
    {
        $result = [];
        foreach ($this->children as $item) {
            $result[] = $item->html();
        }
        return implode('', $result);
    }
}
