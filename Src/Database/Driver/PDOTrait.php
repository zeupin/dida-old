<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Database\Driver;

use PDO;

/**
 * PDO Trait 实现了从Driver到PDO方法的映射
 */
trait PDOTrait
{
    /**
     * PDOStatement PDO::query ( string $statement )
     * PDOStatement PDO::query ( string $statement , int $PDO::FETCH_CLASS , string $classname , array $ctorargs )
     * PDOStatement PDO::query ( string $statement , int $PDO::FETCH_COLUMN , int $colno )
     * PDOStatement PDO::query ( string $statement , int $PDO::FETCH_INTO , object $object )
     */
    public function query($statement, $param1 = null, $param2 = null, $param3 = null)
    {
        if ($param1 === null) {
            return $this->pdo->query($statement);
        }

        if (is_array($param3)) {
            return $this->pdo->query($statement, $param1, $param2, $param3);
        }

        return $this->pdo->query($statement, $param1, $param2);
    }


    /**
     * int PDO::exec ( string $statement )
     */
    public function exec($statement)
    {
        return $this->pdo->exec($statement);
    }


    /**
     * string PDO::quote ( string $string [, int $parameter_type = PDO::PARAM_STR ] )
     */
    public function quote($string, $parameter_type = PDO::PARAM_STR)
    {
        return $this->pdo->quote($string, $parameter_type);
    }


    /**
     * PDOStatement PDO::prepare ( string $statement [, array $driver_options = array() ] )
     */
    public function prepare($statement, array $driver_options = [])
    {
        $this->pdo->prepare($statement, $driver_options);
    }


    /**
     * bool PDO::beginTransaction ( void )
     */
    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }


    /**
     * bool PDO::commit ( void )
     */
    public function commit()
    {
        return $this->pdo->commit();
    }


    /**
     * bool PDO::rollBack ( void )
     */
    public function rollBack()
    {
        return $this->pdo->rollBack();
    }


    /**
     * bool PDO::inTransaction ( void )
     */
    public function inTransaction()
    {
        return $this->pdo->inTransaction();
    }


    /**
     * mixed PDO::errorCode ( void )
     */
    public function errorCode()
    {
        return $this->pdo->errorCode();
    }


    /**
     * array PDOStatement::errorInfo ( void )
     */
    public function errorInfo()
    {
        return $this->pdo->errorInfo();
    }


    /**
     * string PDO::lastInsertId ([ string $name = NULL ] )
     */
    public function lastInsertId($name = null)
    {
        return $this->pdo->lastInsertId($name);
    }


    /**
     * bool PDO::setAttribute ( int $attribute , mixed $value )
     */
    public function setAttribute($attribute, $value)
    {
        return $this->pdo->setAttribute($attribute, $value);
    }


    /**
     * mixed PDO::getAttribute ( int $attribute )
     */
    public function getAttribute($attribute)
    {
        return $this->pdo->getAttribute($attribute);
    }
}
