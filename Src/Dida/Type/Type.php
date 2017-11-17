<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Type;

/**
 * Type 抽象类
 */
abstract class Type
{
    /**
     * 验证$data的有效性
     */
    abstract public function validate($data);
}
