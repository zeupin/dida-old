<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */
header("Content-type: text/html; charset=utf-8");

$app = app();
$conn = $app->db;

//$conn->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'integer');
$sm = $conn->getSchemaManager();
//$tables = $sm->listViews();

$columns = $sm->listTableDetails('user');
foreach ($columns as $column) {
    echo sprintf('%s --%s<br>', $column->getName(), $column->getType());
}

for($i=0; $i<20; $i++) {
  echo microtime().PHP_EOL;
}