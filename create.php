<?php
    $title = 'Create Todo';
    $todo = $_POST;
    $errors = [];

    $todoTitle = '';
    $todoDescription = '';
    if (!empty($todo)) {
        $todoTitle = trim($todo['title']);
        if (strlen($todoTitle) < 4) {
            $errors['title'] = 'Title length should be greater than or equal to 4.';
        }
        $todoDescription = trim($todo['description']);
        if (strlen($todoDescription) < 15) {
            $errors['description'] = 'Description length should be greater than or equal to 15.';
        }

        if (empty($errors)) {
            $id = 0;
            $filename = __DIR__ . '/todo.csv';
            if (!file_exists($filename)) {
                touch($filename);
            }
            $file = fopen($filename, 'r');
            $todos = [];
            do {
                $item = fgetcsv($file);
                $todos[] = $item;
                $id++; // $id = $id + 1;
            } while ($item !== false);
            @fclose($file);
            $file = fopen($filename, 'a');
            $dataToSave = implode(',', [$id, $todoTitle, $todoDescription]);
            fwrite($file,  $dataToSave . PHP_EOL);
            @fclose($file);
            header('Location: /view.php?id=' . $id);
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
        </form>
    </body>
</html>