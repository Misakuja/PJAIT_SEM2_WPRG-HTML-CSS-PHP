<?php
session_start();

// Create + decode file
$userFile = 'LAB10_EX01_users.json';
if (file_exists($userFile)) {
    $users = json_decode(file_get_contents($userFile), true);
} else {
    $users = [];
}

// Initialize topText
$topText = '';

// Registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $newUsername = $_POST['newUsername'];
    $newPassword = $_POST['newPassword'];

    if (!isset($users[$newUsername])) {
        $users[$newUsername] = password_hash($newPassword, PASSWORD_DEFAULT);
        file_put_contents($userFile, json_encode($users));
        echo $topText = '<div class="topText">User ' . $newUsername . ' registered successfully.</div>';
    } else {
        echo $topText = '<div class="topText">Username ' . $newUsername . ' is already taken.</div>';
    }
}

// Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($users[$username]) && password_verify($password, $users[$username])) {
        $_SESSION['logged_in'] = $username;
        echo $topText = '<div class="topText">Logged in as: ' . $username . '</div>';
    } else {
         echo $topText = '<div class="topText">Wrong login data.</div>';
    }
}

// Logout
if (isset($_POST['logout'])) {
    unset($_SESSION['logged_in']);
    session_destroy();
     echo $topText = '<div class="topText">Logged out successfully.</div>';
}

// Increment capybara count
if (isset($_SESSION['logged_in'])) {
    $username = $_SESSION['logged_in'];
    $cookieName = "cookie_$username";
    $pageAccessAmount = $_COOKIE[$cookieName] ?? 0;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['increment'])) {
        $pageAccessAmount++;
        setcookie($cookieName, $pageAccessAmount);
        $_COOKIE[$cookieName] = $pageAccessAmount;
    }

    $topText = '<div class="topText">Capybara amount: ' . $pageAccessAmount . '</div>';
} else {
    $topText = '<div class="topText">Please log in to see the capybara amount.</div>';
}

echo $topText

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register/Login site</title>
    <link href="LAB10_Ex01.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="boxes">
<div class="formsBox">
    <div class="box boxRegisterLogin">
        <form method='post' action="">
            <fieldset>
                <legend>Register</legend>
                <label for="newUsername">Username:</label>
                <input type="text" id="newUsername" name="newUsername" required>
                <label for="newPassword">Password:</label>
                <input type="password" id="newPassword" name="newPassword" required>
                <button type="submit" name="register">Register</button>
            </fieldset>
        </form>
    </div>
    <div class="box boxRegisterLogin">
        <form method='post' action="">
            <fieldset>
                <legend>Login</legend>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit" name="login">Login</button>
            </fieldset>
        </form>
    </div>
</div>
<div class="buttonsBox">
    <?php if (isset($_SESSION['logged_in'])) : ?>
        <div class="box boxButtons increment">
            <form method='post' action="">
                <fieldset>
                    <button type="submit" name="increment">Increment Capybara Count</button>
                </fieldset>
            </form>
        </div>
        <div class="box boxButtons logout">
            <form method='post' action="">
                <fieldset>
                    <button type="submit" name="logout">Logout</button>
                </fieldset>
            </form>
        </div>
    <?php endif ?>
</div>
</div>
</body>
</html>