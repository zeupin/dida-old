<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Database\Driver;

/**
 * MS SQL Server驱动
 */
class Sqlserver extends Driver
{
    public function __construct(array $config)
    {
        if (isset($config['server'])) {
            $this->sqlsrv($config);
        } else {
            $this->dblib($config);
        }
    }


    /**
     * sqlsrv模式 (Windows环境)
     *
     * 必填:
     *     server, user, password, dbname
     * 选填:
     *     charset 默认 utf8
     */
    private function sqlsrv(array $config)
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


    /**
     * dblib模式 (Linux环境)
     *
     * 必填:
     *     host, port, user, password, dbname
     * 选填:
     *     charset 默认 utf8
     */
    private function dblib(array $config)
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
