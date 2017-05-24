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

$a = [3 => [2,1]];

echo json_encode($a);
die();

$s = <<<EOT
{
  "name": "bootstrap---twbs",
  "version": "3.3.7",
  "dependencies":
    {
      "jquery---jquery": "1.9.1 to 3.*"
    },
  "homepage": "http://getbootstrap.com",
  "author": "Twitter, Inc.",
  "repository":
    {
      "type": "git",
      "url": "https://github.com/twbs/bootstrap.git"
    }
}
EOT;

echo \Dida\Debug::varDump(json_decode($s));