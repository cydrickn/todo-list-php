<?php

require_once __DIR__ . '/validation.php';

$filename =  __DIR__ . '/todo.csv';

function getList(): array
{
    global $filename;

    if (!file_exists($filename)) {
        touch($filename);
    }
    $file = fopen($filename, 'r');
    $todoList = [];
    do {
        $item = fgetcsv($file);
        if ($item !== false) {
            $todoList[$item[0]] = ['id' => $item[0], 'title' => $item[1], 'done' => false];
        }
    } while ($item !== false);
    @fclose($file);

    return $todoList;
}

/**
 * @param int $id
 * @return array|null
 */
function getTodo(int $id)
{
    global $filename;
    if (!file_exists($filename)) {
        touch($filename);
    }
    $file = fopen($filename, 'r');
    $todo = null;
    do {
        $item = fgetcsv($file);
        if ($item[0] === $_GET['id']) {
            $todo = $item;
        }
    } while ($item !== false && $todo === null);
    @fclose($file);

    if ($todo === null) {
        return null;
    }

    return [$todo[1], $todo[2]];
}

/**
 * @param int|null $id
 * @param string $title
 * @param string $description
 * @return array
 */
function saveTodo($id, string $title, string $description): array
{
    global $filename;
    $title = trim($title);
    $description = trim($description);
    $errors = validateTodo($title, $description);

    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }

    $todoList = getList();
    if ($id === null) {
        $id = array_key_last($todoList) + 1;
    }
    $todoList[$id] = [$id, $title, $description];
    $newData = '';
    foreach ($todoList as $item) {
        $newData .= implode(',', $item) . PHP_EOL;
    }
    file_put_contents($filename, $newData);

    return [
        'success' => true,
        'data' => [
            'id' => $id,
            'title' => $title,
            'description' => $description,
        ],
    ];
}