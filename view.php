<?php
    include __DIR__ . '/bootstrap.php';

    checkLogined();

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