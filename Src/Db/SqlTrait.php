<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http:dida.zeupin.com
 */

namespace Dida;

trait SqlTrait
{


    /**
     * 创建一张表
     */
    public function createTabel($table, array $fields)
    {
    }


    /**
     * 删除一张表
     */
    public function dropTable($table)
    {
    }


    /**
     * 重命名一张表
     */
    public function renameTable($old, $new)
    {
    }


    /**
     * 删除一张表中的所有行
     */
    public function truncateTable($table)
    {
    }


    /**
     * 增加一列
     */
    public function addColumn($field)
    {
    }


    /**
     * 删除一列
     */
    public function dropColumn($field)
    {
    }


    /**
     * 重命名一列
     */
    public function renameColumn($old, $new)
    {
    }


    /**
     * 修改一列
     */
    public function alterColumn($field, array $settings)
    {
    }


    /**
     * 增加主键
     */
    public function addPrimaryKey($key)
    {
    }


    /**
     * 删除主键
     */
    public function dropPrimaryKey($key)
    {
    }


    /**
     * 增加一个外键
     */
    public function addForeignKey($key)
    {
    }


    /**
     * 删除一个外键
     */
    public function dropForeignKey($key)
    {
    }


    /**
     * 增加一个索引
     */
    public function addIndex($index)
    {
    }


    /**
     * 删除一个索引
     */
    public function dropIndex($index)
    {
    }
}
