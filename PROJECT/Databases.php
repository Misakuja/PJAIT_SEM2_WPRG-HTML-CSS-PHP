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


    $insertAnimalCategories = "INSERT IGNORE INTO animalcategories (category_name) VALUES
    ('Mammals'),
    ('Birds'),
    ('Reptiles'),
    ('Amphibians'),
    ('Fish'),
    ('Insects'),
    ('Arachnids')";
    $pdo->exec($insertAnimalCategories);


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

    $insertSpecies = "INSERT IGNORE INTO species (category_id, common_name, scientific_name, conservation_status, diet, behaviour) VALUES
    (1, 'Capybara', 'Hydrochoerus hydrochaeris', 'Least Concern', 'Herbivore', 'Social, lives in groups'),
    (1, 'Binturong', 'Arctictis binturong', 'Vulnerable', 'Omnivore', 'Nocturnal, solitary'),
    (1, 'Hyrax', 'Procavia capensis', 'Least Concern', 'Herbivore', 'Lives in colonies'),
    (1, 'Sand Cat', 'Felis margarita', 'Least Concern', 'Carnivore', 'Nocturnal, solitary'),
    (1, 'Cheetah', 'Acinonyx jubatus', 'Vulnerable', 'Carnivore', 'Fastest land animal'),
    (2, 'Bald Eagle', 'Haliaeetus leucocephalus', 'Least Concern', 'Carnivore', 'Solitary, monogamous'),
    (2, 'Peregrine Falcon', 'Falco peregrinus', 'Least Concern', 'Carnivore', 'Fastest bird, solitary'),
    (3, 'Green Iguana', 'Iguana iguana', 'Least Concern', 'Herbivore', 'Diurnal, solitary'),
    (4, 'Red-eyed Tree Frog', 'Agalychnis callidryas', 'Least Concern', 'Insectivore', 'Nocturnal, arboreal'),
    (5, 'Clownfish', 'Amphiprioninae', 'Least Concern', 'Omnivore', 'Symbiotic relationship with anemones'),
    (6, 'Monarch Butterfly', 'Danaus plexippus', 'Least Concern', 'Herbivore', 'Migratory, social'),
    (7, 'Tarantula', 'Theraphosidae', 'Least Concern', 'Carnivore', 'Solitary, nocturnal')";

    $pdo->exec($insertSpecies);


    $animalsTable = "CREATE TABLE IF NOT EXISTS animals (
        animal_id INT AUTO_INCREMENT PRIMARY KEY,
        animaL_name VARCHAR(100),
        species_id INT,
        habitat_id INT,
        date_of_birth DATE,
        description TEXT,
        image TEXT,
        
        FOREIGN KEY (species_id) REFERENCES species (species_id)
    )";
    $pdo->exec($animalsTable);

    $insertAnimals = "INSERT IGNORE INTO animals (animal_name, species_id, habitat_id, date_of_birth, description) VALUES
    ('Charlie', 1, 1, '2015-03-15', 'A friendly capybara.'),
    ('Binky', 2, 1, '2017-05-20', 'Loves climbing trees.'),
    ('Rex', 3, 1, '2016-08-30', 'Often seen sunbathing.'),
    ('Sandy', 4, 1, '2018-10-10', 'Excellent night hunter.'),
    ('Speedy', 5, 1, '2014-07-07', 'Fastest animal in the zoo.'),
    ('Freedom', 6, 2, '2013-01-12', 'Symbol of freedom.'),
    ('Flash', 7, 2, '2015-04-22', 'Fastest bird in the sky.'),
    ('Iggy', 8, 3, '2019-02-11', 'Loves to bask in the sun.'),
    ('Red', 9, 4, '2018-11-23', 'Colorful and active at night.'),
    ('Nemo', 10, 5, '2017-09-14', 'Always seen with anemones.'),
    ('Monarch', 11, 6, '2020-06-15', 'Migrates long distances.'),
    ('Tara', 12, 7, '2016-12-18', 'Solitary and nocturnal hunter.'),
    ('Charlie', 1, 1, '2015-03-15', 'A friendly capybara.'),
    ('Binky', 2, 1, '2017-05-20', 'Loves climbing trees.'),
    ('Rex', 3, 1, '2016-08-30', 'Often seen sunbathing.'),
    ('Sandy', 4, 1, '2018-10-10', 'Excellent night hunter.'),
    ('Speedy', 5, 1, '2014-07-07', 'Fastest animal in the zoo.'),
    ('Freedom', 6, 2, '2013-01-12', 'Symbol of freedom.'),
    ('Flash', 7, 2, '2015-04-22', 'Fastest bird in the sky.'),
    ('Iggy', 8, 3, '2019-02-11', 'Loves to bask in the sun.'),
    ('Red', 9, 4, '2018-11-23', 'Colorful and active at night.'),
    ('Nemo', 10, 5, '2017-09-14', 'Always seen with anemones.'),
    ('Monarch', 11, 6, '2020-06-15', 'Migrates long distances.'),
    ('Tara', 12, 7, '2016-12-18', 'Solitary and nocturnal hunter.')";

    $pdo->exec($insertAnimals);

    $zookeepersTable = "CREATE TABLE IF NOT EXISTS zookeepers (
        zookeeper_id INT AUTO_INCREMENT PRIMARY KEY,
        zookeeper_first_name VARCHAR(255) NOT NULL,
        zookeeper_last_name VARCHAR(255) NOT NULL,
        zookeeper_email VARCHAR(255) NOT NULL,
        zookeeper_phone VARCHAR(255) NOT NULL,
        zookeeper_password VARCHAR(255) NOT NULL               
    )";
    $pdo->exec($zookeepersTable);

    $insertZookeepers = "INSERT IGNORE INTO zookeepers (zookeeper_first_name, zookeeper_last_name, zookeeper_email, zookeeper_phone, zookeeper_password) VALUES
        ('John', 'Doe', 'john.doe@example.com', '555-1234', 'password123'),
        ('Jane', 'Smith', 'jane.smith@example.com', '555-5678', 'password456'),
        ('Alice', 'Johnson', 'alice.johnson@example.com', '555-8765', 'password789'),
        ('Bob', 'Brown', 'bob.brown@example.com', '555-4321', 'password012'),
        ('Charlie', 'Davis', 'charlie.davis@example.com', '555-9101', 'password345');";

    $pdo->exec($insertZookeepers);


    $usersTable = "CREATE TABLE IF NOT EXISTS users (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        user_first_name VARCHAR(255) NOT NULL,
        user_last_name VARCHAR(255) NOT NULL,
        user_email VARCHAR(255) NOT NULL,
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
