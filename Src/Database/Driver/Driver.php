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
    use PDOTrait;

    /* PDO配置 */
    protected $_dsn = null;             // pdo的dns
    protected $_options = [];           // pdo的driver_options
    protected $_user = null;            // 数据库用户名
    protected $_password = null;        // 数据库密码
    protected $_dbname = null;          // 数据库名
    protected $_charset = null;         // 连接字符集
    protected $_persistence = false;    // 是否是长连接
    protected $_prefix = '';            // 默认的数据表前缀

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
     * 未知属性处理
     */
    public function __get($name)
    {
        switch ($name) {
            case 'pdo':
                return $this->pdo;
            case 'dbname':
                return $this->_dbname;
            case 'prefix':
                return $this->_prefix;
        }

        // 其它未知属性抛异常
        throw new PropertyGetException(sprintf('%s的属性%s不存在', get_called_class(), $name));
    }
}
