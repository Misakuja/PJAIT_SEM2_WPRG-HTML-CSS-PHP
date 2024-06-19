<?php
session_start();

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'MyN3wP4ssw0rd';
$dbname = 'LAB13Ex01';
$registered = null;
$user = null;
$notif = null;
$rowCount = null;

//Logout
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    unset($_SESSION['user_id']);
    session_destroy();
}

try {
    $pdo = new PDO("mysql:host=$dbhost", $dbuser, $dbpass);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");

    $registeredTable = "CREATE TABLE IF NOT EXISTS Registered ( 
    User_id INT AUTO_INCREMENT, 
    User_first_name VARCHAR(255) NOT NULL, 
    User_last_name VARCHAR(255) NOT NULL, 
    User_email VARCHAR(255) NOT NULL,
    User_password VARCHAR(255) NOT NULL,
    User_money INT,
    PRIMARY KEY (User_id)
    )";
    $pdo->exec($registeredTable);

    $registered = $pdo->query("SELECT * FROM Registered")->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
        $firstName = $_POST["registerFirstName"];
        $lastName = $_POST["registerLastName"];
        $email = $_POST["registerEmail"];
        $password = password_hash($_POST["registerPassword"], PASSWORD_DEFAULT);

        $checkEmail = $pdo->query("SELECT * FROM Registered WHERE User_email = '$email'")->fetch(PDO::FETCH_ASSOC);
        if ($checkEmail) {
            $notif = "Email already registered";
        } else {
            $sql = "INSERT INTO registered (User_first_name, User_last_name, User_email, User_password) VALUES ('$firstName', '$lastName', '$email', '$password')";
            $pdo->exec($sql);
            $notif = "Registered successfully";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
        $loginEmail = $_POST["loginEmail"];
        $loginPassword = $_POST["loginPassword"];

        $user = $pdo->query("SELECT * FROM Registered WHERE User_email = '$loginEmail'")->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($loginPassword, $user['User_password'])) {
            $_SESSION['user_id'] = $user['User_id'];
            $_SESSION['user_first_name'] = $user['User_first_name'];
            $_SESSION['user_last_name'] = $user['User_last_name'];
            $_SESSION['user_email'] = $user['User_email'];
            $_SESSION['user_password'] = $user['User_password'];

            $notif = "Logged in successfully as " . $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'];
        } else {
            $notif = "Invalid Email or Password";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateUserData"])) {
        $updateFirstName = $_POST["updateFirstName"];
        $updateLastName = $_POST["updateLastName"];
        $updateEmail = $_POST["updateEmail"];

        $sql = "UPDATE registered SET User_first_name = '$updateFirstName', User_last_name = '$updateLastName', User_email = '$updateEmail' WHERE User_id = '{$_SESSION['user_id']}'";
        $pdo->exec($sql);

        $notif = "Updated successfully as " . $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteAccount"])) {
        unset($_SESSION['user_id']);
        $sql = "DELETE FROM registered WHERE User_id = '{$_SESSION['user_id']}'";
        $pdo->exec($sql);
        $notif = "Account for " . $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'] . " successfully deleted.";
        session_destroy();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["resetPassword"])) {
        $updateEmail = $_POST["resetEmail"];
        $updatePassword = password_hash($_POST["reset"], PASSWORD_DEFAULT);

        $checkEmail = $pdo->query("SELECT * FROM Registered WHERE User_email = '$updateEmail'")->fetch(PDO::FETCH_ASSOC);
        if ($checkEmail) {
            $sql = "UPDATE registered SET User_password = '$updatePassword' WHERE User_id = '{$_SESSION['user_id']}'";
            $pdo->exec($sql);

            $_SESSION['user_password'] = $updatePassword;

            $notif = "Password reset successfully.";
        } else $notif = "Password failed to reset.";
    }

    $registered = $pdo->query("SELECT * FROM Registered")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register, Login & MySQL Databases</title>
    <link href="LAB13_Ex04.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="page">
    <div class="top-nav-header">
        <div class="top-nav-container">
            <div class="top-left-menu">
                <form action="LAB13_Ex04-3.php">
                    <button type="submit">Cart</button>
                </form>
            </div>
            <div class="top-right-menu">
                <div class="menu-item 1">
                    <form action="LAB13_Ex04-1.php">
                        <button type="submit">Main Page</button>
                    </form>
                </div>
                <div class="menu-item 2 bank">
                    <form action="LAB13_Ex04-4.php">
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
                    <input type="text" id="updateFirstName" name="updateFirstName"
                           value="<?= $_SESSION['user_first_name'] ?>" required>
                    <label for="updateLastName">Last Name:</label>
                    <input type="text" id="loginPassword" name="updateLastName"
                           value="<?= $_SESSION['user_last_name'] ?>" required>
                    <label for="updateEmail">Email:</label>
                    <input type="email" id="updateEmail" name="updateEmail" value="<?= $_SESSION['user_email'] ?>"
                           required>
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