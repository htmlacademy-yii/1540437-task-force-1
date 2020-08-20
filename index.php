<?php

use app\components\CsvParser;

require_once "vendor/autoload.php";


$parser = new CsvParser("data/users.csv");

$template = 'INSERT INTO `{db}`.`{table}` ({columns}) VALUE ({row});' . PHP_EOL;


print_r($parser->getColumns());
echo "Count: " .  $parser->getColumnCount() . PHP_EOL;

$db = 'taskforce';
$table = 'users';

$result = '';
$id = 1;
foreach ($parser->getNextLine() as $row) {
    if (count($row) !== $parser->getColumnCount()) {
        continue;
    }
    $result = strtr($template, [
        '{db}' => $db,
        '{table}' => $table,
        '{columns}' => implode(",", $parser->getColumns()),
        '{row}' => implode(",", $row)
    ]);

    echo $result;
}

// echo $result;
