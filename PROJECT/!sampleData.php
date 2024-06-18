<?php
require_once 'Databases.php';

$dbhost = 'localhost';
$dbuser = 'Misakuja';
$dbpass = '';
$dbname = 'Project';

try {
    $pdo = new PDO("mysql:host=$dbhost", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");

    $insertAnimalCategories = "INSERT IGNORE INTO animalcategories (category_name) VALUES
    ('Mammals'),
    ('Birds'),
    ('Reptiles'),
    ('Amphibians'),
    ('Fish')";
    $pdo->exec($insertAnimalCategories);

    $insertSpecies = "INSERT INTO species (category_id, common_name, scientific_name, conservation_status, diet, behaviour, image)
VALUES
    -- Mammals
    (1, 'Capybara', 'Hydrochoerus hydrochaeris', 'Least Concern', 'Herbivorous', 'Capybaras are social animals, usually found in groups of 10-20 individuals. They are semi-aquatic, often found near water bodies where they can swim and escape predators.', 'https://i.imgur.com/JxtP8uE.png'),
    (1, 'Hyrax', 'Procavia capensis', 'Least Concern', 'Herbivorous', 'Hyraxes are small, social mammals that live in rocky terrain. They are diurnal (active during the day) and communicate using various vocalizations.', 'https://i.imgur.com/rWEiDLw.png'),
    (1, 'African Elephant', 'Loxodonta africana', 'Vulnerable', 'Herbivorous', 'African elephants are highly social and live in matriarchal herds led by an older female. They have complex communication skills, including infrasound that travels long distances.', 'https://i.imgur.com/56ORra3.png'),
    (1, 'Cheetah', 'Acinonyx jubatus', 'Vulnerable', 'Carnivorous', 'Cheetahs are solitary hunters but may form small groups, especially mothers with cubs. They are known for their incredible speed and agility, capable of short bursts up to 60-70 mph.', 'https://i.imgur.com/DedTOu8.png'),
    (1, 'African Lion', 'Panthera leo', 'Vulnerable', 'Carnivorous', 'African lions are social cats that live in prides led by a dominant male. They are apex predators and exhibit cooperative hunting behaviors, often working together to bring down prey.', 'https://i.imgur.com/Nxd7epJ.png'),
    (1, 'Bengal Tiger', 'Panthera tigris tigris', 'Endangered', 'Carnivorous', 'Bengal tigers are solitary animals, except during mating or when females are with cubs. They are powerful hunters and are known for their striped coat pattern.', 'https://i.imgur.com/0qE1tkd.png'),
    (1, 'Snow Leopard', 'Panthera uncia', 'Vulnerable', 'Carnivorous', 'Snow leopards are solitary and elusive cats found in mountainous regions of Central and South Asia. They are well adapted to cold environments and are known for their agility and stealth in hunting.', ''),
    (1, 'Sand Cat', 'Felis margarita', 'Least Concern', 'Carnivorous', 'Sand cats are small, solitary cats adapted to desert environments. They are nocturnal and have large ears that help them detect prey and stay cool in hot climates.', 'https://i.imgur.com/WVHDDxD.png'),
    (1, 'Binturong', 'Arctictis binturong', 'Vulnerable', 'Omnivorous', 'Binturongs are arboreal (tree-dwelling) and nocturnal animals found in Southeast Asia. They are known for their prehensile tail, which helps them climb and maneuver in trees.', 'https://i.imgur.com/21zwqZ3.png'),
    -- Birds
    (2, 'Bald Eagle', 'Haliaeetus leucocephalus', 'Least Concern', 'Carnivorous', 'Bald eagles are majestic birds of prey found in North America. They are known for their white head and tail feathers.', 'https://i.imgur.com/BIvuW69.png'),
    (2, 'Penguin', 'Spheniscidae', 'Varies by species', 'Piscivorous', 'Penguins are flightless birds adapted to aquatic life. They are excellent swimmers and can be found in various regions from Antarctica to the Galápagos Islands.', 'https://i.imgur.com/RDIjmuj.png'),
    -- Reptiles
    (3, 'Green Anaconda', 'Eunectes murinus', 'Least Concern', 'Carnivorous', 'Green anacondas are massive snakes found in South America. They are aquatic and known for their ability to ambush and constrict large prey.', 'https://i.imgur.com/ddJbmyh.jpeg'),
    (3, 'Galápagos Tortoise', 'Chelonoidis nigra', 'Vulnerable', 'Herbivorous', 'Galápagos tortoises are giant tortoises found on the Galápagos Islands. They are long-lived and primarily herbivorous.', 'https://i.imgur.com/BZGCT8s.png'),
    -- Amphibians
    (4, 'Axolotl', 'Ambystoma mexicanum', 'Critically Endangered', 'Carnivorous', 'Axolotls are unique salamanders native to Mexico. They are known for their regenerative abilities and neoteny, retaining larval features throughout their lives.', 'https://i.imgur.com/5kThq4Z.png'),
    (4, 'Red-eyed Tree Frog', 'Agalychnis callidryas', 'Least Concern', 'Insectivorous', 'Red-eyed tree frogs are colorful amphibians found in Central America. They are arboreal and primarily feed on insects.', 'https://i.imgur.com/aHxir0L.png'),
    (4, 'Poison Dart Frog', 'Dendrobatidae', 'Varies by species', 'Insectivorous', 'Poison dart frogs are small but brightly colored frogs found in Central and South America. They secrete toxins through their skin for defense against predators.', 'https://i.imgur.com/OUuE5Vx.png');";
    $pdo->exec($insertSpecies);


    $insertAnimals = "INSERT IGNORE INTO animals (animal_name, species_id, habitat_id, date_of_birth, description, image) VALUES
    ('Capybara 1', (SELECT species_id FROM species WHERE common_name = 'Capybara'), 1, '2019-05-15', 'This capybara enjoys swimming in rivers and grazing on grassy banks.', 'https://i.imgur.com/JxtP8uE.png'),
    ('Hyrax 1', (SELECT species_id FROM species WHERE common_name = 'Hyrax'), 2, '2018-09-20', 'A rock hyrax known for its agile movements among rocky outcrops.', 'https://i.imgur.com/rWEiDLw.png'),
    ('African Elephant 1', (SELECT species_id FROM species WHERE common_name = 'African Elephant'), 3, '2010-07-12', 'An African elephant known for its large tusks and wise demeanor.', 'https://i.imgur.com/56ORra3.png'),
    ('Cheetah 1', (SELECT species_id FROM species WHERE common_name = 'Cheetah'), 4, '2015-03-10', 'This cheetah is a skilled sprinter and an expert hunter on the savannah.', 'https://i.imgur.com/DedTOu8.png'),
    ('African Lion 1', (SELECT species_id FROM species WHERE common_name = 'African Lion'), 5, '2017-12-25', 'A majestic African lion, part of a pride led by a dominant male.', 'https://i.imgur.com/Nxd7epJ.png'),
    ('Bengal Tiger 1', (SELECT species_id FROM species WHERE common_name = 'Bengal Tiger'), 6, '2016-08-18', 'A powerful Bengal tiger with distinctive stripes, known for its solitary nature.', 'https://i.imgur.com/0qE1tkd.png'),
    ('Snow Leopard 1', (SELECT species_id FROM species WHERE common_name = 'Snow Leopard'), 7, '2014-11-30', 'An elusive snow leopard adapted to its mountainous habitat.', ''),
    ('Sand Cat 1', (SELECT species_id FROM species WHERE common_name = 'Sand Cat'), 8, '2020-02-05', 'A nocturnal sand cat with large ears for detecting prey in desert climates.', 'https://i.imgur.com/WVHDDxD.png'),
    ('Binturong 1', (SELECT species_id FROM species WHERE common_name = 'Binturong'), 9, '2012-04-03', 'This binturong uses its prehensile tail to navigate its tree-dwelling habitat.', 'https://i.imgur.com/21zwqZ3.png'),
    ('Bald Eagle 1', (SELECT species_id FROM species WHERE common_name = 'Bald Eagle'), 10, '2018-06-08', 'A proud bald eagle, symbolizing freedom and strength in flight.', 'https://i.imgur.com/BIvuW69.png'),
    ('Penguin 1', (SELECT species_id FROM species WHERE common_name = 'Penguin'), 11, '2015-01-20', 'An agile penguin, perfectly adapted to life in the frigid waters of Antarctica.', 'https://i.imgur.com/RDIjmuj.png'),
    ('Green Anaconda 1', (SELECT species_id FROM species WHERE common_name = 'Green Anaconda'), 12, '2013-09-14', 'A massive green anaconda known for its ambush hunting style in South American rivers.', 'https://i.imgur.com/ddJbmyh.jpeg'),
    ('Galápagos Tortoise 1', (SELECT species_id FROM species WHERE common_name = 'Galápagos Tortoise'), 13, '2005-03-28', 'A Galápagos tortoise, one of the oldest living species, peacefully grazing on vegetation.', 'https://i.imgur.com/BZGCT8s.png'),
    ('Axolotl 1', (SELECT species_id FROM species WHERE common_name = 'Axolotl'), 14, '2017-07-01', 'An axolotl displaying its unique neotenic features and regenerative abilities.', 'https://i.imgur.com/5kThq4Z.png'),
    ('Red-eyed Tree Frog 1', (SELECT species_id FROM species WHERE common_name = 'Red-eyed Tree Frog'), 15, '2019-10-10', 'A vibrant red-eyed tree frog perched on a leaf in its Central American rainforest habitat.', 'https://i.imgur.com/aHxir0L.png'),
    ('Poison Dart Frog 1', (SELECT species_id FROM species WHERE common_name = 'Poison Dart Frog'), 16, '2016-04-22', 'A colorful poison dart frog, warning predators with its bright hues.', 'https://i.imgur.com/OUuE5Vx.png')
    ;";
    $pdo->exec($insertAnimals);


    $password1 = password_hash("password123", PASSWORD_DEFAULT);
    $insertZookeepers = "INSERT IGNORE INTO zookeepers (zookeeper_first_name, zookeeper_last_name, zookeeper_email, zookeeper_phone, zookeeper_password) VALUES
        ('John', 'Doe', 'john.doe@example.com', '555-1234', '$password1'),
        ('Jane', 'Smith', 'jane.smith@example.com', '555-5678', '$password1'),
        ('Alice', 'Johnson', 'alice.johnson@example.com', '555-8765', '$password1'),
        ('Bob', 'Brown', 'bob.brown@example.com', '555-4321', '$password1'),
        ('Charlie', 'Davis', 'charlie.davis@example.com', '555-9101', '$password1');";
    $pdo->exec($insertZookeepers);

} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
