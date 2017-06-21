<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Exception;

use \Dida\Exception;

/**
 * FileNotFoundException 文件未找到
 */
class FileNotFoundException extends Exception
{


    public function __construct($file = "", $code = 0, \Exception $previous = null)
    {
        $message = '"' . $file . '" not found.';
        parent::__construct($message, $code, $previous);
    }
}
