<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Database\Driver;

/**
 * Sqlite3 驱动
 */
class Sqlite extends Driver
{
    public function __construct(array $config)
    {
        /* 必填参数 */
        if (!isset($config['file'])) {
            throw new \Dida\DatabaseConnectionException();
            return false;
        }
        $file = str_replace('\\', '/', $config['file']);

        /* 设置 */
        $this->_dsn = sprintf('sqlite:%s', $file);
        $this->_user = null;
        $this->_password = null;
        $this->_dbname = null;
        $this->_charset = null;
    }
}
