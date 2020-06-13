<?php
    $title = $_REQUEST['title'];
    $description = $_REQUEST['description'];
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