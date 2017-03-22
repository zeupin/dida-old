<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Database\Driver;

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
     *     host    默认 localhost
     *     port    默认 3306
     *     charset 默认 utf8
     */
    private function hostport($config)
    {
        /* 必填参数 */
        if (!isset($config['user']) ||
            !isset($config['password']) ||
            !isset($config['dbname'])) {
            throw new \Dida\DatabaseConnectionException();
        }
        $user = $config['user'];
        $password = $config['password'];
        $dbname = $config['dbname'];

        /* 选填参数 */
        $host = isset($config['host']) ? $config['host'] : 'localhost';
        $port = isset($config['port']) ? $config['port'] : 3306;
        $charset = isset($config['charset']) ? $config['charset'] : 'utf8';

        /* 设置 */
        $this->_dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s', $host, $port, $dbname, $charset);
        $this->_options = [
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $charset,
        ];
        $this->_user = $user;
        $this->_password = $password;
        $this->_dbname = $dbname;
        $this->_charset = $charset;
    }


    /**
     * socket模式
     *
     * 必填:
     *     socket, user, password, dbname
     * 选填:
     *     charset 默认 utf8
     */
    private function socket(array $config)
    {
        /* 必填参数 */
        if (!isset($config['socket']) ||
            !isset($config['user']) ||
            !isset($config['password']) ||
            !isset($config['dbname'])) {
            throw new \Dida\DatabaseConnectionException();
            return false;
        }
        $socket = $config['socket'];
        $user = $config['user'];
        $password = $config['password'];
        $dbname = $config['dbname'];

        /* 选填参数 */
        $charset = isset($config['charset']) ? $config['charset'] : 'utf8';

        /* 设置 */
        $this->_dsn = sprintf('mysql:unix_socket=%s;dbname=%s;charset=%s', $socket, $dbname, $charset);
        $this->_user = $user;
        $this->_password = $password;
        $this->_options = [
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $charset,
        ];
        $this->_dbname = $dbname;
        $this->_charset = $charset;
    }
}
