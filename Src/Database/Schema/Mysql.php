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


    public function getTableNames()
    {
        $sql = <<<EOT
SELECT TABLE_NAME FROM information_schema.TABLES
WHERE
    (TABLE_SCHEMA LIKE '{$this->driver->dbname}') AND (TABLE_NAME LIKE '{$this->driver->prefix}%')
ORDER BY TABLE_NAME
EOT;
        $stmt = $this->driver->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        return $result;
    }


    public function getTables()
    {
        $sql = <<<'EOT'
SELECT * FROM information_schema.TABLES
WHERE
    (TABLE_SCHEMA LIKE :dbname) AND (TABLE_NAME LIKE :table)
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


    public function getColumnNames($table)
    {
    }


    public function getColumns($table)
    {
    }
}
