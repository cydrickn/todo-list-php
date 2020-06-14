<?php
    $filename = __DIR__ . '/todo.csv';
    if (!file_exists($filename)) {
        touch($filename);
    }
    $file = fopen($filename, 'r');
    $todo = null;
    do {
        $item = fgetcsv($file);
        if ($item[0] === $_GET['id']) {
            $todo = $item;
        }
    } while ($item !== false && $todo === null);
    @fclose($file);

    $title = $todo[1];
    $description = $todo[2];
?>
<html>
    <head>
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <h1><?php echo $title; ?></h1>
        <p><?php echo $description ?></p>
    </body>
</html>