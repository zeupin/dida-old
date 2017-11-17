<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\MVC;

/**
 * Model 基类
 */
class Model
{
    public $description;
    public $parts = [];
    public $nextPartId = 0;
    public $validations = [];
    public $nextValidationId = 0;
    public $errors = [];


    public function addPart($part)
    {
        $this->parts[$this->nextPartId] = $part;
        $this->nextPartId++;
    }


    public function removePart($partId)
    {
        unset($this->parts[$partId]);
    }


    public function addValidation(Validator $validator, array $data, $desc = '')
    {
        $this->validations[$this->nextValidationId] = [$validator, $data, $desc];
        $this->nextValidationId++;
    }


    public function validate()
    {
        $result = true;

        // 依次执行所有的数据验证
        foreach ($this->validations as $validation) {
            list($validator, $data, $desc) = $validation;
            if (!$validator->setData($data)->validate()) {
                $this->errors = array_merge($this->errors, $validator->getErrors());
                $result = false;
            }
        }

        return $result;
    }
}
