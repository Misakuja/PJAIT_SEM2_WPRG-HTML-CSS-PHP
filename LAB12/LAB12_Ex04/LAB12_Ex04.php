<?php
session_start();

$dbhost = 'localhost';
$dbuser = 'Misakuja';
$dbpass = '';
$dbname = 'LAB12Ex04';
$registered = null;
$user = null;
$notif = null;
$rowCount = null;
try {
    $pdo = new PDO("mysql:host=$dbhost", $dbuser, $dbpass);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");

    $registeredTable = "CREATE TABLE IF NOT EXISTS Registered ( 
    User_id INT AUTO_INCREMENT, 
    User_first_name VARCHAR(255) NOT NULL, 
    User_last_name VARCHAR(255) NOT NULL, 
    User_email VARCHAR(255) NOT NULL,
    User_gender ENUM('male', 'female', 'other') NOT NULL,
    User_password VARCHAR(255) NOT NULL,
    PRIMARY KEY (User_id)
    )";
    $pdo->exec($registeredTable);

    $registered = $pdo->query("SELECT * FROM Registered")->fetchAll(PDO::FETCH_ASSOC);

    $rowCount = $pdo->query("SELECT * FROM Registered")->rowCount();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
        $firstName = $_POST["registerFirstName"];
        $lastName = $_POST["registerLastName"];
        $email = $_POST["registerEmail"];
        $gender = $_POST["registerGender"];
        $password = password_hash($_POST["registerPassword"], PASSWORD_DEFAULT);

        $checkEmail = $pdo->query("SELECT * FROM Registered WHERE User_email = '$email'")->fetch(PDO::FETCH_ASSOC);
        if ($checkEmail) {
            $notif = "Email already registered";
        } else {
            $sql = "INSERT INTO registered (User_first_name, User_last_name, User_email, User_gender, User_password) VALUES ('$firstName', '$lastName', '$email', '$gender', '$password')";
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
            $_SESSION['user_gender'] = $user['User_gender'];
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
        $updateGender = $_POST["updateGender"];

        $sql = "UPDATE registered SET User_first_name = '$updateFirstName', User_last_name = '$updateLastName', User_email = '$updateEmail', User_gender = '$updateGender' WHERE User_id = '{$_SESSION['user_id']}'";
        $pdo->exec($sql);

        $notif = "Updated successfully as " . $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteAccount"])) {
        $sql = "DELETE FROM registered WHERE User_id = '{$_SESSION['user_id']}'";
        $pdo->exec($sql);
        $notif = "Account for " . $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'] . " successfully deleted.";
        unset($_SESSION['user_id']);
        unset($_SESSION['user_first_name']);
        unset($_SESSION['user_last_name']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_gender']);
        unset($_SESSION['user_password']);
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
    <link href="LAB12_Ex04.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="page">
    <?php if ($notif) : ?>
        <h1>Notifications:</h1>
        <p><?= $notif ?> </p>
    <?php endif ?>

    <div class="counter">
        <p>Amount of registered users: <?= $rowCount ?> </p>
    </div>

    <div class="formWrap register">
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
                <label for="registerGender">Gender:</label>
                <select id="registerGender" name="registerGender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <label>
                    <button type="submit" name="register">Register</button>
                </label>
            </fieldset>
        </form>
    </div>

    <div class="formWrap login">
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
    </div>


    <?php if (isset($_SESSION['user_id'])) : ?>
        <div class="formWrap edit">
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
                    <label for="updateGender">Gender:</label>
                    <select name="updateGender" id="updateGender">
                        <option value="male" <?php if ($_SESSION['user_gender'] == 'male') echo 'selected'; ?>>Male
                        </option>
                        <option value="female" <?php if ($_SESSION['user_gender'] == 'female') echo 'selected'; ?>>
                            Female
                        </option>
                        <option value="other" <?php if ($_SESSION['user_gender'] == 'other') echo 'selected'; ?>>Other
                        </option>
                    </select>
                    <button type="submit" name="updateUserData">Update</button>
                </fieldset>
            </form>
        </div>

        <div class="formWrap delete">
            <form method='post' action="">
                <fieldset>
                    <legend>Delete Account</legend>
                    <button type="submit" name="deleteAccount">Delete Account</button>
                </fieldset>
            </form>
        </div>

        <div class="formWrap reset">
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
    <?php endif ?>
</div>
</body>
</html>