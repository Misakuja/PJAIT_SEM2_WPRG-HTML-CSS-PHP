<?php
session_start();

$userFile = 'LAB10_EX04_users.json';
if (file_exists($userFile)) {
    $users = json_decode(file_get_contents($userFile), true);
} else {
    $users = [];
}

//Register
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $newUsername = $_POST['newUsername'];
    $newPassword = $_POST['newPassword'];

    if (!isset($users[$newUsername])) {
        $users[$newUsername] = password_hash($newPassword, PASSWORD_DEFAULT);
        file_put_contents($userFile, json_encode($users));
    }
}

// Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($users[$username]) && password_verify($password, $users[$username])) {
        $_SESSION['logged_in'] = $username;
    }
}

//Logout
if (isset($_POST['logout'])) {
    unset($_SESSION['logged_in']);
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page - Simple shop site</title>
    <link href="LAB10_Ex04.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="page">
    <div class="top-nav-header">
        <div class="top-nav-container">
            <div class="top-left-menu">
                <form action="LAB10_Ex04-3.php">
                    <button type="submit">Cart</button>
                </form>
            </div>
            <div class="top-right-menu">
                <div class="menu-item 1">
                    <form action="LAB10_Ex04-1.php">
                        <button type="submit">Main Page</button>
                    </form>
                </div>
                <div class="menu-item 2">
                    <?php if (isset($_SESSION['logged_in'])) : ?>
                        <form method='post' action="">
                            <button type="submit" name="logout">Logout</button>
                        </form>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
    <div class="image-text-container">
        <header class="middle-text">
            <h1>
                <strong>Simple Shop</strong>
                Dolorem ex vel similique ut consectetur quidem tempore?
            </h1>
        </header>
        <div class="header-background"><img src="https://i.imgur.com/08SHq9K.png" alt="header-background"></div>
    </div>
    <div class="boxes">
        <div class="registerLogin">
            <form method='post' action="">
                <fieldset>
                    <legend>Register</legend>
                    <div class="newFormLine">
                    <label for="newUsername">Username:</label>
                    <input type="text" id="newUsername" name="newUsername" required>
                    </div>
                    <div class="newFormLine">
                    <label for="newPassword">Password:</label>
                    <input type="password" id="newPassword" name="newPassword" required>
                    </div>
                    <button type="submit" name="register">Register</button>
                </fieldset>
            </form>
        </div>
        <div class="registerLogin">
            <form method='post' action="">
                <fieldset>
                    <legend>Login</legend>
                    <div class="newFormLine">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                    </div>
                    <div class="newFormLine">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" name="login">Login</button>
                </fieldset>
            </form>
        </div>
    </div>
</div>
</body>
</html>
