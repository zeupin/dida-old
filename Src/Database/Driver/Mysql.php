<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Database\Driver;

use \Dida\Database\Exception\DatabaseConnectionException;

/**
 * MySQL/MariaDB 驱动
 */
class Mysql extends Driver
{
    public function __construct(array $config)
    {
        if (isset($config['socket'])) {
            $this->socket($config);
        } else {
            $this->hostport($config);
        }
    }


    /**
     * host-port模式
     *
     * 必填:
     *     user, password, dbname
     * 选填:
     *     host        默认 localhost
     *     port        默认 3306
     *     charset     默认 utf8
     *     persistence 默认 false
     *     prefix      默认 ''
     */
    private function hostport($config)
    {
        /* 必填参数 */
        if (!isset($config['user']) ||
            !isset($config['password']) ||
            !isset($config['dbname'])) {
            throw new DatabaseConnectionException;
        }
        $user = $config['user'];
        $password = $config['password'];
        $dbname = $config['dbname'];

        /* 选填参数 */
        $host = isset($config['host']) ? $config['host'] : 'localhost';
        $port = isset($config['port']) ? $config['port'] : 3306;
        $charset = isset($config['charset']) ? $config['charset'] : 'utf8';
        $persistence = isset($config['persistence']) ? (bool) $config['persistence'] : false;
        $prefix = isset($config['prefix']) ? $config['prefix'] : '';

        /* 设置 */
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset;";
        $options[\PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES ' . $charset;
        if ($persistence) {
            $options[\PDO::ATTR_PERSISTENT] = $persistence;
        }

        /* 保存 */
        $this->_dsn = $dsn;
        $this->_options = $options;
        $this->_user = $user;
        $this->_password = $password;
        $this->_dbname = $dbname;
        $this->_charset = $charset;
        $this->_persistence = $persistence;
        $this->_prefix = $prefix;
    }


    /**
     * socket模式
     *
     * 必填:
     *     socket, user, password, dbname
     * 选填:
     *     charset     默认 utf8
     *     persistence 默认 false
     *     prefix      默认 ''
     */
    private function socket(array $config)
    {
        /* 必填参数 */
        if (!isset($config['socket']) ||
            !isset($config['user']) ||
            !isset($config['password']) ||
            !isset($config['dbname'])) {
            throw new DatabaseConnectionException;
            return false;
        }
        $socket = $config['socket'];
        $user = $config['user'];
        $password = $config['password'];
        $dbname = $config['dbname'];

        /* 选填参数 */
        $charset = isset($config['charset']) ? $config['charset'] : 'utf8';
        $persistence = isset($config['persistence']) ? (bool) $config['persistence'] : false;
        $prefix = isset($config['prefix']) ? $config['prefix'] : '';

        /* 设置 */
        $dsn = "mysql:unix_socket=$socket;dbname=$dbname;charset=$charset;";
        $options[\PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES ' . $charset;
        if ($persistence) {
            $options[\PDO::ATTR_PERSISTENT] = $persistence;
        }

        /* 保存 */
        $this->_dsn = $dsn;
        $this->_options = $options;
        $this->_user = $user;
        $this->_password = $password;
        $this->_dbname = $dbname;
        $this->_charset = $charset;
        $this->_persistence = $persistence;
        $this->_prefix = $prefix;
    }
}
