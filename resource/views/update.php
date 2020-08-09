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
    <a href="/index.php">Back to List</a>
</form>
</body>
</html>