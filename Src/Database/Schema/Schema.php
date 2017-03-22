<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Database\Schema;

use \Dida\Database\Driver\Driver;

/**
 * Schema
 */
abstract class Schema
{
    // 数据库驱动
    protected $driver = null;

    // 表前缀, 默认为空
    public $prefix = '';


    /**
     * 初始化
     */
    abstract public function __construct(Driver $driver);


    /**
     * 返回所有表的表名
     */
    abstract public function getTableNames();


    /**
     * 返回所有表的详细信息
     */
    abstract public function getTables();


    /**
     * 返回表的所有字段名
     */
    abstract public function getColumnNames($table);


    /**
     * 返回表的所有字段详细信息
     */
    abstract public function getColumns($table);
}
