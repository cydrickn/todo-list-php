<html>
<head>
    <title><?php echo $title; ?></title>
</head>
<body>
<?php if ($todo !== null): ?>
    <h1><?php echo $todo->getTitle(); ?></h1>
    <p><?php echo $todo->getDescription(); ?></p>
<?php else: ?>
    <h1>Todo Not found</h1>
<?php endif; ?>
<a href="/index.php">Back to List</a>
</body>
</html>