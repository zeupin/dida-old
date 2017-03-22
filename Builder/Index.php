<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
header("Content-type: text/html; charset=utf-8");
$app = app();
//app()->get('router')->route($app['request']);
//var_dump($app->db);
$result = $app->db->query(<<<'EOT'
   select * from information_schema.TABLES WHERE TABLE_SCHEMA LIKE 'pi'
EOT
    );
foreach ($result as $row) {
    //var_dump($row);
}

$schema = new \Dida\Database\Schema\Mysql($app->db);
//var_export($schema->listTableNames());

var_export($schema->listColumns('contact'));
foreach ($tables = $schema->listTables() as $table) {
    //var_export(array_keys($table));
    die();
}
