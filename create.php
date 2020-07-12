<?php
    include __DIR__ . '/bootstrap.php';

    $todoService = $services[\Service\TodoService::class];

    $title = 'Create Todo';
    $todo = $_POST;
    $errors = [];

    $todoTitle = '';
    $todoDescription = '';
    if (!empty($todo)) {
        $todoTitle = $_POST['title'];
        $todoDescription = $_POST['description'];
        try {
            $todo = $todoService->createTodo($todoTitle, $todoDescription);
            header('Location: ./view.php?id=' . $todo->getId());
        } catch (\Exceptions\InvalidTodoException $exception) {
            $errors = $exception->getErrors();
        }
    }
?>
<html>
    <head>
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <h1>Create TODO</h1>
        <form method="post">
            <div>
                <label for="title">Title</label>
                <input id="title" name="title" type="text" value="<?php echo $todoTitle; ?>" />
                <?php if (array_key_exists('title', $errors)): ?>
                    <p><?php echo $errors['title']; ?></p>
                <?php endif; ?>
            </div>
            <div>
                <label for="description">Description</label>
                <textarea id="description" name="description"><?php echo $todoDescription; ?></textarea>
                <?php if (array_key_exists('description', $errors)): ?>
                    <p><?php echo $errors['description']; ?></p>
                <?php endif; ?>
            </div>
            <button type="submit">Create</button>
            <a href="/index.php">Back to List</a>
        </form>
    </body>
</html>