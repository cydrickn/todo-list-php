<?php



function getByUsername(string $username): ?array
{
    global $userFolder;
    $filepath = $userFolder . '/' . $username . '.json';
    if (file_exists($filepath)) {
        $user = file_get_contents($filepath);

        return json_decode($user, true);
    } else {
        return null;
    }
}

function checkLogined()
{
    $isLogined = $_SESSION['logined'] ?? false;

    if (!$isLogined) {
        header('Location: login.php');
    }
}