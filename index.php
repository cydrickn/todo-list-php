<?php
    include __DIR__ . '/todo_functions.php';

    $title = 'Todo List';
    $todoList = getList();
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
                    <a href="/view.php?id=<?php echo $todo['id'] ?>">
                        <?php echo $todo['title']; ?>
                    </a>
                    <a href="/update.php?id=<?php echo $todo['id'] ?>">Update</a>
                </li>
            <?php endforeach; ?>
        </ol>
        <a href="/create.php" target="_blank">Create TODO</a>
    </body>
</html>