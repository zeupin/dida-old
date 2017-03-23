<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Database\Schema;

use \PDO;
use \Dida\Database\Driver\Driver;

/**
 * Mysql
 */
class Mysql extends Schema
{


    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }


    /**
     * 返回所有表的表名
     * 基于information_schema
     */
    public function listTableNames()
    {
        $sql = <<<'EOT'
SELECT TABLE_NAME FROM information_schema.TABLES
WHERE
    (TABLE_SCHEMA = :dbname) AND (TABLE_NAME = :table)
ORDER BY
    TABLE_SCHEMA, TABLE_NAME
EOT;
        $stmt = $this->driver->prepare($sql);
        $stmt->execute([
            ':dbname' => $this->driver->dbname,
            ':table'  => $this->driver->prefix . '%',
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        return $result;
    }


    /**
     * 返回所有表的详细信息
     * 基于information_schema
     */
    public function listTables()
    {
        $sql = <<<'EOT'
SELECT * FROM information_schema.TABLES
WHERE
    (TABLE_SCHEMA = :dbname) AND (TABLE_NAME = :table)
ORDER BY
    TABLE_SCHEMA, TABLE_NAME
EOT;
        $stmt = $this->driver->prepare($sql);
        $stmt->execute([
            ':dbname' => $this->driver->dbname,
            ':table'  => $this->driver->prefix . '%',
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    /**
     * 返回表的所有字段名
     * 基于information_schema
     */
    public function listColumnNames($table)
    {
        $sql = <<<'EOT'
SELECT COLUMN_NAME FROM information_schema.COLUMNS
WHERE
    TABLE_SCHEMA = :dbname  AND TABLE_NAME = :table
EOT;
        $stmt = $this->driver->prepare($sql);
        $stmt->execute([
            ':dbname' => $this->driver->dbname,
            ':table'  => $table,
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        return $result;
    }


    /**
     * 返回表的所有字段详细信息
     * 基于information_schema
     */
    public function listColumns($table)
    {
        $sql = <<<'EOT'
SELECT * FROM information_schema.COLUMNS
WHERE
    TABLE_SCHEMA = :dbname  AND TABLE_NAME = :table
EOT;
        $stmt = $this->driver->prepare($sql);
        $stmt->execute([
            ':dbname' => $this->driver->dbname,
            ':table'  => $table,
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
