<?php

namespace Service;

use Model\Todo;

class TodoFileDataProvider implements TodoDataProviderInterface
{
    private string $todoFolder;
    private string $todoIndexFolder;
    private string $propertiesFile;

    public function __construct(string $todoFolder, string $todoIndexFolder, string $propertiesFile)
    {
        $this->todoFolder = $todoFolder;
        $this->todoIndexFolder = $todoIndexFolder;
        $this->propertiesFile = $propertiesFile;
    }

    public function list(string $title = ''): array
    {
        $todoList = [];
        if ($title === '') {
            $files = scandir($this->todoFolder);
            foreach ($files as $file) {
                if ($file !== '..' && $file !== '.') {
                    $content = file_get_contents($this->todoFolder . '/' . $file);
                    $todoData = json_decode($content, true);
                    $todoList[] = new Todo(
                        $todoData['id'],
                        $todoData['title'],
                        $todoData['description']
                    );
                }
            }
        } else {
            $indexTitleFileName = str_replace(' ', '_', $title);
            $indexTitleFileName = $this->todoIndexFolder . '/' . strtolower($indexTitleFileName) . '.json';
            $indexes = glob($indexTitleFileName);

            $ids = [];
            foreach ($indexes as $indexFilename) {
                foreach (json_decode(file_get_contents($indexFilename)) as $id) {
                    $ids[] = $id;
                }
            }

            foreach ($ids as $id) {
                $todoList[] = $this->find($id);
            }
        }

        return $todoList;
    }

    public function find(int $id): ?Todo
    {
        $filename = $this->todoFolder . '/' . $id . '.json';
        if (!file_exists($filename)) {
            return null;
        }
        $todoData = json_decode(file_get_contents($filename), true);

        return new Todo($todoData['id'], $todoData['title'], $todoData['description']);
    }

    public function save(?int $id, string $title, string $description): Todo
    {
        if ($id === null) {
            $todo = new Todo($id, $title, $description);
            $todoProperties = json_decode(file_get_contents($this->propertiesFile), true);
            $id = $todoProperties['autoincrement'];
            $todo->setId($id);
            $todoProperties['autoincrement']++;
            file_put_contents($this->propertiesFile, json_encode($todoProperties));
        } else {
            $todo = $this->find($id);
            $todo->setTitle($title);
            $todo->setDescription($description);
        }
        $filename = $this->todoFolder . '/' . $id . '.json';

        file_put_contents($filename, $todo->toJson());

        return $todo;
    }
}