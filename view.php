<?php
    include __DIR__ . '/todo_functions.php';
    list($title, $description) = getTodo($_GET['id']);
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