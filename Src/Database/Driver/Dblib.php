<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Database\Driver;

/**
 * MS SQL Server驱动 (Linux环境)
 */
class Dblib extends Driver
{
    public function __construct(array $config)
    {
        /* 必填参数 */
        if (!isset($config['host']) ||
            !isset($config['port']) ||
            !isset($config['user']) ||
            !isset($config['password']) ||
            !isset($config['dbname'])) {
            throw new \Dida\DatabaseConnectionException();
            return false;
        }
        $host = $config['host'];
        $port = $config['port'];
        $user = $config['user'];
        $password = $config['password'];
        $dbname = $config['dbname'];

        /* 选填参数 */
        $charset = isset($config['charset']) ? $config['charset'] : 'utf8';

        /* 设置 */
        $this->_dsn = sprintf('dblib:host=%s:%s;dbname=%s;charset=%s', $host, $port, $dbname, $charset);
        $this->_user = $user;
        $this->_password = $password;
        $this->_options = [];
        $this->_dbname = $dbname;
        $this->_charset = $charset;
    }
}
