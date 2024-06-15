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

    $animalCategoriesTable = "CREATE TABLE IF NOT EXISTS AnimalCategories (
        category_id INT AUTO_INCREMENT PRIMARY KEY,
        category_name INT,
        number_of_species INT,
        number_of_specimens INT                
    )";

    $speciesTable = "CREATE TABLE IF NOT EXISTS Species (
        species_id INT AUTO_INCREMENT PRIMARY KEY,
        category_id INT,
        common_name VARCHAR(100),
        scientific_name VARCHAR(100),
        conservation_status TEXT,
        diet TEXT,
        behaviour TEXT,
        image TEXT,
        
        FOREIGN KEY (category_id) REFERENCES Category (category_id)                        
    )";

    $animalsTable = "CREATE TABLE IF NOT EXISTS Animals (
        animal_id INT AUTO_INCREMENT PRIMARY KEY,
        animaL_name VARCHAR(100),
        species_id INT,
        habitat_id INT,
        date_of_birth DATE,
        description TEXT,
        image TEXT,
        
        FOREIGN KEY (species_id) REFERENCES Species (species_id)
    )";

    $zookeepersTable = "CREATE TABLE IF NOT EXISTS zookeepersTable (
        zookeeper_id INT AUTO_INCREMENT PRIMARY KEY,
        zookeeper_first_name VARCHAR(255) NOT NULL,
        zookeeper_last_name VARCHAR(255) NOT NULL,
        zookeeper_email VARCHAR(255) NOT NULL,
        zookeeper_phone VARCHAR(255) NOT NULL,
        zookeeper_password VARCHAR(255) NOT NULL               
    )";

    $usersTable = "CREATE TABLE IF NOT EXISTS Users (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        user_first_name VARCHAR(255) NOT NULL,
        user_last_name VARCHAR(255) NOT NULL,
        user_email VARCHAR(255) NOT NULL,
        user_password VARCHAR(255) NOT NULL
    )";

    $ticketsTable = "CREATE TABLE IF NOT EXISTS Tickets (
        ticket_id INT AUTO_INCREMENT PRIMARY KEY,
        buyer_first_name VARCHAR(255) NOT NULL,
        buyer_last_name VARCHAR(255) NOT NULL,
        ticket_date DATE NOT NULL,
        adult_tickets_amount INT,
        child_tickets_amount INT       
    )";

    $pdo->exec($animalCategoriesTable);
    $pdo->exec($speciesTable);
    $pdo->exec($animalsTable);

    $pdo->exec($zookeepersTable);
    $pdo->exec($usersTable);
    $pdo->exec($ticketsTable);

} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>
