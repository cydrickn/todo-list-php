<?php

function getList(string $title = ''): array
{
    global $todoFolder;
    global $todoIndexTitleFolder;

    if (!is_dir($todoFolder)) {
        mkdir($todoFolder);
    }

    $todoList = [];

    if ($title === '') {
        $files = scandir($todoFolder);
        foreach ($files as $file) {
            if ($file !== '..' && $file !== '.') {
                $content = file_get_contents($todoFolder . '/' . $file);
                $todo = json_decode($content, true);
                $todoList[$todo['id']] = $todo;
            }
        }
    } else {
        // Add Function
        $indexTitleFileName = str_replace(' ', '_', $title);
        $indexTitleFileName = $todoIndexTitleFolder . '/' . strtolower($indexTitleFileName) . '.json';
        $indexes = glob($indexTitleFileName);

        $ids = [];
        foreach ($indexes as $indexFilename) {
            foreach (json_decode(file_get_contents($indexFilename)) as $id) {
                $ids[] = $id;
            }
        }

        foreach ($ids as $id) {
            $todoList[$id] = getTodo($id);
        }
    }

    return $todoList;
}

/**
 * @param int $id
 * @return array|null
 */
function getTodo(int $id)
{
    global $todoFolder;
    $filename = $todoFolder . '/' . $id . '.json'; // data/todo/1.json
    if (!file_exists($filename)) {
        throw new Exception('Not found');
    }

    return json_decode(file_get_contents($filename), true);
}

/**
 * @param int|null $id
 * @param string $title
 * @param string $description
 * @return array
 */
function saveTodo($id, string $title, string $description): array
{
    global $todoFolder;
    global $todoPropertiesFileName;

    $data = ['id' => $id, 'title' => trim($title), 'description' => trim($description)];
    $errors = validateTodo($data['title'], $data['description']);

    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }

    if ($id === null) {
        $todoProperties = json_decode(file_get_contents($todoPropertiesFileName), true);
        $id = $todoProperties['autoincrement'];
        $data['id'] = $id;
        $todoProperties['autoincrement']++;
        file_put_contents($todoPropertiesFileName, json_encode($todoProperties));
    } else {
        $oldData = getTodo($id);
        $data = array_merge($oldData, $data);
    }
    $filename = $todoFolder . '/' . $id . '.json';

    file_put_contents($filename, json_encode($data));

    return [
        'success' => true,
        'data' => $data,
    ];
}