<?php
$dbhost = 'localhost';
$dbuser = 'Misakuja';
$dbpass = '';
$dbname = 'LAB13Ex01';

try {
    $pdo = new PDO("mysql:host=$dbhost", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");

    $registeredTable = "CREATE TABLE IF NOT EXISTS Registered (
        User_id INT AUTO_INCREMENT PRIMARY KEY,
        User_first_name VARCHAR(255) NOT NULL,
        User_last_name VARCHAR(255) NOT NULL,
        User_email VARCHAR(255) NOT NULL,
        User_password VARCHAR(255) NOT NULL,
        User_money INT DEFAULT 0
    )";

    $cartTable = "CREATE TABLE IF NOT EXISTS Cart (
        User_id INT,
        Product_id INT,
        Quantity INT,
        PRIMARY KEY (User_id, Product_id),
        FOREIGN KEY (User_id) REFERENCES Registered(User_id)
    )";

    $pdo->exec($registeredTable);
    $pdo->exec($cartTable);

} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>
