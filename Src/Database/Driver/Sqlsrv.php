<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Database\Driver;

/**
 * MS SQL Server驱动 (Windows环境)
 */
class Sqlsrv extends Driver
{
    public function __construct(array $config)
    {
        /* 必填参数 */
        if (!isset($config['server']) ||
            !isset($config['user']) ||
            !isset($config['password']) ||
            !isset($config['dbname'])) {
            throw new \Dida\DatabaseConnectionException();
            return false;
        }
        $server = $config['server'];
        $user = $config['user'];
        $password = $config['password'];
        $dbname = $config['dbname'];

        /* 选填参数 */
        $charset = isset($config['charset']) ? $config['charset'] : 'utf8';

        /* 设置 */
        $this->_dsn = sprintf('sqlsrv:server=%s;database=%s;', $server, $dbname);
        $this->_user = $user;
        $this->_password = $password;
        $this->_options = [];
        $this->_dbname = $dbname;
        $this->_charset = $charset;
    }
}
