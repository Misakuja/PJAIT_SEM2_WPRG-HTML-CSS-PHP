<?php
session_start();
require_once 'PageInterface.php';
require_once 'databases.php';
global $pdo;

class PageFunctionality implements PageInterface {

    public function sendMail(): void {
        $name = $_POST['contactFormName'];
        $mail = $_POST['contactFormMail'];
        $phone = $_POST['contactFormPhone'];
        $message = $_POST['contactFormMessage'];

        $headers = "From: $name <$mail>\r\n <$phone>\r\n";

        $message = wordwrap($message, 70);

        mail('contact@zoo.com', 'Contact Form Message', $message, $headers);
    }

    public function registerUser() : void {
        global $pdo;
        $firstName = $_POST["registerFirstName"];
        $lastName = $_POST["registerLastName"];
        $email = $_POST["registerEmail"];
        $password = password_hash($_POST["registerPassword"], PASSWORD_DEFAULT);

        $checkEmail = $pdo->query("SELECT * FROM users WHERE user_email = '$email'")->fetch(PDO::FETCH_ASSOC);
        if ($checkEmail) {
            $_SESSION['notification'] = "Email already registered";
        } else {
            $sql = "INSERT INTO users (user_first_name, user_last_name, user_email, user_password) VALUES ('$firstName', '$lastName', '$email', '$password')";
            $pdo->exec($sql);
            $_SESSION['notification'] = "Registered successfully";
        }
    }

    public function loginUser() : void {
        global $pdo;
        $loginEmail = $_POST["loginEmail"];
        $loginPassword = $_POST["loginPassword"];

        $user = $pdo->query("SELECT * FROM users WHERE user_email = '$loginEmail'")->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($loginPassword, $user['user_password'])) {
            $_SESSION['user_id'] = $user['user_id'];

            $_SESSION['notification'] = "Logged in successfully as " . $user['user_first_name'] . " " . $user['user_last_name'];
        } else {
            $_SESSION['notification'] = "Invalid Email or Password";
        }
    }

    public function resetPasswordUser() : void {
        global $pdo;
        $resetEmail = $_POST["resetEmail"];
        $resetPassword = password_hash($_POST["resetPassword"], PASSWORD_DEFAULT);

        $checkEmail = $pdo->query("SELECT * FROM users WHERE user_email = '$resetEmail'")->fetch(PDO::FETCH_ASSOC);
        if ($checkEmail) {
            $sql = "UPDATE users SET user_password = '$resetPassword' WHERE user_email = '$resetEmail'";
            $pdo->exec($sql);

            $_SESSION['notification'] = "Password reset successfully.";
        } else {
            $_SESSION['notification'] = "Password reset failed.";
        }
    }

    public function logoutUser() : void {
        unset($_SESSION['user_id']);
        session_destroy();
    }
}