<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Database\Driver;

/**
 * MySQL/MariaDB的Socket模式驱动
 */
class MysqlSocket extends Driver
{
    /**
     * 必填:
     *     socket, user, password, dbname
     * 选填:
     *     charset 默认 utf8
     */
    public function __construct(array $config)
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
