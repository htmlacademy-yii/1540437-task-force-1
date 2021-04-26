<?php

use app\components\Convertor\Convertor;
use app\components\Convertor\Readers\CsvReader;
use app\components\Convertor\Writers\SqlWriter;

require __DIR__ . '/../vendor/autoload.php';


$files = [
    'categories.csv',
    'cities.csv',
    'tasks.csv',
    'task_responses.csv',
    'users.csv',
    'user_profile.csv',
    'user_reviews.csv'
];

$writer = new SqlWriter();
$writer->setPath(__DIR__ . '/../data/sql2');



foreach ($files as $file) {
    $reader = new CsvReader();
    $reader->setFile(__DIR__ . "/../data/csv/" . $file);
    $converter = new Convertor($reader, $writer);
    $converter->convert();
}
