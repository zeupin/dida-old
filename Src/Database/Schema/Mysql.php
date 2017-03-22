<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Src\Database\Schema;

/**
 * Mysql
 */
class Mysql extends Schema
{
    public function __construct(\Dida\Database\Driver\Mysql $driver, $prefix='')
    {
        $this->driver = $driver;
        $this->prefix = $prefix;
    }


    public function getTableNames()
    {
    }


    public function getTables()
    {
    }


    public function getColumnNames($table)
    {
    }


    public function getColumns($table)
    {
    }
}
