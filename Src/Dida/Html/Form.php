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
    protected $tag = 'form';
    protected $emptyContent = false;

    /* 元素属性 */
    protected $action;
    protected $method;


    public function set($action, $method = 'POST')
    {
        $this->actionSet($action)
            ->methodSet($method);
        return $this;
    }


    protected function actionSet($value)
    {
        $this->action = $value;
        $this->setAttr(['action' => $value]);
        return $this;
    }


    protected function actionGet()
    {
        return $this->action;
    }


    protected function methodSet($value)
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
                $this->setAttr(['method' => $value]);
                return $this;
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
            case 'HEAD':
            case 'OPTIONS':
                $this->method = $value;
                $this->setAttr(['method' => 'POST']);
                $hidden = new InputHidden();
                $hidden->setAttr(['name' => '_method', 'value' => $value]);
                $this->addChild($hidden, '_method');
                return $this;
            default:
                // 无效值
                return $this;
        }
    }


    protected function methodGet()
    {
        return $this->method;
    }
}
