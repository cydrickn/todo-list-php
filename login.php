<?php
    include __DIR__ . '/bootstrap.php';

    if ($_SESSION['logined'] ?? false) {
        header('Location: index.php');
    }

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $error = '';

    if ($username !== '') {
        $user = getByUsername($username);
        if ($user === null) {
            $error = 'Username does not exists.';
        } elseif ($password !== $user['password']) {
            $error = 'Password incorrect';
        } else {
            $_SESSION['logined'] = true;
            $_SESSION['user'] = $user;

            header('Location: index.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if ($error !== ''): ?>
    <div>
        <?php echo $error; ?>
    </div>
    <?php endif; ?>
    <form method="post">
        <label>
            Username:
            <input name="username" value="<?php echo $username; ?>" />
        </label>
        <label>
            Password:
            <input name="password" type="password" value="<?php echo $password; ?>" />
        </label>
        <button type="submit">Login</button>
    </form>
</body>
</html>