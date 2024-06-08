<?php
$dbhost = 'localhost';
$dbuser = 'Misakuja';
$dbpass = '';
$dbname = 'LAB12Ex03';
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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
        $firstName = $_POST["registerFirstName"];
        $lastName = $_POST["registerLastName"];
        $email = $_POST["registerEmail"];
        $gender = $_POST["registerGender"];
        $password = password_hash($_POST["registerPassword"], PASSWORD_DEFAULT);

        $sql = "INSERT INTO registered (User_first_name, User_last_name, User_email, User_gender, User_password) VALUES ('$firstName', '$lastName', '$email', '$gender', '$password')";
        $pdo->exec($sql);
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
    <title>Register & MySQL Databases</title>
    <link href="LAB12_Ex03.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="formWrap">
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
</body>
</html>