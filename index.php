<?php
    include __DIR__ . '/todo_functions.php';

    $title = 'Todo List';
    $todoList = getList($_GET['search'] ?? '');
?>
<html>
    <head>
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <h1>My TODO List</h1>
        <div>
            <form>
                <input type="text" name="search" value="<?php echo $_GET['search'] ?? ''; ?>"/><button>Search</button>
            </form>
        </div>
        <div>
            <?php foreach ($todoList as $todo): ?>
                <div>
                    <?php echo $todo['id']; ?>&nbsp;
                    <?php if ($todo['done']): ?>
                        <input type="checkbox" checked="checked" />
                    <?php else: ?>
                        <input type="checkbox" />
                    <?php endif; ?>
                    <a href="/view.php?id=<?php echo $todo['id'] ?>">
                        <?php echo $todo['title']; ?>
                    </a>
                    <a href="/update.php?id=<?php echo $todo['id'] ?>">Update</a>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="/create.php" target="_blank">Create TODO</a>
    </body>
</html>