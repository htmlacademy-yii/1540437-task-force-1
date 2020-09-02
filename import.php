<?php

use app\components\Convertor\Convertor;
use app\components\Convertor\Readers\CsvReader;
use app\components\Convertor\Writers\SqlWriter;

require_once 'vendor/autoload.php';
error_reporting(E_ALL);

// use app\components\FakeRelations;
// use app\components\SqlGenerator;
// use app\faker\FakeCategories;
// use app\faker\FakeCities;
// use app\faker\FakeProfile;
// use app\faker\FakeTasks;
// use app\faker\FakeTasksResponses;
// use app\faker\FakeUser;
// use app\faker\FakeUserApinions;



// $fileName = 'src/sql/import.sql';
// $fakeRelations = new FakeRelations();
// $sqlGenerator = new SqlGenerator('taskforce');

// echo 'Import from files.......................................................';
// try {
//     $categories = FakeCategories::importFromFile('data/categories.csv');
//     $cities = FakeCities::importFromFile('data/cities.csv');
//     $users = FakeUser::importFromFile('data/users.csv');
//     $userProfiles = FakeProfile::importFromFile('data/profiles.csv');
//     $users = $fakeRelations->mergeWith($users, $userProfiles);
//     $tasks = FakeTasks::importFromFile('data/tasks.csv');
//     $taskResponses = FakeTasksResponses::importFromFile('data/replies.csv');
//     $userOpinions = FakeUserApinions::importFromFile('data/opinions.csv');
//     echo " OK". PHP_EOL;
// } catch (Throwable $e) {
//     echo " FAIL" . PHP_EOL;
//     echo $e;
//     return;
// }

// echo 'Set relations...........................................................';
// try {
//     $users = $fakeRelations->setRelation($users, $cities, ['city_id' => 'id']);
//     $tasks = $fakeRelations->setRelation($tasks, $users, ['customer_user_id' => 'id']);
//     $tasks = $fakeRelations->setRelation($tasks, $cities, ['city_id' => 'id']);
//     $userOpinions = $fakeRelations->setRelation($userOpinions, $users, ['user_id' => 'id']);
//     $userOpinions = $fakeRelations->setRelation($userOpinions, $tasks, ['refer_task_id' => 'id']);
//     $taskResponses = $fakeRelations->setRelation($taskResponses, $users, ['user_id' => 'id']);
//     $taskResponses = $fakeRelations->setRelation($taskResponses, $tasks, ['task_id' => 'id']);
//     echo " OK" . PHP_EOL;
// } catch (Throwable $e) {
//     echo " FAIL" . PHP_EOL;
//     echo $e;
//     return;
// }

// echo 'Generate SQL for import.................................................';
// try {
//     $data = $sqlGenerator->disbaleForeignKeyCheks();
//     $data .= $sqlGenerator->truncateByModel($tasks);
//     $data .= $sqlGenerator->truncateByModel($users);
//     $data .= $sqlGenerator->truncateByModel($cities);
//     $data .= $sqlGenerator->truncateByModel($categories);
//     $data .= $sqlGenerator->truncateByModel($userOpinions);
//     $data .= $sqlGenerator->truncateByModel($taskResponses);
//     $data .= $sqlGenerator->enableForeignKeyCheks();
//     $data .= $sqlGenerator->batchInsert($categories);
//     $data .= $sqlGenerator->batchInsert($cities);
//     $data .= $sqlGenerator->batchInsert($users);
//     $data .= $sqlGenerator->batchInsert($tasks);
//     $data .= $sqlGenerator->batchInsert($userOpinions);
//     $data .= $sqlGenerator->batchInsert($taskResponses);
//     echo " OK" . PHP_EOL;
// } catch (Throwable $e) {
//     echo " FAIL" . PHP_EOL;
//     echo $e;
//     return;
// }

// echo "Создание файла `{$fileName}` на основе полученных ранее данных...";
// try {
//     $file = new \SplFileObject($fileName, 'w+');
//     $file->ftruncate(0);
//     $file->fwrite($data);
//     echo " OK" . PHP_EOL;
// } catch (Throwable $e) {
//     echo " FAIL" . PHP_EOL;
//     echo $e;
// }


$files = [
    'categories.csv',
    'cities.csv',
    'opinions.csv',
    'profiles.csv',
    'replies.csv',
    'tasks.csv',
    'users.csv'
];

$csvPath = './data/csv';
$sqlPath = './data/sql';

foreach ($files as $file) {
    $reader = new CsvReader();
    $reader->setFile("{$csvPath}/{$file}");

    $writer = new SqlWriter();
    $writer->setPath($sqlPath);

    $convertor = new Convertor($reader, $writer);
    $convertor->convert();
}
