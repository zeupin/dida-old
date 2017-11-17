<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Validator;

/**
 * Required 必填数据
 */
class Required extends Validator
{
    public function validate()
    {
        if (($this->data === null)) {
            $this->errors[] = '数据不可为null';
            return false;
        }

        if ($this->data === '') {
            $this->errors[] = '数据不可为空字符串';
            return false;
        }

        return true;
    }
}
