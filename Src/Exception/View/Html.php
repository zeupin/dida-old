<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Exception</title>
  <style>
    body,table {font-family: Vendana; font-size: 9pt;}
    th {vertical-align: top; text-align: left;}
    div {margin-bottom: 0.5em;}
    div.errFile {color: red;}
    span.file {display: block; font-weight: bold; margin: 0;}
    span.line {display: inline-block; width: 3em; margin-left: 2em;}
    span.function {color:blue; font-weight: bold;}
  </style>
</head>
<body>
  <h1>Exception!</h1>
  <table>
    <tr><th>Type:</th><td><?= $e->getType() ?></td></tr>
    <tr><th>Message:</th><td><?= htmlspecialchars($e->getMessage()) ?></td></tr>
    <tr><th>Code:</th><td><?= $e->getCode() ?></td></tr>
    <tr><th>Trace:</th>
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
      <div class="errFile">
        <span class="file"><?= htmlspecialchars($e->getFile()) ?></span>
        <span class="line"><?= $e->getLine() ?></span>
      </div>
    </td></tr>
  </table>
</body>
</html>