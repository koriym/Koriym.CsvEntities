<?php

use Koriym\CsvEntities\CsvEntities;
use Koriym\CsvEntities\Memo;
use Koriym\CsvEntities\Todo;

require dirname(__DIR__) . '/vendor/autoload.php';

$pdo = new PDO('sqlite::memory:');

// prepare
$sqlDir = __DIR__ . '/sql';
$pdo->query((string) file_get_contents($sqlDir . '/create_todo.sql'));
$pdo->query((string) file_get_contents($sqlDir . '/create_memo.sql'));

$todoAdd = $pdo->prepare((string) file_get_contents($sqlDir . '/todo_add.sql'));
$todoAdd->execute(['id' => '1', 'title' => 'run']);

$memoAdd = $pdo->prepare((string) file_get_contents($sqlDir . '/memo_add.sql'));
$memoAdd->execute(['id' => '1', 'body' => 'memo1', 'todoId' => '1']);
$memoAdd->execute(['id' => '2', 'body' => 'memo2', 'todoId' => '1']);

// query
$todoListPdo = $pdo->query((string) file_get_contents($sqlDir . '/todo_list_join.sql'));
$todoList = $todoListPdo->fetchAll(PDO::FETCH_FUNC, static function (...$args) {
    return new Todo(...$args);
});

var_dump($todoList);
