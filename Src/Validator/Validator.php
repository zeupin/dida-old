<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Validator;

/**
 * Validator 基类
 */
abstract class Validator
{
    protected $data;         // 待验证的数据
    protected $errors = [];  // 显示验证的错误信息


    /**
     * 设置待验证的数据
     */
    abstract public function setData($data);


    /**
     * 对待数据进行验证
     *
     * @return bool 验证成功返回true，失败返回false
     */
    abstract public function validate();


    /**
     * 验证失败时，获取错误信息
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
