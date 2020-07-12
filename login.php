<?php
    include __DIR__ . '/bootstrap.php';

    if ($_SESSION['logined'] ?? false) {
        header('Location: index.php');
    }

    $authentication = $services[\Service\Authentication::class];

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $error = '';

    if ($username !== '') {
        $result = $authentication->login($username, $password);
        if ($result['valid']) {
            header('Location: index.php');
        } else {
            $error = $result['message'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/assets/style/main.css" />
    <style type="text/css">
        .login-box {
            background: #f7f1f1;
            width: 200px;
            margin-top: 25px;
        }
        .login-body,
        .login-header {
            text-align: center;
        }
        .login-body {
            margin-left: 5px;
            margin-right: 5px;
        }
        .login-body form {
            padding: 5px 2px 5px 2px !important;
        }
        .input {
            margin-top: 5px;
            margin-bottom: 5px;
        }
        .input .field {
            background: white;
            border-bottom: 1px solid gray;
            padding: 2px 5px;
        }
        .input input {
            display: block;
            width: 100%;
            border: none;
        }
        .error {
            color: white;
            border: 1px solid darkred;
            background: lightcoral;
            padding: 2px;
        }
    </style>
</head>
<body>
    <div class="login-box box">
        <div class="login-header">
            <h1>Login</h1>
        </div>
        <div class="login-body">
            <?php if ($error !== ''): ?>
                <div class="error">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <form method="post">
                <div class="input">
                    <label>Username:</label>
                    <div class="field">
                        <input name="username" value="<?php echo $username; ?>" />
                    </div>
                </div>
                <div class="input">
                    <label>Password:</label>
                    <div class="field">
                        <input name="password" type="password" value="<?php echo $password; ?>" />
                    </div>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>