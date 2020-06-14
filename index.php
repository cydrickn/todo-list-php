<?php
    $title = 'Todo List';

    $filename = __DIR__ . '/todo.csv';
    if (!file_exists($filename)) {
        touch($filename);
    }
    $file = fopen($filename, 'r');
    $todoList = [];
    do {
        $item = fgetcsv($file);
        if ($item !== false) {
            $todoList[] = ['id' => $item[0], 'title' => $item[1], 'done' => false];
        }
    } while ($item !== false && $todo === null);
    @fclose($file);
?>
<html>
    <head>
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <h1>My TODO List</h1>
        <ol>
            <?php foreach ($todoList as $todo): ?>
                <li>
                    <?php if ($todo['done']): ?>
                        <input type="checkbox" checked="checked" />
                    <?php else: ?>
                        <input type="checkbox" />
                    <?php endif; ?>
                    <a href="/view.php?id=<?php echo $todo['id'] ?>" target="_blank">
                        <?php echo $todo['title']; ?>
                    </a>
                    <a href="/update.php?id=<?php echo $todo['id'] ?>" target="_blank">Update</a>
                </li>
            <?php endforeach; ?>
        </ol>
        <a href="/create.php" target="_blank">Create TODO</a>
    </body>
</html>