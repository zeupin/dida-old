<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Database\Driver;

/**
 * 数据库Driver抽象类
 */
abstract class Driver
{
    /* PDO配置 */
    protected $_dsn = null;
    protected $_options = [];
    protected $_user = null;
    protected $_password = null;
    protected $_dbname = null;
    protected $_charset = null;

    /* PDO实例 */
    protected $pdo = null;


    /**
     * 连接数据库
     */
    public function connect()
    {
        if (!$this->isConnected()) {
            try {
                $this->pdo = new \PDO($this->_dsn, $this->_user, $this->_password, $this->_options);
            } catch (PDOException $e) {
                throw new \Dida\DatabaseConnectionException();
            }
        }
    }


    /**
     * 检查是否已连接
     */
    public function isConnected()
    {
        // 如果连接尚未建立，返回false
        if ($this->pdo === null) {
            return false;
        }

        // 如果连接已经建立，测试能否执行SQL
        try {
            $result = $this->pdo->query('SELECT 1');
            if ($result === false) {
                // 如果执行sql失败，则断掉这个连接
                $this->pdo = null;
                return false;
            } else {
                return true;
            }
        } catch (\PDOException $e) {
            return false;
        }
    }


    /**
     * 中断数据库连接
     */
    public function disconnect()
    {
        $this->pdo = null;
    }


    /**
     * 处理未定义的方法
     *
     * 1. 检查是否是PDO的方法. 如果是, 调用PDO对应的方法
     */
    public function __call($name, $arguments)
    {
        switch ($name) {
            /* 调用PDO, 无参数 */
            case 'beginTransaction':
            case 'commit':
            case 'rollBack':
            case 'inTransaction':
            case 'errorCode':
            case 'errorInfo':
                return call_user_func([$this->pdo, $name]);

            /* 调用PDO, 有参数 */
            case 'query':
            case 'exec':
            case 'lastInsertId':
            case 'prepare':
            case 'quote':
            case 'setAttribute':
            case 'getAttribute':
                return call_user_func_array([$this->pdo, $name], $arguments);

            /* 调用PDO, 静态方法 */
            case 'getAvailableDrivers':
                return call_user_func_array(['PDO', $name], $arguments);

            /* 未找到 */
            default:
                throw new \Dida\MethodNotFoundException();
        }
    }
}
