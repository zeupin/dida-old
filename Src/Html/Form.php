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

    /* 元素属性 */
    public $action;
    public $method;


    public function set($action, $method = 'POST')
    {
        $this->actionSet($action)
            ->methodSet($method);
    }


    public function actionSet($value)
    {
        $this->action = $value;
        $this->attrSet(['action' => $value]);
        return $this;
    }


    public function methodSet($value)
    {
        if (!is_string($value)) {
            // 无效值
            return $this;
        }

        $value = strtoupper($value);
        switch ($value) {
            case 'POST':
            case 'GET':
                $this->method = $value;
                $this->attrSet(['method' => $value]);
                return $this;
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
            case 'HEAD':
            case 'OPTIONS':
                $this->method = $value;
                $this->attrSet(['method' => 'POST']);
                $hidden = new InputHidden();
                $hidden->attrSet(['name' => '_method', 'value' => $value]);
                $this->childAdd($hidden, '_method');
                return $this;
            default:
                // 无效值
                return $this;
        }
    }
}
