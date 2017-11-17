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


    /**
     * 返回所有表的表名
     */
    abstract public function getTableList();


    /**
     * 返回所有表的详细信息
     */
    abstract public function listTables();


    /**
     * 返回表的所有字段名
     */
    abstract public function listColumnNames($table);


    /**
     * 返回表的所有字段详细信息
     */
    abstract public function listColumns($table);
}
