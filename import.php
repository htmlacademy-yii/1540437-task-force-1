<?php

use app\components\Convertor\Convertor;
use app\components\Convertor\Readers\CsvReader;
use app\components\Convertor\Writers\SqlWriter;

require_once 'vendor/autoload.php';
error_reporting(E_ALL);

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
