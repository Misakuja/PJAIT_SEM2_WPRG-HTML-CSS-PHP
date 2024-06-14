<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require_once 'databases.php';
global $pdo;

$registered = null;
$user = null;
$notif = null;
$rowCount = null;

// Logout
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    unset($_SESSION['user_id']);
    session_destroy();
}

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
        $sql = "INSERT INTO Registered (User_first_name, User_last_name, User_email, User_password) VALUES ('$firstName', '$lastName', '$email', '$password')";
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
        $_SESSION['user_money'] = $user['User_money'];

        $notif = "Logged in successfully as " . $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'];
    } else {
        $notif = "Invalid Email or Password";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateUserData"])) {
    $updateFirstName = $_POST["updateFirstName"];
    $updateLastName = $_POST["updateLastName"];
    $updateEmail = $_POST["updateEmail"];

    $sql = "UPDATE Registered SET User_first_name = '$updateFirstName', User_last_name = '$updateLastName', User_email = '$updateEmail' WHERE User_id = '{$_SESSION['user_id']}'";
    $pdo->exec($sql);

    $_SESSION['user_first_name'] = $updateFirstName;
    $_SESSION['user_last_name'] = $updateLastName;
    $_SESSION['user_email'] = $updateEmail;

    $notif = "Updated successfully.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteAccount"])) {
    $sql = "DELETE FROM Registered WHERE User_id = '{$_SESSION['user_id']}'";
    $pdo->exec($sql);

    $notif = "Account for " . $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'] . " successfully deleted.";
    unset($_SESSION['user_id']);
    session_destroy();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["resetPassword"])) {
    $resetEmail = $_POST["resetEmail"];
    $resetPassword = password_hash($_POST["resetPassword"], PASSWORD_DEFAULT);

    $checkEmail = $pdo->query("SELECT * FROM Registered WHERE User_email = '$resetEmail'")->fetch(PDO::FETCH_ASSOC);
    if ($checkEmail) {
        $sql = "UPDATE Registered SET User_password = '$resetPassword' WHERE User_email = '$resetEmail'";
        $pdo->exec($sql);

        $notif = "Password reset successfully.";
    } else {
        $notif = "Password reset failed.";
    }
}

$registered = $pdo->query("SELECT * FROM Registered")->fetchAll(PDO::FETCH_ASSOC);