<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require_once 'registerLoginLogic.php';
global $notif;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple shop site</title>
    <link href="LAB13_Ex01.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="page">
    <div class="top-nav-header">
        <div class="top-nav-container">
            <div class="top-left-menu">
                <form action="cartPage.php">
                    <button type="submit">Cart</button>
                </form>
            </div>
            <div class="top-right-menu">
                <div class="menu-item 1">
                    <form action="mainPage.php">
                        <button type="submit">Main Page</button>
                    </form>
                </div>
                <div class="menu-item 2 bank">
                    <form action="bankPage.php">
                        <button type="submit">Bank</button>
                    </form>
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

    <div class="notif">
        <?php if ($notif) : ?>
            <h1>Notifications:</h1>
            <p><?= $notif ?> </p>
        <?php endif ?>
    </div>
    <div class="formsPage">
        <!--REGISTER-->
        <form method='post' action="">
            <fieldset>
                <legend>Registration Form</legend>
                <label for="registerFirstName">First Name:</label>
                <input type="text" id="registerFirstName" name="registerFirstName" required>
                <label for="registerLastName">Last Name:</label>
                <input type="text" id="registerLastName" name="registerLastName" required>
                <label for="registerPassword">Password:</label>
                <input type="password" id="registerPassword" name="registerPassword" required>
                <label for="registerEmail">Email:</label>
                <input type="email" id="registerEmail" name="registerEmail" required>
                <button type="submit" name="register">Register</button>
            </fieldset>
        </form>
        <!--LOGIN-->
        <form method='post' action="">
            <fieldset>
                <legend>Login</legend>
                <label for="loginEmail">Email:</label>
                <input type="email" id="loginEmail" name="loginEmail" required>
                <label for="loginPassword">Password:</label>
                <input type="password" id="loginPassword" name="loginPassword" required>
                <button type="submit" name="login">Login</button>
            </fieldset>
        </form>

        <!--EDIT-->
        <?php if (isset($_SESSION['user_id'])) : ?>
        <form method='post' action="">
            <fieldset>
                <legend>Update User Data</legend>
                <label for="updateFirstName">First Name:</label>
                <input type="text" id="updateFirstName" name="updateFirstName" value="<?= $_SESSION['user_first_name'] ?>" required>
                <label for="updateLastName">Last Name:</label>
                <input type="text" id="updateLastName" name="updateLastName" value="<?= $_SESSION['user_last_name'] ?>" required>
                <label for="updateEmail">Email:</label>
                <input type="email" id="updateEmail" name="updateEmail" value="<?= $_SESSION['user_email'] ?>" required>
                <button type="submit" name="updateUserData">Update</button>
            </fieldset>
        </form>
        <!--DELETE-->
        <form method='post' action="">
            <fieldset>
                <legend>Delete Account</legend>
                <button type="submit" name="deleteAccount">Delete Account</button>
            </fieldset>
        </form>
            <!--LOGOUT-->
            <form method='post' action="">
                <fieldset>
                    <legend>Logout</legend>
                    <button type="submit" name="logout">Logout</button>
                </fieldset>
            </form>
            <!--RESET-->
        <?php endif ?>
        <form method='post' action="">
            <fieldset>
                <legend>Reset Password</legend>
                <label for="resetEmail">Email:</label>
                <input type="email" id="resetEmail" name="resetEmail" required>
                <label for="resetPassword">New Password:</label>
                <input type="password" id="resetPassword" name="resetPassword" required>
                <button type="submit" name="reset">Reset Password</button>
            </fieldset>
        </form>
    </div>
</div>
</body>
</html>