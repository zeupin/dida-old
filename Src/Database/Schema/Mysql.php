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
