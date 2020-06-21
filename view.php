<?php
    include __DIR__ . '/todo_functions.php';

    try {
        $todo = getTodo($_GET['id']);
        $title = $todo['title'];
        $description = $todo['description'];
    } catch (\Exception $exception) {
        $title = 'Not found';
        $description = 'TODO Not found';
    }
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