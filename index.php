<?php

use app\components\CsvParser;
use app\faker\FakeUser;

require_once 'vendor/autoload.php';

$parseredUsers = new CsvParser('data/users.csv');
$parseredProfile = new CsvParser('data/profiles.csv');

$usersRows = $parseredUsers->getRows();
$profilesRows = $parseredProfile->getRows();

$result = [];

for ($i = 0; $i < count($usersRows); $i++) {
    $id = $i + 1;
    $user = new FakeUser($id, $usersRows[$i]);
    $user->setAttributes($profilesRows[$i]);
    $result[$id] = $user;
}

print_r($result);

// print_r($parseredProfile->getRows());

return;

$columns = array_merge($parseredUsers->getColumns(), $parseredProfile->getColumns());

print_r($columns);

$parser = new CsvParser('data/users.csv');
$counRows = count($parser->getColumns());

$result = [];
$id = 1;
foreach ($parser->getNextLine() as $row) {
    if ($counRows !== count($row)) {
        continue;
    }
    $combined = array_combine($parser->getColumns(), $row);
    if (is_array($combined)) {
        $result[$id] = new FakeUser($id, $combined);
        $id++;
    }

    // print_r($row);
}

print_r($result);

// $template = 'INSERT INTO `{db}`.`{table}` ({columns}) VALUE ({row});' . PHP_EOL;

// print_r($parser->getColumns());
// echo "Count: " .  $parser->getColumnCount() . PHP_EOL;

// $db = 'taskforce';
// $table = 'users';

// $result = '';
// $id = 1;
// foreach ($parser->getNextLine() as $row) {
//     if (count($row) !== $parser->getColumnCount()) {
//         continue;
//     }
//     $result = strtr($template, [
//         '{db}' => $db,
//         '{table}' => $table,
//         '{columns}' => implode(",", $parser->getColumns()),
//         '{row}' => implode(",", $row)
//     ]);

//     echo $result;
// }

// echo $result;
