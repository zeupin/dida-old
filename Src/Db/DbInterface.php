<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * 数据库通用接口
 */
interface DbInterface
{


    /**
     * 读取数据库
     */
    abstract public function read();


    /**
     * 写入数据库
     */
    abstract public function write();
}
