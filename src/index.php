<?php
error_reporting(E_ALL);
require 'BaseTask.php';

/** @var int $customerId */
$customerId = 1;
$performerId = 20;

$task = new BaseTask($customerId, $performerId);

$task->actionCreate();
$task->actionPending();
$task->actionStart();
