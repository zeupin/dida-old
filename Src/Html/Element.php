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
    protected $tag;                     // tag
    protected $emptyContent = false;    // 是否是无内容元素，如<img/>,<br/>,<hr/>等

    /* 内部数据 */
    protected $classes = [];            // class列表
    protected $attributes = [];         // 属性数组
    protected $styles = [];             // in-line样式
    protected $children = [];           // 子元素数组

    /* 标准的无值属性列表 */
    const NoValueAttrList = ['checked', 'disabled', 'readonly', 'selected'];

    protected $userNoValueAttrList = [];    // 用户自定义的无值属性列表


    public function __construct($attrs = [])
    {
        foreach ($attrs as $attrName => $attrValue) {
            $this->attrSet($attrName, $attrValue);
        }
    }


    /**
     * 生成元素的html
     */
    public function html()
    {
        if ($this->emptyContent) {
            return sprintf('<%s%s%s%s/>', $this->tag, $this->classesCombine(), $this->attributesCombine(), $this->stylesCombine());
        } else {
            return sprintf('<%s%s%s%s>%s</%s>', $this->tag, $this->classesCombine(), $this->attributesCombine(), $this->stylesCombine(), $this->childrenCombine(), $this->tag);
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

        // 先把属性数组按照键值排序
        ksort($this->attributes);

        // 逐一处理所有属性
        $result = [];
        foreach ($this->attributes as $name => $value) {
            $name = $this->stdAttrName($name);
            if (in_array($name, self::NoValueAttrList) || in_array($name, $this->userNoValueAttrList)) {
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
        ksort($this->styles);
        foreach ($this->styles as $styleName => $styleValue) {
            $result[] = "$styleName:$styleValue;";
        }
        return sprintf(' style="%s"', implode(' ', $result));
    }


    public function classSet($classes)
    {
        if (is_string($classes)) {
            $this->classSetString($classes);
            return $this;
        }

        if (is_array($className)) {
            $this->classSetArray($classes);
            return $this;
        }

        return $this;
    }


    private function classSetString($classes)
    {
        $classes = trim($classes);
        $classes = explode(' ', $classes);

        foreach ($classes as $class) {
            if (is_string($class) && $class !== '') {
                $this->classes[$class] = true;
            }
        }
    }


    private function classSetArray(array $classes)
    {
        foreach ($classes as $class) {
            if (is_string($class) && $class !== '') {
                $this->classes[$class] = true;
            }
        }
    }


    public function classRemove($className)
    {
        if (is_string($className)) {
            unset($this->classes[$className]);
            return $this;
        }

        if (is_array($className)) {
            foreach ($className as $n) {
                if (is_string($n)) {
                    unset($this->classes[$n]);
                }
            }
            return $this;
        }

        return $this;
    }


    public function classRemoveAll()
    {
        $this->classes = [];
        return $this;
    }


    public function classesCombine()
    {
        $classes = array_keys($this->classes);
        $classes = sort($classes);
        if (empty($classes)) {
            return '';
        } else {
            return sprintf(' class="%s"', implode(' ', $classes));
        }
    }


    public function childAdd(Element $child, $name = null)
    {
        if (is_null($name)) {
            $this->children[] = $child;
            return $this;
        } elseif (!is_string($name)) {
            $this->children[] = $child;
            return $this;
        } elseif ($name === '') {
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
