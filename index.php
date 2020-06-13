<?php
    $title = 'Todo List';
    $todoList = [
        ['title' => 'Add List Page', 'done' => true],
        ['title' => 'Add Create Page', 'done' => false],
        ['title' => 'Add View Page', 'done' => false],
        ['title' => 'Add Update Page', 'done' => false],
    ];
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
                    <?php echo $todo['title']; ?>
                </li>
            <?php endforeach; ?>
        </ol>
    </body>
</html>