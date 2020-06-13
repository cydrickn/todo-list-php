<?php
    $title = 'Create Todo';
    $todo = $_POST;
    $errors = [];
    if (!empty($todo)) {
        if (strlen($todo['title']) < 4) {
            $errors['title'] = 'Title length should be greater than or equal to 4.';
        }
        if (strlen($todo['description']) < 15) {
            $errors['description'] = 'Description length should be greater than or equal to 15.';
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
                <input id="title" name="title" type="text" value="<?php echo $todo['title'] ?? ''; ?>" />
                <?php if (array_key_exists('title', $errors)): ?>
                    <p><?php echo $errors['title']; ?></p>
                <?php endif; ?>
            </div>
            <div>
                <label for="description">Description</label>
                <textarea id="description" name="description"><?php echo $todo['description'] ?? ''; ?></textarea>
                <?php if (array_key_exists('description', $errors)): ?>
                    <p><?php echo $errors['description']; ?></p>
                <?php endif; ?>
            </div>
            <button type="submit">Create</button>
        </form>
    </body>
</html>