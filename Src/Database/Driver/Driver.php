<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Database\Driver;

use PDO;

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
     * 构造函数
     */
    abstract public function __construct(array $config);


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
     * 处理未声明的方法
     *
     * 1. 检查是否是PDO的方法. 如果是, 调用PDO对应的方法.
     * 2. getAvailableDrivers()请直接用 PDO::getAvailableDrivers()
     */
    public function __call($name, $arguments)
    {
        switch ($name) {
            /* PDO方法, 按常规使用频率排序 */
            case 'query':
            case 'quote':
            case 'prepare':
            case 'lastInsertId':
            case 'exec':
            case 'errorCode':
            case 'errorInfo':
            case 'beginTransaction':
            case 'commit':
            case 'rollBack':
            case 'inTransaction':
            case 'setAttribute':
            case 'getAttribute':
                return call_user_func_array([$this->pdo, $name], $arguments);

            /* 未找到 */
            default:
                throw new \Dida\MethodNotFoundException(get_called_class() . '->' . $name . ' 不存在');
        }
    }
}
