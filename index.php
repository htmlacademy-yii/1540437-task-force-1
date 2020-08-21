<?php

use app\components\CsvParser;
use app\faker\FakeCategories;
use app\faker\FakeCities;
use app\faker\FakeProfile;
use app\faker\FakeTasks;
use app\faker\FakeTasksResponses;
use app\faker\FakeUser;

require_once 'vendor/autoload.php';

$model = FakeTasksResponses::import('data/replies.csv');
// $model = FakeCategories::import('data/categories.csv');

foreach ($model as $city) {
    // print_r($city);
    echo $city->toSql('taskforce') . PHP_EOL;
    // return;
}

return;

$userModels = FakeUser::import('data/users.csv');
$userProfileModels = FakeProfile::import('data/profiles.csv');

echo $userModels[1]->toSql('taskforce', 'users', 'truncate') . PHP_EOL;

return;
/** @var FakeUser $user */
foreach ($userModels as $user) {
    echo $user->toSql('taskforce', 'users', 'insert') . PHP_EOL;
}

/** @var FakeProfile $userProfile */
foreach ($userProfileModels as $userProfile) {
    echo $userProfile->toSql('taskforce', 'users', 'update') . PHP_EOL;
}

// print_r($userModels);

return;

$parseredUsers = new CsvParser('data/users.csv');
$parseredProfile = new CsvParser('data/profiles.csv');

$usersRows = $parseredUsers->getRows();
$profilesRows = $parseredProfile->getRows();

for ($i = 0; $i < count($usersRows); $i++) {
    $id = $i + 1;
    $user = new FakeUser($id, $usersRows[$i]);
    $user->setAttributes($profilesRows[$i]);

    echo "-- " . $user->toSql('taskforce', 'users') . PHP_EOL;
}



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
