<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Html;

/**
 * Form 基类
 */
class Form extends Element
{
    /* 必填属性 */
    public $tag = 'form';
    public $emptyContent = false;


    public function action($value)
    {
        $this->attrSet(['action' => $value]);
        return $this;
    }


    public function method($value)
    {
        if (!is_string($value)) {
            return $this;
        }

        $value = strtoupper($value);
        switch ($value) {
            case 'POST':
            case 'GET':
                $this->attrSet(['method' => $value]);
                return $this;
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
            case 'HEAD':
            case 'OPTIONS':
                $this->attrSet(['method' => 'POST']);
                $hidden = new InputHidden();
                $hidden->attrSet(['name' => '_method', 'value' => $value]);
                $this->childAdd($hidden, '_method');
                return $this;
            default:
                return $this;
        }
    }


    public function encrypt($value)
    {
        $this->attrSet(['encrypt' => $value]);
        return $this;
    }
}
