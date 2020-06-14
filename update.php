<?php
    $id = $_GET['id'];
    $filename = __DIR__ . '/todo.csv';
    if (!file_exists($filename)) {
        touch($filename);
    }
    $file = fopen($filename, 'r');
    $todo = null;
    $todos = [];
    do {
        $item = fgetcsv($file);
        if ($item[0] === $id) {
            $todo = $item;
        }
        if ($item !== false) {
            $todos[$item[0]] = $item;
        }
    } while ($item !== false);
    @fclose($file);

    $errors = [];
    $title = trim($_POST['title'] ?? $todo[1]);
    $description = trim($_POST['description'] ?? $todo[2]);

    if (!empty($_POST)) {
        if (strlen($title) < 4) {
            $errors['title'] = 'Title length should be greater than or equal to 4.';
        }
        if (strlen($description) < 15) {
            $errors['description'] = 'Description length should be greater than or equal to 15.';
        }

        if (empty($errors)) {
            $todos[$id] = [$id, $title, $description];
            $newData = '';
            foreach ($todos as $item) {
                $newData .= implode(',', $item) . PHP_EOL;
            }
            file_put_contents($filename, $newData);
        }
    }
?>
<html>
    <head>
        <title><?php echo $title; ?></title>
    </head>
    <body>
    <form method="post">
        <div>
            <label for="title">Title</label>
            <input id="title" name="title" type="text" value="<?php echo $title; ?>" />
            <?php if (array_key_exists('title', $errors)): ?>
                <p><?php echo $errors['title']; ?></p>
            <?php endif; ?>
        </div>
        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description"><?php echo $description; ?></textarea>
            <?php if (array_key_exists('description', $errors)): ?>
                <p><?php echo $errors['description']; ?></p>
            <?php endif; ?>
        </div>
        <button type="submit">Update</button>
    </form>
    </body>
</html>