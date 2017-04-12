<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Exception</title>
  <style>
    body,table {font-family: Vendana; font-size: 9pt;}
    th {vertical-align: top; text-align: left; padding-right: 2em;}
    div {margin-bottom: 1em;}
    div.error {color: red;}
    span.file {display: block; font-weight: bold; margin: 0; margin-bottom: 0.2em;}
    span.line {display: inline-block; width: 3em; margin-left: 2em;}
    span.function {color:blue; font-weight: bold;}
  </style>
</head>
<body>
  <h1>Exception!</h1>
  <table>
    <tr><th nowrap>Type:</th><td><?= get_class($e) ?></td></tr>
    <tr><th nowrap>Message:</th><td><?= htmlspecialchars($e->getMessage()) ?></td></tr>
    <tr><th nowrap>Code:</th><td><?= $e->getCode() ?></td></tr>
    <tr><th nowrap>Trace:</th>
    <td>
<?php
$trace = $e->getTrace();
$trace = array_reverse($trace);
foreach ($trace as $row) {
    ?>
      <div>
        <span class="file"><?= htmlspecialchars($row['file']) ?></span>
        <span class="line"><?= $row['line'] ?></span>
        <span class="function"><?= htmlspecialchars($row['function']) ?>()</span>
      </div>
<?php

}
?>
      <hr>
      <div class="error">
        <span class="file"><?= htmlspecialchars($e->getFile()) ?></span>
        <span class="line"><?= $e->getLine() ?></span>
      </div>
    </td></tr>
  </table>
</body>
</html>