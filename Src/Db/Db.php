<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Db基类
 */
abstract class Db implements DbInterface
{
    public $tablePrefix = '';
    public $sql = '';


    /**
     * 读取数据库
     */
    public function read()
    {
    }


    /**
     * 写入数据库
     */
    public function write()
    {
    }


    /**
     * 把一个形式SQL语句转为真实SQL语句
     *
     * 把 ###table 替换为 prefix_table
     * todo: ##field 替换为 field
     *
     * @param string $sql
     */
    public function createCommand($sql)
    {
        $this->sql = str_replace('###', $this->tablePrefix, $sql);
        return $this;
    }
}
