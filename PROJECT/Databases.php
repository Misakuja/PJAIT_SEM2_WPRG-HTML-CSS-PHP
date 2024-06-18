<?php
$dbhost = 'localhost';
$dbuser = 'Misakuja';
$dbpass = '';
$dbname = 'Project';

try {
    $pdo = new PDO("mysql:host=$dbhost", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");

    $animalCategoriesTable = "CREATE TABLE IF NOT EXISTS animalcategories (
        category_id INT AUTO_INCREMENT PRIMARY KEY,
        category_name VARCHAR(100) NOT NULL UNIQUE,
        number_of_species INT,
        number_of_specimens INT                
    )";
    $pdo->exec($animalCategoriesTable);

    $speciesTable = "CREATE TABLE IF NOT EXISTS species (
        species_id INT AUTO_INCREMENT PRIMARY KEY,
        category_id INT,
        common_name VARCHAR(100) UNIQUE,
        scientific_name VARCHAR(100) UNIQUE,
        conservation_status TEXT,
        diet TEXT,
        behaviour TEXT,
        image TEXT,
        
        FOREIGN KEY (category_id) REFERENCES animalcategories (category_id)                        
    )";
    $pdo->exec($speciesTable);

    $animalsTable = "CREATE TABLE IF NOT EXISTS animals (
        animal_id INT AUTO_INCREMENT PRIMARY KEY,
        animal_name VARCHAR(100),
        species_id INT,
        habitat_id INT,
        date_of_birth DATE,
        description TEXT,
        image TEXT,
        
        FOREIGN KEY (species_id) REFERENCES species (species_id)
    )";
    $pdo->exec($animalsTable);

    $zookeepersTable = "CREATE TABLE IF NOT EXISTS zookeepers (
        zookeeper_id INT AUTO_INCREMENT PRIMARY KEY,
        zookeeper_first_name VARCHAR(255) NOT NULL,
        zookeeper_last_name VARCHAR(255) NOT NULL,
        zookeeper_email VARCHAR(255) NOT NULL UNIQUE,
        zookeeper_phone VARCHAR(255) NOT NULL UNIQUE,
        zookeeper_password VARCHAR(255) NOT NULL               
    )";
    $pdo->exec($zookeepersTable);

    $usersTable = "CREATE TABLE IF NOT EXISTS users (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        user_first_name VARCHAR(255) NOT NULL,
        user_last_name VARCHAR(255) NOT NULL,
        user_email VARCHAR(255) NOT NULL UNIQUE,
        user_password VARCHAR(255) NOT NULL
    )";
    $pdo->exec($usersTable);

    $ticketOrdersTable = "CREATE TABLE IF NOT EXISTS ticketorders (
        order_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        buyer_first_name VARCHAR(255) NOT NULL,
        buyer_last_name VARCHAR(255) NOT NULL,
        order_price FLOAT NOT NULL,
        normal_tickets_amount INT,
        reduced_tickets_amount INT,
        
        FOREIGN KEY (user_id) REFERENCES users (user_id)      
    )";
    $pdo->exec($ticketOrdersTable);

} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
