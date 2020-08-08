<?php
    include __DIR__ . '/bootstrap.php';
    $todoService = $services[\Service\TodoService::class];

    $title = 'Todo List';
    $todoList = $todoService->getTodoList($_GET['search'] ?? '');
?>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="/assets/style/main.css" />
    </head>
    <body>

        <div class="grid">
            <div class="row">
                <div class="col col-3">
                    Welcome <?php echo $_SESSION['user']['name']; ?> <a href="logout.php">Log Out</a>
                </div>
                <div class="col col-2 align-right">
                    <form>
                        <input type="text" name="search" value="<?php echo $_GET['search'] ?? ''; ?>"/><button>Search</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="box grid">
            <?php foreach ($todoList as $todo): ?>
                <div class="row border-bottom-1">
                    <div class="col col-1">
                        <?php echo $todo->getId(); ?>
                    </div>
                    <div class="col col-1">
                    <?php if ($todo->isDone()): ?>
                        <input type="checkbox" checked="checked" />
                    <?php else: ?>
                        <input type="checkbox" />
                    <?php endif; ?>
                    </div>
                    <div class="col col-2">
                        <a href="/view.php?id=<?php echo $todo->getId(); ?>">
                            <?php echo $todo->getTitle(); ?>
                        </a>
                    </div>
                    <div class="col col-1">
                        <a href="/update.php?id=<?php echo $todo->getId(); ?>">Update</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="/create.php">Create TODO</a>
    </body>
</html>